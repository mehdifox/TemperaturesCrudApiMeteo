<?php

namespace App\Console;

use App\Temperature;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        $schedule->call(function () {
           $this->getData();
           //Display log
           info("schedule ===> run");
           })->everyFifteenMinutes();
        // })->everyMinute();
        

    }

    //Get data from API and insert in table 
    private function getData(){
        // Call API
        $response = Http::get('https://api.open-meteo.com/v1/forecast?latitude=28.50&longitude=-10.00&hourly=temperature_2m');
        $countTemperature = Temperature::count();
        //Insert data if table is empty
        if($countTemperature == 0){
            foreach($response["hourly"]["time"] as $key =>  $value) {
                // $this->saveData(str_replace('T', ' ', $value) , $response["hourly"]["temperature_2m"][$key]);
                $temperature = new Temperature();
                //Replace T to space for column datetime
                $temperature->time = str_replace('T', ' ', $value);
                $temperature->temperature = $response["hourly"]["temperature_2m"][$key];
                $temperature->save();
            }
        //Insert only new data that does not exist in the table (unique by time ) 
        }else{
            foreach($response["hourly"]["time"] as $key =>  $value) {
                //Test row from api does not in table
                if(!Temperature::where('time' , str_replace('T', ' ', $value))->exists()){
                // $this->saveData(str_replace('T', ' ', $value) , $response["hourly"]["temperature_2m"][$key]);
                $temperature = new Temperature();
                //Replace T to space for column datetime
                $temperature->time = str_replace('T', ' ', $value);
                $temperature->temperature = $response["hourly"]["temperature_2m"][$key];
                $temperature->save();
                }
            }
        }
    }

    //Save Data
    private function saveData($time , float $temperature){
        $temperature = new Temperature();
        $temperature->time = $time;
        $temperature->temperature = $temperature;
        $temperature->save();
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
