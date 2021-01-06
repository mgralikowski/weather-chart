<?php

namespace App\Http\Controllers;

use Cache;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;

class MainController extends Controller
{
    /**
     * @param  string $city
     * @return View
     */
    public function index($city = null): View
    {
        $cities  = config('services.openweather.cities');
        $current = $city ?? $cities[0];

        // @todo Move to service class.

        $response = Cache::remember('openweather', 60, function () use ($current) {
            return Http::get('api.openweathermap.org/data/' . config('services.openweather.version') . '/forecast', [
                'q'     => $current,
                'appid' => config('services.openweather.api_key'),
                'units' => config('services.openweather.units'),
            ])->object();
        });

        foreach (config('services.openweather.map') as $name => $attribute) {
            $$name = collect();
        }

        foreach ($response->list as $forecast) {
            $timestamp = Carbon::parse($forecast->dt)->getPreciseTimestamp(3);

            foreach (config('services.openweather.map') as $name => $attribute) {
                $$name->push([$timestamp, $forecast->main->$attribute]);
            }
        }

        return view('main')
            ->with('cities', config('services.openweather.cities'))
            ->with('current', $current)
            ->with(compact(array_keys(config('services.openweather.map'))));
    }
}
