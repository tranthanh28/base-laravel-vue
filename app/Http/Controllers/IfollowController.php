<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // trick xuat=>
        // 1. http://www.
        // 2. https://www.
        // 3. http://
        // 4. https://
        // trick xuat duoc domain => if(contains: www): )(.)*?/.

        // url => xoa http://www., ................
        // data[] = http://www . $url
        // data[] = https://www
        // data[] = http
        // data[] = https
//foreach data
        try {

            preg_match('/:\/\/(www\.)?(.*?)\//', $request->url, $matches, PREG_OFFSET_CAPTURE);
            \Log::info($matches);

            if (!$matches && !$matches[2]) {
                return response()->json([
                    "status" => "false",
                    "message" => "domain not found",
                ]);
            }
            $domainUrl = $matches[2][0];

            $search = array('http://www.', 'https://www.', 'http://', 'https://');
            $urlReplace = str_replace($search, '', $request->url);
            $listUrl = [];
            $listUrl[] = "http://" . $urlReplace;
            $listUrl[] = "https://" . $urlReplace;
            $listUrl[] = "http://www." . $urlReplace;
            $listUrl[] = "https://www." . $urlReplace;
            \Log::info("list url");
            \Log::info($listUrl);
            foreach ($listUrl as $item) {
                \Log::info($item);
                $url = $item . "_" . $domainUrl;
                $web_id = md5($url);
                $data = [
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
                \Log::info($data);
                $result = $this->elasticsearch->search($data);
                \Log::info($result);
                if ($result['hits']['total'] > 0) {

                    return response()->json(
                        [
                            'status' => "true",
                            "data" => $result
                        ]
                    );
                }
            }

            return response()->json(
                [
                    'status' => "false",
                    "data" => "link {$request->url} chưa được hệ thống quét!"
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
