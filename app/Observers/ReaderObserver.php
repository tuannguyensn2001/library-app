<?php

namespace App\Observers;

use App\Http\Middleware\Auth;
use App\Models\Reader;

class ReaderObserver
{
    /**
     * Handle the Reader "created" event.
     *
     * @param  \App\Models\Reader  $reader
     * @return void
     */
    public function created(Reader $reader)
    {
        //
    }

    public function creating(Reader $reader)
    {

    }

    /**
     * Handle the Reader "updated" event.
     *
     * @param  \App\Models\Reader  $reader
     * @return void
     */
    public function updated(Reader $reader)
    {

    }

    public function updating(Reader $reader)
    {
        $reader->updated_by = \Illuminate\Support\Facades\Auth::user()->id;
    }

    /**
     * Handle the Reader "deleted" event.
     *
     * @param  \App\Models\Reader  $reader
     * @return void
     */
    public function deleted(Reader $reader)
    {
        //
    }

    /**
     * Handle the Reader "restored" event.
     *
     * @param  \App\Models\Reader  $reader
     * @return void
     */
    public function restored(Reader $reader)
    {
        //
    }

    /**
     * Handle the Reader "force deleted" event.
     *
     * @param  \App\Models\Reader  $reader
     * @return void
     */
    public function forceDeleted(Reader $reader)
    {
        //
    }
}
