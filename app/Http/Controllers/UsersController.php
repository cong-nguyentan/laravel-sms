<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateProfileRequest;

use App\User;

use DB;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userLogged = getCurrentUser();
        $query = $userLogged->getListManageUsers(true, $request);
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

        return view('users.index', array('list' => $listPaginated, 'links' => $links, 'begin' => $begin));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateUserRequest $validate)
    {
        $request = request();

        try {
            DB::beginTransaction();

            $newUser = new User();
            $newUser->name = $request->get('name');
            $newUser->email = $request->get('email');
            $newUser->password = $request->get('password');
            $newUser->save();

            $role = $request->get('role');
            $newUser->assignRole($role);

            DB::commit();

            return redirect()->route('users.index')->with('success_messages', array(__('global.add_success_notify')));
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = formatHandleErrorMessage(__('global.add_fail_notify'), $e);
            return redirect()->back()->withInput()->withErrors($errorMessage);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('users.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', array('user' => $user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $validate, User $user)
    {
        $request = request();

        try {
            DB::beginTransaction();

            $editUser = $user;
            $editUser->name = $request->get('name');
            $editUser->email = $request->get('email');
            $newPassword = $request->get('password');
            if (!empty($newPassword)) {
                $editUser->password = $newPassword;
            }
            $editUser->save();

            $role = $request->get('role');
            $editUser->roles()->detach();
            $editUser->assignRole($role);

            DB::commit();

            return redirect()->route('users.index')->with('success_messages', array(__('global.update_success_notify')));
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = formatHandleErrorMessage(__('global.update_fail_notify'), $e);
            return redirect()->back()->withInput()->withErrors($errorMessage);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $request = request();
        $currentUser = getCurrentUser();
        if ($currentUser->id == $user->id) {
            return redirect()->route('users.index');
        }

        if ($request->isMethod('get')) {
            return view('users.delete', array('user' => $user));
        } elseif ($request->isMethod('delete')) {
            try {
                $user->delete();

                return redirect()->route('users.index')->with('success_messages', array(__('global.delete_success_notify')));
            } catch (\Exception $e) {
                $errorMessage = formatHandleErrorMessage(__('global.delete_fail_notify'), $e);
                return redirect()->back()->withInput()->withErrors($errorMessage);
            }
        }
    }

    /**
     * View and update profile.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function profile(UpdateProfileRequest $validate)
    {
        $request = request();
        $currentUser = getCurrentUser();

        if ($request->isMethod('get')) {
            return view('users.profile', array('user' => $currentUser));
        } elseif ($request->isMethod('post')) {
            try {
                $editUser = $currentUser;
                $editUser->name = $request->get('name');
                $newPassword = $request->get('password');
                if (!empty($newPassword)) {
                    $editUser->password = $newPassword;
                }
                $editUser->save();

                return redirect()->route('users.profile')->with('success_messages', array(__('user.update_profile_success_notify')));
            } catch (\Exception $e) {
                $errorMessage = formatHandleErrorMessage(__('user.update_profile_fail_notify'), $e);
                return redirect()->back()->withInput()->withErrors($errorMessage);
            }
        }
    }
}
