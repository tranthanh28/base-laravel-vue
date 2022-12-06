<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Repositories\UserRepositoryInterface;
use App\Http\Requests\CheckUrlRequest;
use Elasticsearch\ClientBuilder;

class IfollowController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;
    protected $elasticsearch;

    public function __construct(
        UserRepositoryInterface $userRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->elasticsearch = ClientBuilder::create()->build();
    }

    public function checkUrl(CheckUrlRequest $request): JsonResponse
    {
        try {
            preg_match('/:\/\/(www\.)?(.*?)\//', $request->url, $matches, PREG_OFFSET_CAPTURE);

            if (!$matches && !$matches[2]) {
                return response()->json([
                    "status" => "false",
                    "message" => "domain not found",
                ]);
            }
            $domain = $matches[2][0];

            // Lấy số lượng tin từ website đã lấy về hệ thống, và số lượng cảnh báo.
            $search = [
                'index' => 'website',
                'type' => 'filtered',
                'body' => [
                    "size" => 0,
                    "query" => [
                        "match" => [
                            "web_page_name" => $domain
                        ]
                    ],
                    "aggs" => [
                        "domain_alerted" => [
                            "filter" => ["term" => ["web_status_3" => "1"]],
//                            ["web_id" => "http://www. http:// https:// https://www."]
                        ]
                    ]
                ]
            ];
            $infoDomain = $this->elasticsearch->search($search);

            $hasWebsite = DB::connection('mysql2')->select("Select * from websites where website = ?", [$domain]);

            $hasGoogleApi = DB::connection('mysql2')->select("Select * from google_api where website = ?", [$domain]);

            $listHttp = array('http://www.', 'https://www.', 'http://', 'https://');
            $urlReplace = str_replace($listHttp, '', $request->url);
            $listUrl = [];
            $listUrl[] = "http://" . $urlReplace;
            $listUrl[] = "https://" . $urlReplace;
            $listUrl[] = "http://www." . $urlReplace;
            $listUrl[] = "https://www." . $urlReplace;
            foreach ($listUrl as $item) {
                $url = $item . "_" . $domain;
                $web_id = md5($url);
                $search = [
                    'index' => 'website',
                    'type' => 'filtered',
                    'body' => [
                        "query" => [
                            "match" => [
                                "web_id" => $web_id
                            ]
                        ]
                    ]
                ];
                $result = $this->elasticsearch->search($search);
                if ($result['hits']['total'] > 0) {

                    return response()->json(
                        [
                            'status' => "true",
                            'infoDomain' => $infoDomain,
                            "hasWebsite" => !collect($hasWebsite)->isEmpty(),
                            "hasGoogleApi" => !collect($hasGoogleApi)->isEmpty(),
                            'domain' => $domain,
                            'url' => $item,
                            "data" => $result
                        ]
                    );
                }
            }

            return response()->json(
                [
                    'status' => "false",
                    "data" => "link {$request->url} chưa có trên hệ thống!"
                ], 404);

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'status' => 'false',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
