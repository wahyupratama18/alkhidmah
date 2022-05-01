<?php

namespace App\Observers;

use App\Models\Temp;
use Illuminate\Support\Facades\Storage;

class TempObserver
{
    /**
     * Handle the Temp "created" event.
     *
     * @param  \App\Models\Temp  $temp
     * @return void
     */
    public function created(Temp $temp)
    {
        $this->removeTemps();
    }

    /**
     * Handle the Temp "updated" event.
     *
     * @param  \App\Models\Temp  $temp
     * @return void
     */
    public function updated(Temp $temp)
    {
        $this->removeTemps();
    }

    /**
     * Handle the Temp "deleted" event.
     *
     * @param  \App\Models\Temp  $temp
     * @return void
     */
    public function deleted(Temp $temp)
    {
        //
    }

    /**
     * Handle the Temp "restored" event.
     *
     * @param  \App\Models\Temp  $temp
     * @return void
     */
    public function restored(Temp $temp)
    {
        //
    }

    /**
     * Handle the Temp "force deleted" event.
     *
     * @param  \App\Models\Temp  $temp
     * @return void
     */
    public function forceDeleted(Temp $temp)
    {
        //
    }

    /**
     * Temp Deletion
     *
     * @return void
     */
    public function removeTemps(): void
    {
        $id = Temp::where('created_at', '<', now()->subHours(2))
        ->get()
        ->each(fn($item) => Storage::delete($item->path))
        ->pluck('id');

        Temp::whereIn('id', $id)->delete();
    }
}
