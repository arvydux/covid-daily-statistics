<?php

namespace App\Services;

use App\Models\Country;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

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
    public function getAllCountriesNames()
    {
        $httpClient = new Client();
        $request = $httpClient->get("https://api.covid19api.com/countries");
        $unsortedCountriesNames = json_decode($request->getBody()->getContents());
        foreach ($unsortedCountriesNames as $item){
            $countriesNames[$item->Slug] = $item->Country;
        };
        asort($countriesNames);
        return $countriesNames;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDataByRequest(Request $request)
    {
        if ($request['from']) {
            $from = Carbon::createFromFormat('Y-m-d', $request['from'])->startOfDay()->toIso8601ZuluString();
        } else {
            $from = Carbon::today()->subMonth(1)->startOfDay()->toIso8601ZuluString();;
        }

        if ($request['to']) {
            $to = Carbon::createFromFormat('Y-m-d', $request['to'])->startOfDay()->toIso8601ZuluString();
        } else {
            $to = Carbon::today()->startOfDay()->toIso8601ZuluString();;
        }

        if (!$request['country']) {
            $request['country'] = 'lithuania';
        }

        $httpClient = new Client();
        $request = $httpClient->get("https://api.covid19api.com/country/${request['country']}?from=${from}&to=${to}");
        return $response = json_decode($request->getBody()->getContents());
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */

    public function getUpdatedDataFromDB()
    {
        $countries = Country::all();
        if (isset($countries[0])) {
            $response['lastUpdatedAt'] = $countries[0]->date;
        } else {
            $response['lastUpdatedAt'] = "never";
        }
        $response['countries'] = $countries;

        return $response;
    }

    /**
     * @return int
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getLatestDataFromAPI()
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

        return 0;
    }

}
