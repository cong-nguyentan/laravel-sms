<?php

namespace App\Http\Controllers;

use App\Acl;
use App\Permission;

use Illuminate\Http\Request;

use App\Http\Requests\UpdateAclRequest;

class AclController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = new Acl();
        $query = $model->getListFiltered($request);
        $listPaginated = array();
        $links = "";
        $begin = 0;
        $itemsPerPage = config("constants.backend_query_items_per_page");
        $listFilterShowInMenu = array(
            '' => __('acl.select_show_in_menu_to_search'),
            '-1' => __('global.no'),
            '1' => __('global.yes')
        );

        if (!empty($query['list'])) {
            $listPaginated = $query['list']->with(array('permission'));
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

        return view('acl.index', array('list' => $listPaginated, 'links' => $links, 'begin' => $begin, 'listFilterShowInMenu' => $listFilterShowInMenu));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listPermissions = Permission::orderBy("name")->get()->toArray();
        $permissions = array();
        foreach ($listPermissions as $permission) {
            $permissions[$permission['id']] = $permission['name'];
        }

        return view('acl.create', array('permissions' => $permissions));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateAclRequest $validate)
    {
        $request = request();

        try {
            $acl = new Acl();
            $acl->permission_id = $request->get('permission_id');
            $acl->controller = $request->get('controller');
            $acl->action = $request->get('action');
            if (!empty($request->get('show_in_menu'))) {
                $acl->show_in_menu = 1;
            }

            $acl->save();

            return redirect()->route('acl.index')->with('success_messages', array(__('global.add_success_notify')));
        } catch (\Exception $e) {
            $errorMessage = formatHandleErrorMessage(__('global.add_fail_notify'), $e);
            return redirect()->back()->withInput()->withErrors($errorMessage);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Acl  $acl
     * @return \Illuminate\Http\Response
     */
    public function show(Acl $acl)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Acl  $acl
     * @return \Illuminate\Http\Response
     */
    public function edit(Acl $acl)
    {
        $listPermissions = Permission::orderBy("name")->get()->toArray();
        $permissions = array();
        foreach ($listPermissions as $permission) {
            $permissions[$permission['id']] = $permission['name'];
        }

        return view('acl.edit', array('permissions' => $permissions, 'acl' => $acl));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Acl  $acl
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAclRequest $validate, Acl $acl)
    {
        $request = request();

        try {
            $editAcl = $acl;
            $editAcl->permission_id = $request->get('permission_id');
            $editAcl->controller = $request->get('controller');
            $editAcl->action = $request->get('action');
            if (!empty($request->get('show_in_menu'))) {
                $editAcl->show_in_menu = 1;
            } else {
                $editAcl->show_in_menu = -1;
            }

            $editAcl->save();

            return redirect()->route('acl.index')->with('success_messages', array(__('global.update_success_notify')));
        } catch (\Exception $e) {
            $errorMessage = formatHandleErrorMessage(__('global.update_fail_notify'), $e);
            return redirect()->back()->withInput()->withErrors($errorMessage);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Acl  $acl
     * @return \Illuminate\Http\Response
     */
    public function destroy(Acl $acl)
    {
        $request = request();

        if ($request->isMethod('get')) {
            return view('acl.delete', array('acl' => $acl));
        } elseif ($request->isMethod('delete')) {
            try {
                $acl->delete();

                return redirect()->route('acl.index')->with('success_messages', array(__('global.delete_success_notify')));
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
    public function designMenu()
    {
        $acl = new Acl();
        $designedMenu = $acl->getDesignedMenu();

        return view('acl.design_menu', array('menus' => $designedMenu));
    }

    /**
     * Store designed menu.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeDesignedMenu(Request $request)
    {
        $data = $request->get('nestable-output');
        $data = (array) json_decode($data, true);

        $acl = new Acl();
        $saveMenu = $acl->saveDesignedMenu($data);
        if ($saveMenu['status'] == 'ok') {
            return redirect()->route('acl.design_menu')->with('success_messages', array(__('acl.save_designed_menu_success')));
        } else {
            return redirect()->route('acl.design_menu')->withErrors($saveMenu['error']);
        }
    }
}
