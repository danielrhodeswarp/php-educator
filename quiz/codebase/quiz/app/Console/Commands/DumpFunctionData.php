<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DumpFunctionData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quiz:dump-function-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dump stored function reference information';

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
     * @return mixed
     */
    public function handle()
    {
        if(!file_exists(storage_path() . '/app/function_data.serialised.php'))
        {
            $this->info('Please run [php artisan quiz:scrape-function-data] as you do not have function data stored.');

            exit;
        }

        
        $functionData = unserialize(file_get_contents(storage_path() . '/app/function_data.serialised.php'));

        var_dump($functionData);

        
        
    }

    
}
