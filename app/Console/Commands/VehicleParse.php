<?php

namespace App\Console\Commands;

use App\VehicleService;
use Illuminate\Console\Command;

class VehicleParse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vh:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to start parsing vehicles';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new VehicleService)->callApi();
    }
}
