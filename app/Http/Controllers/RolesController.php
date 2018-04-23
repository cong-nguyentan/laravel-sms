<?php

namespace App\Http\Controllers;

use App\Role;
use App\Permission;
use Illuminate\Http\Request;

use App\Http\Requests\UpdateRoleRequest;

use DB;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = new Role();
        $query = $model->getListFiltered($request);
        $listPaginated = array();
        $links = "";
        $begin = 0;
        $itemsPerPage = config("constants.backend_query_items_per_page");

        if (!empty($query['list'])) {
            $listPaginated = $query['list'];
            $listPaginated = $listPaginated->paginate($itemsPerPage);

            if ($listPaginated->total() > $itemsPerPage) {
                if (!empty($query['query_string'])) {
                    $links = $listPaginated->appends($query['query_string'])->links();
                } else {
                    $links = $listPaginated->links();
                }
            }

            $begin = ($listPaginated->currentPage() - 1) * $listPaginated->perPage();
        }

        return view('roles.index', array('list' => $listPaginated, 'links' => $links, 'begin' => $begin));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = new Permission();
        $designedGroupPermission = $permission->getDesignedGroup();

        return view('roles.create', array('permissions' => $designedGroupPermission));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateRoleRequest $validate)
    {
        $request = request();

        try {
            DB::beginTransaction();

            $newRole = new Role();
            $newRole->name = $request->get('name');
            $newRole->weight = $request->get('weight');
            $newRole->save();

            $permissions = $request->get('permissions');
            $permissionsAdd = array();
            foreach ($permissions as $id => $select) {
                if ($select) {
                    $permissionsAdd[] = $id;
                }
            }
            if (!empty($permissionsAdd)) {
                $newRole->givePermissionTo($permissionsAdd);
            }

            DB::commit();

            return redirect()->route('roles.index')->with('success_messages', array(__('global.add_success_notify')));
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = formatHandleErrorMessage(__('global.add_fail_notify'), $e);
            return redirect()->back()->withInput()->withErrors($errorMessage);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permission = new Permission();
        $designedGroupPermission = $permission->getDesignedGroup();

        $rolePermissionsArr = array();
        $rolePermissions = $role->permissions()->get()->toArray();
        foreach ($rolePermissions as $rolePermission) {
            $rolePermissionsArr[$rolePermission['id']] = 1;
        }

        return view('roles.edit', array('permissions' => $designedGroupPermission, 'role' => $role, 'permissionsArr' => $rolePermissionsArr));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $validate, Role $role)
    {
        $request = request();

        try {
            DB::beginTransaction();

            $editRole = $role;
            $editRole->name = $request->get('name');
            $editRole->weight = $request->get('weight');
            $editRole->save();

            $editRole->permissions()->detach();
            $permissions = $request->get('permissions');
            $permissionsAdd = array();
            foreach ($permissions as $id => $select) {
                if ($select) {
                    $permissionsAdd[] = $id;
                }
            }
            if (!empty($permissionsAdd)) {
                $editRole->givePermissionTo($permissionsAdd);
            }

            DB::commit();

            return redirect()->route('roles.index')->with('success_messages', array(__('global.update_success_notify')));
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = formatHandleErrorMessage(__('global.update_fail_notify'), $e);
            return redirect()->back()->withInput()->withErrors($errorMessage);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $request = request();

        if ($request->isMethod('get')) {
            return view('roles.delete', array('role' => $role));
        } elseif ($request->isMethod('delete')) {
            try {
                $role->delete();

                return redirect()->route('roles.index')->with('success_messages', array(__('global.delete_success_notify')));
            } catch (\Exception $e) {
                $errorMessage = formatHandleErrorMessage(__('global.delete_fail_notify'), $e);
                return redirect()->back()->withInput()->withErrors($errorMessage);
            }
        }
    }
}
