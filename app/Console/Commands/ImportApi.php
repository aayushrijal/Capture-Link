<?php

namespace App\Console\Commands;

use App\CL\Services\API\ApiImportingService;
use Illuminate\Console\Command;

class ImportApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cl:importapi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports data from API';
    /**
     * @var ApiImportingService
     */
    private $import;

    /**
     * Create a new command instance.
     *
     * @param ApiImportingService $import
     */
    public function __construct(ApiImportingService $import)
    {
        parent::__construct();
        $this->import = $import;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->import->run();
    }
}
