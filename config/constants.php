<?php

return array(

    /**
     * Backend query items per page
     */
    'backend_query_items_per_page' => 20,

    /**
     * Backend enable show debug message
     */
    'backend_enable_show_debug_message' => true,

    /**
     * Backend import contacts function
     */
    'backend_import_contacts_function' => array(
        'directory_store_file' => 'contact_import_files',
        'file_import_extension' => array('csv'),
        'file_import_max_size' => 2
    )
);