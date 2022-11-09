<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Exports\WebsitesExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportWebsites extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:websites';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'export:websites';

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
        try {
            Excel::store(new WebsitesExport(), 'websites.xlsx');
            $this->info('export success');
        } catch (\Exception $e){
            $this->info($e->getMessage());
        }
    }
}
