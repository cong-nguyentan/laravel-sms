<?php

return array(
    /**
     * Validation
     */
    'name_required' => 'Missing contact name',
    'name_string' => 'Contact name must be a string value',
    'name_max' => 'Length of contact name must be less than :number characters',
    'phone_required' => 'Missing phone',
    'phone_numeric' => 'Phone number invalid',
    'phone_max' => 'Length of phone number must be less than :number characters',
    'groups_array' => 'Groups data invalid',
    'groups_integer' => 'Groups data invalid',
    'groups_distinct' => 'Groups data invalid',
    'groups_exists' => 'Groups data don\'t exists',
    'contact_import_file_extension_invalid' => 'Extension of file import contact is not valid. Valid extensions are: :extensions',
    'contact_import_file_size_invalid' => 'Size of file import contact is too big. Max file size is: :max_size megabytes',
    'contact_unique' => 'Contact existed',

    /**
     * Index page
     */
    'manage_page_title' => 'Manage contacts',
    'manage_table_title' => 'Manage contacts table',
    'select_group_contact_filter' => 'Select group contact to filter',
    'select_creator_filter' => 'Select creator to filter',

    /**
     * Add page
     */
    'add_page_title' => 'Add contact',
    'add_table_title' => 'Add contact table',

    /**
     * Edit page
     */
    'edit_page_title' => 'Edit contact',
    'edit_table_title' => 'Edit contact table',

    /**
     * Delete page
     */
    'delete_page_title' => 'Delete contact',
    'delete_table_title' => 'Delete contact table',
    'delete_confirmation' => 'You are deleting contact :contact . Are you sure?',

    /**
     * Import page
     */
    'import_page_title' => 'Import contacts',
    'import_table_title' => 'Import contacts table',
    'choose_file_import' => 'Choose file to import',
    'import' => 'Import',
    'import_success_notify' => 'Imported contacts successfully',
    'import_fail_notify' => 'Import contact fail',

    /**
     * Form
     */
    'contact_name' => 'Contact name',
    'contact_phone' => 'Contact phone',
    'contact_creator' => 'Creator',
    'select_group_contact' => 'Select group contact',
);