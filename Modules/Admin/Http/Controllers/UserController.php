<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Repositories\UserRepositoryInterface;
use Modules\Admin\Http\Requests\CheckUrlRequest;
use Elasticsearch\ClientBuilder;
use App\Http\Controllers\Controller;
use Modules\Admin\Http\Requests\UpdateUserRequest;
use Modules\Admin\Http\Requests\IndexUserRequest;

class UserController extends Controller
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
        //permission
        $this->middleware('permission:list-user|update-user', ['only' => ['index']]);
        $this->middleware('permission:update-user', ['only' => ['update']]);

        $this->userRepository = $userRepository;
        $this->elasticsearch = ClientBuilder::create()->build();
    }

    public function index(Request $request)
    {
        if (isset($request->status) && in_array($request->status, [0, 1])) {
            $data = User::orderBy('id', 'DESC')->where('status', $request->status)->paginate(10);
        } else {
            $data = User::orderBy('id', 'DESC')->paginate(10);
        }
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $user = User::findOrFail($id);
            $user->update($validatedData);
            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'status' => 'false',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
