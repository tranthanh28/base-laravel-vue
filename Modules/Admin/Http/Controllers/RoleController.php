<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Modules\Admin\Http\Requests\UpdateRoleRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-role|create-role|edit-role|delete-role', ['only' => ['index']]);
        $this->middleware('permission:create-role', ['only' => ['store']]);
        $this->middleware('permission:update-role', ['only' => ['update']]);
        $this->middleware('permission:delete-role', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = Role::with('permissions', 'users')->get();
        $allUsers = User::all();
        $permissions = Permission::all();
        return response()->json([
            'status' => 'success',
            'data' => [
                'roles' => $data,
                'users' => $allUsers,
                'permissions' => $permissions
            ]
        ]);
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $role = Role::find($id);
            $role->name = $request->input('name');
            $role->save();

            $role->syncPermissions($data['permissions']);
            $role->users()->sync($data['users']);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'update role successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            return response()->json([
                'status' => 'false',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(UpdateRoleRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $role = Role::create(['name' => $data['name']]);

            $role->syncPermissions($data['permissions']);
            $role->users()->sync($data['users']);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'update role successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            return response()->json([
                'status' => 'false',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'delete role successfully'
            ]);
        } catch (Exception $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

}
