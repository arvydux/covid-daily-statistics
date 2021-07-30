<?php

namespace App\Console\Commands;

use App\Models\Country;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class GetUpdatedCovidData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'covid:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates Covid-19 statistics data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
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

    }
}
