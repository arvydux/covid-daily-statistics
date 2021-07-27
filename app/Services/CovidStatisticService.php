<?php

namespace App\Services;

use App\Models\Country;
use Carbon\Carbon;
use GuzzleHttp\Client;

/**
 * Class CovidStatisticService
 * @package App\Services
 */
class CovidStatisticService
{
    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTotalCovidData()
    {
        $httpClient = new Client();
        $request = $httpClient->get("https://api.covid19api.com/summary");

        $response = json_decode($request->getBody()->getContents());

        foreach ($response->Countries as $country){
            Country::updateOrCreate(
                ['country' => $country->Country],
                ['country' => $country->Country,
                    'new_confirmed' => $country->NewConfirmed,
                    'total_confirmed' => $country->TotalConfirmed,
                    'new_deaths' => $country->NewDeaths,
                    'total_deaths' => $country->TotalDeaths,
                    'new_recovered' => $country->NewRecovered,
                    'total_recovered' => $country->TotalRecovered,
                    'date' =>  Carbon::parse($country->Date)]
            );
        }
        return $response;
    }
}
