<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Contact;
use App\ContactImportDetail;
use App\GroupContact;

use Validator;
use App\Http\Requests\UpdateContactRequest;

use DB;

class ContactImport extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contact_imports';

    /**
     * Get the user imported
     */
    public function importer()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the contacts imported
     */
    public function contacts()
    {
        return $this->hasMany('App\Contact');
    }

    /**
     * Get the contact import logs
     */
    public function logs()
    {
        return $this->hasMany('App\ContactImportDetail');
    }

    public function import($data, $userImport = false)
    {
        if (empty($this->id) || empty($data)) {
            return false;
        }

        if (empty($userImport)) {
            $userImport = getCurrentUser();
            $userImport = $userImport->id;
        }

        $imported = true;
        $errorFound = "";
        $contactFormRequest = new UpdateContactRequest();

        try {
            DB::beginTransaction();

            $groups = $data['groups'];
            $idGroups = array();
            if (!empty($groups)) {
                $groups = explode(";", $groups);
                foreach ($groups as $group) {
                    $group = trim($group);
                    if (!empty($group)) {
                        $groupCheck = GroupContact::where('name', 'LIKE', $group)->where('user_id', $userImport)->first();
                        if (!empty($groupCheck)) {
                            $idGroups[] = $groupCheck->id;
                        } else {
                            $newGroup = new GroupContact();
                            $newGroup->user_id = $userImport;
                            $newGroup->name = $group;
                            $newGroup->description = $group;
                            $newGroup->save();

                            $idGroups[] = $newGroup->id;
                        }
                    }
                }
            }
            $data['groups'] = $idGroups;

            $validator = Validator::make($data, $contactFormRequest->rules(), $contactFormRequest->messages());
            $errorFoundArrs = array();

            if ($validator->fails()) {
                $errors = $validator->errors();
                $contactNameErrors = $errors->get('name');
                $contactPhoneErrors = $errors->get('phone');
                $groupContactsErrors = $errors->get('groups');

                $errorFoundArrs = array_merge($contactNameErrors, $contactPhoneErrors);
                $errorFoundArrs = array_merge($errorFoundArrs, $groupContactsErrors);
            } else {
                $data['id'] = false;
                $checkContactUnique = $contactFormRequest->validateContactUnique($data);
                if (!empty($checkContactUnique)) {
                    $errorFoundArrs[] = $checkContactUnique;
                }
            }

            if (empty($errorFoundArrs)) {
                $importContact = new Contact();
                $importContact->user_id = $userImport;
                $importContact->contact_import_id = $this->id;
                $importContact->name = $data['name'];
                $importContact->phone = $data['phone'];
                $importContact->save();

                $groups = $data['groups'];
                if (!empty($groups)) {
                    $importContact->groups()->attach($groups);
                }

                DB::commit();
            } else {
                $errorFound = implode("-=-", $errorFoundArrs);
                $imported = false;
                DB::rollBack();
            }

        } catch (\Exception $e) {
            DB::rollBack();
            $imported = false;
            $errorFound = formatHandleErrorMessage($errorFound, $e);
        }

        $logContact = new ContactImportDetail();
        $logContact->contact_import_id = $this->id;
        $detail = "Import data: " . json_encode($data) . ". Result: ";
        $detail .= $imported ? "ok" : "fail";
        $detail .= ".";
        if (!$imported && !empty($errorFound)) {
            $detail .= " Error found: " . $errorFound;
        }
        $logContact->detail = $detail;
        $logContact->status = $imported ? 1 : -1;
        $logContact->save();

        return $imported;
    }
}
