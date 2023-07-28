<?php

namespace App\Observers;

use App\Models\Recipient;

class RecipientObserver
{
    /**
     * Handle the Recipient "created" event.
     *
     * @param  \App\Models\Recipient  $recipient
     * @return void
     */
    public function created(Recipient $recipient)
    {
        //
    }

    public function updating(Recipient $recipient)
    {
        $recipient->fio = $recipient->surname.' '.$recipient->name.' '.$recipient->fname;
    }

    /**
     * Handle the Recipient "updated" event.
     *
     * @param  \App\Models\Recipient  $recipient
     * @return void
     */
    public function updated(Recipient $recipient)
    {
        //
    }

    /**
     * Handle the Recipient "deleted" event.
     *
     * @param  \App\Models\Recipient  $recipient
     * @return void
     */
    public function deleted(Recipient $recipient)
    {
        //
    }

    /**
     * Handle the Recipient "restored" event.
     *
     * @param  \App\Models\Recipient  $recipient
     * @return void
     */
    public function restored(Recipient $recipient)
    {
        //
    }

    /**
     * Handle the Recipient "force deleted" event.
     *
     * @param  \App\Models\Recipient  $recipient
     * @return void
     */
    public function forceDeleted(Recipient $recipient)
    {
        //
    }
}
