<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class CarController extends Controller {
    public function available() {
        $currentDate = Carbon::now()->toDateString();

        $cacheKey = 'car_configurations:' . $currentDate;

        $formattedResult = Cache::remember($cacheKey, 600, function () use ($currentDate) {
            $cars = Car::with(['configurations' => function ($query) use ($currentDate) {
                $query->with(['options'])
                    ->whereHas('prices', function ($query) use ($currentDate) {
                        $query->where('start_date', '<=', $currentDate)
                            ->where(function ($q) use ($currentDate) {
                                $q->whereNull('end_date')
                                    ->orWhere('end_date', '>=', $currentDate);
                            });
                    })
                ;
            }])->get();

            return $this->formatCarData($cars);
        });

        return response()->json($formattedResult);
    }

    private function formatCarData($cars)
    {
        return $cars->map(function ($car) {
            return [
                'id' => $car->id,
                'name' => $car->name,
                'configurations' => $car->configurations->map(function ($configuration) {
                    return [
                        'id' => $configuration->id,
                        'name' => $configuration->name,
                        'options' => $configuration->options->pluck('name'),
                        'current_price' => $configuration->prices->first()->price ?? null,
                    ];
                }),
            ];
        });
    }
}
