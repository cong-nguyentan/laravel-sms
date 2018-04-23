<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

use Excel;
use App\ContactImport;

use App\Http\Requests\UpdateContactRequest;

use DB;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = new Contact();
        $query = $model->getListFiltered($request);
        $listPaginated = array();
        $links = "";
        $begin = 0;
        $itemsPerPage = config("constants.backend_query_items_per_page");

        if (!empty($query['list'])) {
            $listPaginated = $query['list']->with(array('creator', 'groups'));
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

        return view('contacts.index', array('list' => $listPaginated, 'links' => $links, 'begin' => $begin));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateContactRequest $validate)
    {
        $request = request();
        $userLogged = getCurrentUser();

        try {
            DB::beginTransaction();

            $newContact = new Contact();
            $newContact->user_id = $userLogged->id;
            $newContact->name = $request->get('name');
            $newContact->phone = $request->get('phone');
            $newContact->save();

            $groups = $request->get('groups');
            if (!empty($groups)) {
                $newContact->groups()->attach($groups);
            }

            DB::commit();

            return redirect()->route('contacts.index')->with('success_messages', array(__('global.add_success_notify')));
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = formatHandleErrorMessage(__('global.add_fail_notify'), $e);
            return redirect()->back()->withInput()->withErrors($errorMessage);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        return view('contacts.edit', array('contact' => $contact));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContactRequest $validate, Contact $contact)
    {
        $request = request();

        try {
            DB::beginTransaction();

            $editContact = $contact;
            $editContact->name = $request->get('name');
            $editContact->phone = $request->get('phone');
            $editContact->save();

            $groups = $request->get('groups');
            $editContact->groups()->detach();
            if (!empty($groups)) {
                $editContact->groups()->attach($groups);
            }

            DB::commit();

            return redirect()->route('contacts.index')->with('success_messages', array(__('global.update_success_notify')));
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = formatHandleErrorMessage(__('global.update_fail_notify'), $e);
            return redirect()->back()->withInput()->withErrors($errorMessage);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $request = request();

        if ($request->isMethod('get')) {
            return view('contacts.delete', array('contact' => $contact));
        } elseif ($request->isMethod('delete')) {
            try {
                $contact->delete();

                return redirect()->route('contacts.index')->with('success_messages', array(__('global.delete_success_notify')));
            } catch (\Exception $e) {
                $errorMessage = formatHandleErrorMessage(__('global.delete_fail_notify'), $e);
                return redirect()->back()->withInput()->withErrors($errorMessage);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $currentUser = getCurrentUser();

        if ($request->isMethod('get')) {
            return view('contacts.import', array('user' => $currentUser));
        } elseif ($request->isMethod('post')) {
            $errors = array();

            if ($request->file('file_import')->isValid()) {
                $nameFileImported = $request->file_import->getClientOriginalName();
                $parse = pathinfo($nameFileImported);
                $extFileImported = $parse['extension'];
                $extFileImported = strtolower($extFileImported);
                $sizeFileImported = $request->file_import->getClientSize();

                $configExtAllowed = config('constants.backend_import_contacts_function.file_import_extension');
                $configMaxSizeAllowed = config('constants.backend_import_contacts_function.file_import_max_size');
                $configMaxSizeAllowed = $configMaxSizeAllowed * 1024 * 1024;
                $dirStoreFileImport = config('constants.backend_import_contacts_function.directory_store_file');

                if (!in_array($extFileImported, $configExtAllowed)) {
                    $errors[] = __('contact.contact_import_file_extension_invalid', array('extensions' => implode(", ", $configExtAllowed)));
                }
                if ($sizeFileImported > $configMaxSizeAllowed) {
                    $errors[] = __('contact.contact_import_file_size_invalid', array('max_size' => $configMaxSizeAllowed));
                }

                if (empty($errors)) {
                    $dest = "contacts_import_" . time() . "." . $extFileImported;
                    $path = $request->file_import->storeAs($dirStoreFileImport, $dest);
                    if (!empty($path)) {
                        $fullPath = config('filesystems.disks.local.root') . "/" . $path;

                        try {
                            $contactImport = new ContactImport();
                            $contactImport->user_id = $currentUser->id;
                            $contactImport->import_file_name = $nameFileImported;
                            $contactImport->store_file_name = $path;
                            $contactImport->save();

                            Excel::filter('chunk')->load($fullPath)->chunk(250, function($results) use($contactImport) {
                                foreach ($results as $item) {
                                    $dataImport = array(
                                        'name' => $item->name,
                                        'phone' => $item->phone,
                                        'groups' => $item->groups
                                    );

                                    $contactImport->import($dataImport);
                                }
                            });
                        } catch (\Exception $e) {
                            $errors[] = formatHandleErrorMessage(__('contact.import_fail_notify'), $e);
                        }
                    } else {
                        $errors[] = __('contact.import_fail_notify');
                    }
                }
            } else {
                $errors[] = __('contact.import_fail_notify');
            }

            if (!empty($errors)) {
                return redirect()->back()->withErrors($errors);
            } else {
                return redirect()->route('contacts.index')->with('success_messages', array(__('contact.import_success_notify')));
            }
        }
    }
}
