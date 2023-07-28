<?php

namespace App\Observers;
use App\Http\Controllers\Controller;
use App\Models\Parcel;

class ParcelObserver
{
    /**
     * Handle the Parcel "created" event.
     *
     * @param  \App\Models\Parcel  $parcel
     * @return void
     */
    public function created(Parcel $parcel)
    {
        //
    }

    /**
     * Handle the Parcel "updated" event.
     *
     * @param  \App\Models\Parcel  $parcel
     * @return void
     */
    public function updated(Parcel $parcel)
    {
        $ch = $parcel->getChanges();
        $ctrl = new Controller();
        if (isset($ch['status']))
            $ctrl->sendNotifiaction($parcel->user, 'status_'.$parcel->status, array_merge(['fio'=>$parcel->user->fio], $parcel->toArray()));
    }

    /**
     * Handle the Parcel "deleted" event.
     *
     * @param  \App\Models\Parcel  $parcel
     * @return void
     */
    public function deleted(Parcel $parcel)
    {
        //
    }

    /**
     * Handle the Parcel "restored" event.
     *
     * @param  \App\Models\Parcel  $parcel
     * @return void
     */
    public function restored(Parcel $parcel)
    {
        //
    }

    /**
     * Handle the Parcel "force deleted" event.
     *
     * @param  \App\Models\Parcel  $parcel
     * @return void
     */
    public function forceDeleted(Parcel $parcel)
    {
        //
    }
}
