<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;

use App\Http\Requests\UpdatePermissionRequest;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = new Permission();
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

        return view('permissions.index', array('list' => $listPaginated, 'links' => $links, 'begin' => $begin));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdatePermissionRequest $validate)
    {
        $request = request();

        try {
            $newPermission = new Permission();
            $newPermission->name = $request->get('name');

            $newPermission->save();

            return redirect()->route('permissions.index')->with('success_messages', array(__('global.add_success_notify')));
        } catch (\Exception $e) {
            $errorMessage = formatHandleErrorMessage(__('global.add_fail_notify'), $e);
            return redirect()->back()->withInput()->withErrors($errorMessage);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('permissions.edit', array('permission' => $permission));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $validate, Permission $permission)
    {
        $request = request();

        try {
            $editPermission = $permission;
            $editPermission->name = $request->get('name');

            $editPermission->save();

            return redirect()->route('permissions.index')->with('success_messages', array(__('global.update_success_notify')));
        } catch (\Exception $e) {
            $errorMessage = formatHandleErrorMessage(__('global.update_fail_notify'), $e);
            return redirect()->back()->withInput()->withErrors($errorMessage);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $request = request();

        if ($request->isMethod('get')) {
            return view('permissions.delete', array('permission' => $permission));
        } elseif ($request->isMethod('delete')) {
            try {
                $permission->delete();

                return redirect()->route('permissions.index')->with('success_messages', array(__('global.delete_success_notify')));
            } catch (\Exception $e) {
                $errorMessage = formatHandleErrorMessage(__('global.delete_fail_notify'), $e);
                return redirect()->back()->withInput()->withErrors($errorMessage);
            }
        }
    }

    /**
     * Display an interface to design menu based on acl items.
     *
     * @return \Illuminate\Http\Response
     */
    public function designGroup()
    {
        $permission = new Permission();
        $designedGroup = $permission->getDesignedGroup();

        return view('permissions.design_group', array('groups' => $designedGroup));
    }

    /**
     * Store designed menu.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeDesignedGroup(Request $request)
    {
        $data = $request->get('nestable-output');
        $data = (array) json_decode($data, true);

        $permission = new Permission();
        $saveGroup = $permission->saveDesignedGroup($data);
        if ($saveGroup['status'] == 'ok') {
            return redirect()->route('permissions.design_group')->with('success_messages', array(__('permission.save_designed_group_success')));
        } else {
            return redirect()->route('permissions.design_group')->withErrors($saveGroup['error']);
        }
    }
}
