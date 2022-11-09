<?php
//
//namespace App\Console\Commands;
//
//use Illuminate\Console\Command;
//use Elasticsearch\ClientBuilder;
//
//class MappingWeb extends Command
//{
//    /**
//     * The name and signature of the console command.
//     *
//     * @var string
//     */
//    protected $signature = 'mapping:web';
//
//    /**
//     * The console command description.
//     *
//     * @var string
//     */
//    protected $description = 'create a mapping';
//
//    protected $elasticsearch;
//
//    /**
//     * Create a new command instance.
//     *
//     * @return void
//     */
//    public function __construct()
//    {
//        $this->elasticsearch = ClientBuilder::create()->build();
//        parent::__construct();
//    }
//
//    /**
//     * Execute the console command.
//     *
//     * @return int
//     */
//    public function handle()
//    {
//        try {
//            $this->elasticsearch->indices()->putMapping(
//                [
//                    'index' => 'book',
//                    'type' => 'books',
//                    'body' => [
//                        "properties" => [
//                            "es_id" => [
//                                "type" => "string",
//                                "store" => true
//                            ],
//                            "is_updated" => [
//                                "type" => "long"
//                            ],
//                            "status_5" => [
//                                "type" => "long"
//                            ],
//                            "sub_brand_service_id" => [
//                                "type" => "long"
//                            ],
//                            "sub_parent_service_id" => [
//                                "type" => "long"
//                            ],
//                            "tv_sub_brand_service_id" => [
//                                "type" => "long"
//                            ],
//                            "web_brand_id" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_brand_service_id" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_category_name" => [
//                                "type" => "string",
//                                "store" => true
//                            ],
//                            "web_category_url" => [
//                                "type" => "string",
//                                "store" => true
//                            ],
//                            "web_channel" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_child_count" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_concern_point" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_content_created" => [
//                                "type" => "date",
//                                "store" => true,
//                                "format" => "yyyy-MM-dd HH=>mm=>ss"
//                            ],
//                            "web_content_from_id" => [
//                                "type" => "string",
//                                "store" => true
//                            ],
//                            "web_content_from_name" => [
//                                "type" => "string",
//                                "store" => true
//                            ],
//                            "web_content_updated" => [
//                                "type" => "date",
//                                "store" => true,
//                                "format" => "yyyy-MM-dd HH=>mm=>ss"
//                            ],
//                            "web_count_word" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_created" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_id" => [
//                                "type" => "string",
//                                "store" => true
//                            ],
//                            "web_image" => [
//                                "type" => "string",
//                                "store" => true
//                            ],
//                            "web_intro" => [
//                                "type" => "string",
//                                "store" => true
//                            ],
//                            "web_is_backup" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_is_delete" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_is_duplicated" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_is_pin" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_is_updated" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_keyword" => [
//                                "type" => "string",
//                                "store" => true
//                            ],
//                            "web_lead" => [
//                                "type" => "string",
//                                "store" => true
//                            ],
//                            "web_mention_type" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_message" => [
//                                "type" => "string",
//                                "store" => true
//                            ],
//                            "web_message_0" => [
//                                "type" => "string"
//                            ],
//                            "web_message_1" => [
//                                "type" => "string"
//                            ],
//                            "web_message_2" => [
//                                "type" => "string"
//                            ],
//                            "web_message_3" => [
//                                "type" => "string"
//                            ],
//                            "web_message_4" => [
//                                "type" => "string"
//                            ],
//                            "web_object_id" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_own_type" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_page_id" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_page_name" => [
//                                "type" => "string",
//                                "store" => true
//                            ],
//                            "web_parent_id" => [
//                                "type" => "string",
//                                "store" => true
//                            ],
//                            "web_parent_object_id" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_parent_service_id" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_per_negative" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_per_neutral" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_per_positive" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_point" => [
//                                "type" => "float",
//                                "store" => true
//                            ],
//                            "web_price" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_primary" => ["type" => "integer",
//                                "store" => true
//                            ],
//                            "web_promote" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_service_id" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_state" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_status_0" => [
//                                "type" => "long"
//                            ],
//                            "web_status_1" => [
//                                "type" => "long"
//                            ],
//                            "web_status_2" => [
//                                "type" => "long"
//                            ],
//                            "web_status_3" => [
//                                "type" => "long"
//                            ],
//                            "web_status_4" => [
//                                "type" => "long"
//                            ],
//                            "web_status_5" => [
//                                "type" => "long"
//                            ],
//                            "web_sub_brand_service_id" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_sub_message" => [
//                                "type" => "string",
//                                "store" => true
//                            ],
//                            "web_sub_parent_service_id" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_sub_service_id" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_sub_status" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_tag" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_tag_keywords" => [
//                                "type" => "string",
//                                "store" => true
//                            ],
//                            "web_title" => [
//                                "type" => "string",
//                                "store" => true
//                            ],
//                            "web_total_like" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_total_page_like" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_total_share" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_type" => [
//                                "type" => "integer",
//                                "store" => true
//                            ],
//                            "web_url" => [
//                                "type" => "string",
//                                "store" => true
//                            ]
//                        ]
//                    ]
//                ]
//            );
//        } catch (\Exception $e) {
//            $this->info($e->getMessage());
//        }
//    }
//}
