<?php

namespace App\Console;

use App\Currency;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $response = Http::get('http://api.currencylayer.com/live?access_key=45a7c8789f8acf3ec30827639ca5d4da');
            if($response['success']){
                $response = json_decode($response, true);
                $currencies = Currency::all();
                foreach ($currencies as $currency){
                    if(isset($response['quotes']["USD".$currency->slug])){
                        $currency->update([
                            'usd_rate'      =>   $response['quotes']["USD".$currency->slug],
                            'usd_rate_date' =>   Carbon::now(),
                            'exchange'      =>   (1/$response['quotes']["USD".$currency->slug]) * $currency['irr_rate'],
                            'exchange_date' =>   Carbon::now(),
                        ]);
                    }
                }
            }
        })->twiceDaily(1,13);

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
