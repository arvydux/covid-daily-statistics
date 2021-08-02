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
    /**
     * @param CovidStatisticService $covidStatisticService
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function showCovidData(CovidStatisticService $covidStatisticService, Request $request)
    {
        $countryNamesList = $covidStatisticService->getAllCountryNamesList();
        $singleCountryData = $covidStatisticService->getDataByRequest($request);
        $latestUpdatedData = $covidStatisticService->getDataFromDB();

        return view('index', [
            'countryNamesList' => $countryNamesList,
            'singleCountryName' => $singleCountryData['countryName'],
            'singleCountryData' => $singleCountryData['countryData'],
            'countries' => $latestUpdatedData['countries'],
            'lastUpdatedAt' => $latestUpdatedData['lastUpdatedAt'],
        ]);
    }
}
