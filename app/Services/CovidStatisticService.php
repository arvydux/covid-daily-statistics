<?php

namespace App\Services;

use App\Models\Country;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
    private function getDataFromAPI()
    {
        $httpClient = new Client();
        $request = $httpClient->get("https://api.covid19api.com/summary");
        $response = json_decode($request->getBody()->getContents());
        return $response->Countries;
    }

    /**
     * @param $allCountriesData
     * @return int
     */
    private function saveDataToDB($allCountriesData)
    {
        foreach ($allCountriesData as $country){
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

    /**
     * @param $country
     * @param string $defaultCountry
     * @return string
     */
    private function parseCountryParam($country, $defaultCountry = "Malta")
    {
        if (!$country) {
            $country = $defaultCountry;
        }
        return Str::lower($country);
    }

    /**
     * @param $from
     * @return string
     */
    private function parseFromParam($from)
    {
        if ($from) {
            return $from = Carbon::createFromFormat('Y-m-d', $from)->startOfDay()->toIso8601ZuluString();
        } else {
            return $from = Carbon::today()->subMonth(1)->startOfDay()->toIso8601ZuluString();;
        }
    }

    /**
     * @param $to
     * @return string
     */
    private function parseToParam($to)
    {
        if ($to) {
            return $to = Carbon::createFromFormat('Y-m-d', $to)->startOfDay()->toIso8601ZuluString();
        } else {
            return $to = Carbon::today()->startOfDay()->toIso8601ZuluString();;
        }
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAllCountryNamesList()
    {
        $httpClient = new Client();
        $request = $httpClient->get("https://api.covid19api.com/countries");
        $unsortedCountryNames = json_decode($request->getBody()->getContents());
        foreach ($unsortedCountryNames as $item){
            $countryNames[$item->Slug] = $item->Country;
        };
        asort($countryNames);
        return $countryNames;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDataByRequest(Request $request)
    {
        $from = $this->parseFromParam($request['from']);
        $to = $this->parseToParam($request['to']);
        $country = $this->parseCountryParam($request['country']);
        $httpClient = new Client();
        $request = $httpClient->get("https://api.covid19api.com/country/${country}?from=${from}&to=${to}");
        $response['countryData']= json_decode($request->getBody()->getContents());
        $response['countryName'] = $country;
        return $response;
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */

    public function getDataFromDB()
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
    public function getAndSaveLatestDataFromAPI()
    {
        $allCountriesData = $this->getDataFromAPI();
        $this->saveDataToDB($allCountriesData);
        return 0;
    }

}
