<?php

namespace App\Observers;

use App\Models\Activities;

class ActivityObserver
{
    /**
     * Handle the Activities "created" event.
     *
     * @param  \App\Models\Activities  $activities
     * @return void
     */
    public function created(Activities $activities)
    {
        //
    }

    /**
     * Handle the Activities "updated" event.
     *
     * @param  \App\Models\Activities  $activities
     * @return void
     */
    public function updated(Activities $activities)
    {
        dd($activities);
    }

    /**
     * Handle the Activities "deleted" event.
     *
     * @param  \App\Models\Activities  $activities
     * @return void
     */
    public function deleted(Activities $activities)
    {
        dd($activities);
    }

    /**
     * Handle the Activities "restored" event.
     *
     * @param  \App\Models\Activities  $activities
     * @return void
     */
    public function restored(Activities $activities)
    {
        dd($activities);
    }

    /**
     * Handle the Activities "force deleted" event.
     *
     * @param  \App\Models\Activities  $activities
     * @return void
     */
    public function forceDeleted(Activities $activities)
    {
        dd($activities);
    }
}
