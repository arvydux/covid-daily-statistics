<?php

namespace App\Http\Controllers;

use App\Services\CovidStatisticService;
use Illuminate\Http\Request;

/**
 * Class CovidDataController
 * @package App\Http\Controllers
 */
class CovidDataController extends Controller
{

    public function showCovidData(CovidStatisticService $covidStatisticService, Request $request)
    {
        $countriesNames = $covidStatisticService->getAllCountriesNames();
        $singleCountryData = $covidStatisticService->getDataByRequest($request);
        $latestUpdatedData = $covidStatisticService->getUpdatedDataFromDB();

        return view('index', [
            'countriesNames' => $countriesNames,
            'singleCountryData' => $singleCountryData,
            'countries' => $latestUpdatedData['countries'],
            'lastUpdatedAt' => $latestUpdatedData['lastUpdatedAt'],
        ]);
    }
}
