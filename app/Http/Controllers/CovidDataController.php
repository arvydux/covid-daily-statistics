<?php

namespace App\Http\Controllers;

use App\Jobs\GetCovidData;
use App\Models\Country;
use Illuminate\Http\Request;


class CovidDataController extends Controller
{

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
