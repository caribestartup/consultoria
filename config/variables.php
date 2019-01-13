<?php 

return [
    
    'boolean' => [
        '0' => 'No',
        '1' => 'Yes',
    ],
    
    'status' => [
        '1' => 'Active',
        '0' => 'Inactive',
    ],

    'avatar' => [
        'public'  => '/uploads/avatars/',
        'folder'  => '/avatars/',
        
        'width'   => 300,
        'height'  => 300,
        'default' => 'unknown.png',
    ],

    /*
    |------------------------------------------------------------------------------------
    | ENV of APP
    |------------------------------------------------------------------------------------
    */
    'APP_ADMIN' => 'admin',
    'APP_TOKEN' => env('APP_TOKEN', 'admin123456'),
];
