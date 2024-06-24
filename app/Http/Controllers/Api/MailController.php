<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactShipped;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MailController extends Controller
{
    public function test(Request $request)
    {
        Mail::to('info@oryx.kz')->send(new ContactShipped([], 'Test message', 'No phone', 'KZ'));

        return response()->json(['message' => 'Test email sent successfully']);
    }

    public function send(Request $request, $domain = 'ae')
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();
        $message = Arr::get($request, 'message', 'no message');
        $phone = Arr::get($request, 'phone', 'no phone');
        $country = 'KZ';
        
        Mail::to('info@oryx.kz')->send(new ContactShipped($validated, $message, $phone, $country));

        return response()->json(['status' => 'success', 'message' => 'Email sent successfully']);
    }
}
