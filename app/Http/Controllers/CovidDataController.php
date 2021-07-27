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
        ]);

    }

    public function updateData()
    {
        $job = new GetCovidData();
        $data = $this->dispatch($job);
    }
}
