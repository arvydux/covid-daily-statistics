<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;

class CovidStatisticService
{
    public function getTotalCovidData()
    {
        $httpClient = new Client();
        $request = $httpClient->get("https://api.covid19api.com/summary");

        $response = json_decode($request->getBody()->getContents());

        return $response;
    }
}
