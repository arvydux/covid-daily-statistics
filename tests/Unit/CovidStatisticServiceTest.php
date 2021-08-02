<?php

namespace Tests\Unit;

use App\Services\CovidStatisticService;
use Illuminate\Http\Request;
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
        $request = new Request();
        $request['from'] = null;
        $request['to'] = null;
        $request['country'] = null;
        $covidStatisticService = new CovidStatisticService();
        $response = $covidStatisticService->getDataByRequest($request);
        $this->assertGreaterThanOrEqual(28, count($response['countryData']));
        $this->assertLessThanOrEqual(31, count($response['countryData']));
    }

    public function test_data_fetched_correctly_from_form_by_custom_request()
    {
        $request = new Request();
        $request['from'] = "2021-07-01";
        $request['to'] = "2021-07-04";
        $request['country'] = 'france';
        $covidStatisticService = new CovidStatisticService();
        $response = $covidStatisticService->getDataByRequest($request);
        $this->assertEquals('France', $response['countryData'][0]->Country);
        $this->assertEquals('2021-07-01T00:00:00Z', $response['countryData'][0]->Date);
    }
}
