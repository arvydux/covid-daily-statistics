<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\CovidStatisticService;

/**
 * Class GetCovidData
 * @package App\Jobs
 */
class GetCovidData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $country;

    public function __construct()
    {
    }

    /**
     * @param CovidStatisticService $covidStatisticService
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(CovidStatisticService $covidStatisticService)
    {
        $covidStatisticService->getTotalCovidData();
    }
}
