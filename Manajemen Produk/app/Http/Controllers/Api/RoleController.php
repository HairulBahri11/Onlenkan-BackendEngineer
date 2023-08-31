<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        try {
            $role = Role::orderBy('id', 'DESC')->get();
            // dd($role);
            return response()->json([
                'success' => true,
                'message' => 'Daftar data role',
                'data' => $role,
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Data role kosong',
                'data' => $exception->getMessage()
            ], 404);
        }
    }



    public function store(Request $request)
    {

        $validasi = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validasi->errors()
            ], 422);
        }

        try {
            $role = Role::create(['name' => $request->input('name')]); //buat role sesuai inputan
            $role->syncPermissions($request->input('permission')); //buat permission sesuai inputan field permission
            return response()->json([
                'success' => true,
                'message' => 'Daftar data role dan permission',
                'data' => $role,
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Data data role dan permission gagal ditambahkan',
                'data' => $exception->getMessage()
            ], 404);
        }
    }

    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('roles.show', compact('role', 'rolePermissions'));
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {

        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'permission' => 'required',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validasi->errors()
            ], 422);
        }


        try {
            $role = Role::find($id);
            $role->name = $request->input('name');
            $role->save();
            $role->syncPermissions($request->input('permission'));

            return response()->json([
                'success' => true,
                'message' => 'Update data role dan permission',
                'data' => $role,
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Data role dan permission gagal diupdate',
                'data' => $exception->getMessage()
            ], 404);
        }



        // $this->validate($request, [
        //     'name' => 'required',
        //     'permission' => 'required',
        // ]);


        // $role = Role::find($id);
        // $role->name = $request->input('name');
        // $role->save();

        // $role->syncPermissions($request->input('permission'));

        // return redirect()->route('roles.index')
        //     ->with('success', 'Role updated successfully');
    }

    public function destroy($id)
    {

        try {
            DB::table("roles")->where('id', $id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus',
                // 'data' => $data,
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Data data kosong',
                'data' => $exception->getMessage()
            ], 404);
        }
        // return redirect()->route('roles.index')
        //     ->with('success', 'Role deleted successfully');
    }



    //Permission
    public function permission_index()
    {

        try {
            $permission = Permission::get();
            // dd($permission);
            return response()->json([
                'success' => true,
                'message' => 'Daftar data permission',
                'data' => $permission,
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Data permission kosong',
                'data' => $exception->getMessage()
            ], 404);
        }
    }

    // public function permission_store(Request $request)
    // {
    // $validasi = Validator::make($request->all(), [
    //     'name' => 'required',
    //     // 'give_to' => 'required',
    // ]);

    // if ($validasi->fails()) {
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Validasi gagal',
    //         'errors' => $validasi->errors()
    //     ], 422);
    // }

    // try {
    //     $permission = Permission::create(['name' => $request->input('name')]);
    //     dd($permission);
    //     //permission give to
    //     $role_admin = Role::where('name', $request->input('give_to'))->get();

    //     $role_admin->givePermissionTo([
    //         ['name' => $request->input('name')]
    //     ]);
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Data berhasil ditambahkan',
    //         'data' => $permission,
    //     ], 200);
    // } catch (ModelNotFoundException $exception) {
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Data permission gagal ditambahkan',
    //         'data' => $exception->getMessage()
    //     ], 404);
    // }

    public function permission_store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'give_to' => 'required',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validasi->errors()
            ], 422);
        }

        try {
            $permission = Permission::create(['name' => $request->input('name')]);

            // Jika 'give_to' sudah ada sebagai peran sebelumnya
            $role = Role::findByName($request->input('give_to'));
            if ($role) {
                $permission->assignRole($role);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan',
                'data' => $permission,
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Data permission gagal ditambahkan',
                'data' => $exception->getMessage()
            ], 500);
        }
    }

    // }

    public function permission_update(Request $request, $id)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'give_to' => 'required',
            // 'permission' => 'required',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validasi->errors()
            ], 422);
        }


        try {
            $permission = Permission::find($id);
            $permission->name = $request->input('name');
            $permission->save();
            $permission->syncPermissions($request->input('permission'));

            return response()->json([
                'success' => true,
                'message' => 'Update data role dan permission',
                'data' => $permission,
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Data role dan permission gagal diupdate',
                'data' => $exception->getMessage()
            ], 404);
        }
    }
}
