<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile () {
        return view('profile.profile');
    }

    public function parcels () {
        return view('profile.parcels');
    }

    public function settings () {
        return view('profile.settings');
    }

    public function balance () {
        return view('profile.balance');
    }

    public function referal () {
        return view('profile.referal');
    }

    public function transactions () {
        return view('profile.transactions');
    }

    public function nsettings () {
        return view('profile.nsettings');
    }
}
