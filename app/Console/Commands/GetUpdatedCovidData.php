<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Services\CovidStatisticService;
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
        $covidStatisticService = new CovidStatisticService();
        $covidStatisticService->getAndSaveLatestDataFromAPI();
    }
}
