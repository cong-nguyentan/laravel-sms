<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactImportDetail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contact_import_details';

    /**
     * Get the parent
     */
    public function parent()
    {
        return $this->belongsTo('App\ContactImport');
    }
}
