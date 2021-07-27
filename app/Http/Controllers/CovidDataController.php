<?php

namespace App\Http\Controllers;

use App\Jobs\GetCovidData;
use App\Models\Country;

/**
 * Class CovidDataController
 * @package App\Http\Controllers
 */
class CovidDataController extends Controller
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function refreshTable()
    {
        $countries = Country::all();

        return view('index', [
            'countries' => $countries,
            'last_updated_at' => $countries[0]->date
        ]);

    }

    public function updateData()
    {
        $job = new GetCovidData();
        $this->dispatch($job);
    }
}
