<?php

return array(
    /**
     * Validation
     */
    'name_required' => 'Missing role name',
    'name_string' => 'Role name must be a string value',
    'name_max' => 'Length of role name must be less than :number characters',
    'name_unique' => 'Role name existed',
    'weight_required' => 'Missing role weight',
    'weight_integer' => 'Role weight must be a integer value',
    'weight_min' => 'Role weight must be greater than :number',
    'weight_unique' => 'Role weight existed',

    /**
     * Index page
     */
    'manage_page_title' => 'Manage roles',
    'manage_table_title' => 'Manage roles table',

    /**
     * Add page
     */
    'add_page_title' => 'Add role',
    'add_table_title' => 'Add role table',

    /**
     * Edit page
     */
    'edit_page_title' => 'Edit role',
    'edit_table_title' => 'Edit role table',

    /**
     * Delete page
     */
    'delete_page_title' => 'Delete role',
    'delete_table_title' => 'Delete role table',
    'delete_confirmation' => 'You are deleting role :role . Are you sure?',

    /**
     * Form
     */
    'role_name' => 'Role name',
    'role_weight' => 'Role weight',
);