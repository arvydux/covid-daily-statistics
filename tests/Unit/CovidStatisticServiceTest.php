<?php

namespace Tests\Unit;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class CovidStatisticServiceTest extends TestCase
{
    public function test_all_countries_names_fetched()
    {
        $httpClient = new Client();
        $request = $httpClient->get("https://api.covid19api.com/countries");
        $unsortedCountriesNames = json_decode($request->getBody()->getContents());
        $this->assertGreaterThan(240, count($unsortedCountriesNames));
    }

    public function test_data_fetched_correctly_from_form_by_default_request()
    {
        $request['from'] = null;
        $request['to'] = null;
        $request['country'] = null;

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
        $response = json_decode($request->getBody()->getContents());
        $this->assertGreaterThanOrEqual(28, count($response));
        $this->assertLessThanOrEqual(31, count($response));
    }

    public function test_data_fetched_correctly_from_form_by_custom_request()
    {
        $request['from'] = "2021-07-01";
        $request['to'] = "2021-07-04";
        $request['country'] = 'france';

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
        $response = json_decode($request->getBody()->getContents());
        $this->assertEquals('France', $response[0]->Country);
        $this->assertEquals('2021-07-01T00:00:00Z', $response[0]->Date);
    }
}
