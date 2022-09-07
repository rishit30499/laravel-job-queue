<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Cake;


class testJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    // protected $cake;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {


    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $client = new \GuzzleHttp\Client();
        $request = $client->get('http://api.openweathermap.org/data/2.5/forecast?id=524901&appid=295f077f5a17e42b6db9c9a707c3b596');
        $response = $request->getBody()->getContents();
        $cake = json_decode($response, true);
       // print_r($cake);
        \Log::info($cake['list'][0]['main']);
        if($cake)
        {
            print_r($cake);
            $temprature = isset($cake['list'][0]['main']['temp']) ? $cake['list'][0]['main']['temp'] : '';
            $tempratureMin = isset($cake['list'][0]['main']['temp_min']) ? $cake['list'][0]['main']['temp_min'] : '';
            $tempratureMax = isset($cake['list'][0]['main']['temp_max']) ? $cake['list'][0]['main']['temp_max'] : '';
            //return 0;
            Cake::create([
                'temp' => $temprature,
                'temp_min' => $tempratureMin,
                'temp_max' => $tempratureMax
            ]);
        }
    }
}
