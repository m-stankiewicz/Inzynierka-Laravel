<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'customer' => [
        'title' => 'Customer',

        'actions' => [
            'index' => 'Customer',
            'create' => 'New Customer',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            
        ],
    ],

    'vat-rate' => [
        'title' => 'Vatrate',

        'actions' => [
            'index' => 'Vatrate',
            'create' => 'New Vatrate',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            
        ],
    ],

    'invoice-series' => [
        'title' => 'Invoiceseries',

        'actions' => [
            'index' => 'Invoiceseries',
            'create' => 'New Invoiceseries',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            
        ],
    ],

    'invoice' => [
        'title' => 'Invoice',

        'actions' => [
            'index' => 'Invoice',
            'create' => 'New Invoice',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            
        ],
    ],

    'invoice-item' => [
        'title' => 'Invoiceitem',

        'actions' => [
            'index' => 'Invoiceitem',
            'create' => 'New Invoiceitem',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];