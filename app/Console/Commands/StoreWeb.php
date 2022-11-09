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
        try {
            $dataFile = file_get_contents(resource_path('data/data.json'));
            $dataFile = json_decode($dataFile, true);
            foreach ($dataFile['hits']['hits'] as $item) {
                $data = [
                    'index' => $item['_index'],
                    'type' => $item['_type'],
                    'body' => $item['_source'],
                ];
                $this->elasticsearch->index($data);
            }
        } catch (\Exception $e) {
            $this->info($e->getMessage());
            return false;
        }
        $this->info('Store Successfully');
    }
}
