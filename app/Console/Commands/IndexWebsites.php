<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Elasticsearch\ClientBuilder;

class IndexWebsites extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'index:websites {web_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'index web sites';

    protected $elasticsearch;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->elasticsearch = ClientBuilder::create()->build();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $web_id = $this->argument('web_id');
        try {
            if (empty($web_id)) {
                $result = $this->elasticsearch->search([
                    'index' => 'website',
                    'type' => 'filtered'
                ]);
            } else {
                $result = $this->elasticsearch->get([
                    'id' => $web_id,
                    'index' => 'website',
                    'type' => 'filtered'
                    ]);
            }
            $this->info('Search');
            $this->info(print_r($result));

        } catch (Exception $e) {
            $this->info($e->getMessage());
        }
    }
}
