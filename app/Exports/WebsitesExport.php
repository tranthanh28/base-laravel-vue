<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Elasticsearch\ClientBuilder;

class WebsitesExport implements FromCollection
{
    protected $elasticsearch;

    public function __construct()
    {
        $this->elasticsearch = ClientBuilder::create()->build();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $result = $this->elasticsearch->search([
            'index' => 'website',
            'type' => 'filtered',
            'body' => [
                "size" => "100"

            ]
        ]);
        $result = array_map(function ($item) {
            return $item['_source'];
        }, $result['hits']['hits']);


        return collect([
            $result
        ]);
    }
}
