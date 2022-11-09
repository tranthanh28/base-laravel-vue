<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Elasticsearch\ClientBuilder;

class StoreWeb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:web';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'store to elasticsearch';


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
        $data = [
            'index' => 'website',
            'type' => 'filtered',
            'id' => 1,
            'body' => [
                'es_id' => 'id_2',
                'is_updated' => 123123,
                'status_5' => 1,
                'sub_brand_service_id' => 123,
                'sub_parent_service_id' => 123,
                'tv_sub_brand_service_id' => 123,
                'web_brand_id' => 123,
                'web_brand_service_id' => 321,
            ],
        ];
        try {
            $this->elasticsearch->index($data);
        } catch (\Exception $e) {
            $this->info( $e->getMessage());
        }
        $this->info('Store Successfully');
    }
}
