<?php

namespace App\Listeners;

use App\Events\NumberAdded;
use App\Services\NumberPreferencesService;
use Illuminate\Support\Facades\App;

class AddDefaultPreferencesToNumberAdded
{
    public NumberPreferencesService $service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->service = App::make(NumberPreferencesService::class);
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\NumberAdded $event
     * @return void
     * @throws \App\Exceptions\NumberPreferencesCreatedException
     */
    public function handle(NumberAdded $event)
    {
        $this->service->addNumberPreference($event->number->id, 'auto_attendant', '1');
        $this->service->addNumberPreference($event->number->id, 'voicemail_enabled', '1');
    }
}
