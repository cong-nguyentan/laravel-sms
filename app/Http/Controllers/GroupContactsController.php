<?php

namespace App\Http\Controllers;

use App\GroupContact;
use Illuminate\Http\Request;

use App\Http\Requests\UpdateGroupContactRequest;

class GroupContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = new GroupContact();
        $query = $model->getListFiltered($request);
        $listPaginated = array();
        $links = "";
        $begin = 0;
        $itemsPerPage = config("constants.backend_query_items_per_page");

        if (!empty($query['list'])) {
            $listPaginated = $query['list']->with(array('creator'));
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

        return view('group_contacts.index', array('list' => $listPaginated, 'links' => $links, 'begin' => $begin));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('group_contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateGroupContactRequest $validate)
    {
        $request = request();
        $userLogged = getCurrentUser();

        try {
            $newGroupContact = new GroupContact();
            $newGroupContact->user_id = $userLogged->id;
            $newGroupContact->name = $request->get('name');
            $newGroupContact->description = $request->get('description');
            $newGroupContact->save();

            return redirect()->route('group_contacts.index')->with('success_messages', array(__('global.add_success_notify')));
        } catch (\Exception $e) {
            $errorMessage = formatHandleErrorMessage(__('global.add_fail_notify'), $e);
            return redirect()->back()->withInput()->withErrors($errorMessage);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GroupContact  $groupContact
     * @return \Illuminate\Http\Response
     */
    public function show(GroupContact $groupContact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GroupContact  $groupContact
     * @return \Illuminate\Http\Response
     */
    public function edit(GroupContact $groupContact)
    {
        return view('group_contacts.edit', array('groupContact' => $groupContact));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GroupContact  $groupContact
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGroupContactRequest $validate, GroupContact $groupContact)
    {
        $request = request();

        try {
            $editGroupContact = $groupContact;
            $editGroupContact->name = $request->get('name');
            $editGroupContact->description = $request->get('description');
            $editGroupContact->save();

            return redirect()->route('group_contacts.index')->with('success_messages', array(__('global.update_success_notify')));
        } catch (\Exception $e) {
            $errorMessage = formatHandleErrorMessage(__('global.update_fail_notify'), $e);
            return redirect()->back()->withInput()->withErrors($errorMessage);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GroupContact  $groupContact
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroupContact $groupContact)
    {
        $request = request();

        if ($request->isMethod('get')) {
            return view('group_contacts.delete', array('groupContact' => $groupContact));
        } elseif ($request->isMethod('delete')) {
            try {
                $groupContact->delete();

                return redirect()->route('group_contacts.index')->with('success_messages', array(__('global.delete_success_notify')));
            } catch (\Exception $e) {
                $errorMessage = formatHandleErrorMessage(__('global.delete_fail_notify'), $e);
                return redirect()->back()->withInput()->withErrors($errorMessage);
            }
        }
    }
}
