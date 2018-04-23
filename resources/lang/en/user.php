<?php

return array(
    /**
     * Validation
     */
    'name_required' => 'Missing user name',
    'name_string' => 'User name must be a string value',
    'name_max' => 'Length of user name must be less than :number characters',
    'name_unique' => 'User name existed',
    'email_required' => 'Missing email',
    'email_string' => 'Email must be a string value',
    'email_max' => 'Length of email must be less than :number characters',
    'email_invalid' => 'Email address value is invalid',
    'email_unique' => 'Email existed',
    'password_required' => 'Missing password',
    'password_string' => 'Password must be a string value',
    'password_max' => 'Length of password must be less than :number characters',
    'password_confirmed' => 'Password and repassword don\'t match',
    'role_required' => 'Missing role',
    'role_integer' => 'Role must be a integer value',
    'role_min' => 'Role must be greater than :number',
    'role_exists' => 'Role doesn\'t exists',

    /**
     * Index page
     */
    'manage_page_title' => 'Manage users',
    'manage_table_title' => 'Manage users table',
    'select_role_filter' => 'Select role to filter',
    'super_admin' => 'Super admin',

    /**
     * Add page
     */
    'add_page_title' => 'Add user',
    'add_table_title' => 'Add user table',

    /**
     * Edit page
     */
    'edit_page_title' => 'Edit user',
    'edit_table_title' => 'Edit user table',

    /**
     * Delete page
     */
    'delete_page_title' => 'Delete user',
    'delete_table_title' => 'Delete user table',
    'delete_confirmation' => 'You are deleting user :user . Are you sure?',

    /**
     * Profile page
     */
    'profile_page_title' => 'My profile',
    'profile_table_title' => 'My profile table',
    'update_profile_success_notify' => 'Updated profile successfully',
    'update_profile_fail_notify' => 'Update profile fail',

    /**
     * Form
     */
    'user_name' => 'User name',
    'user_email' => 'Email',
    'user_password' => 'Password',
    'user_password_again' => 'Password again',
);