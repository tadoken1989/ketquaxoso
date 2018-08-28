<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Titles for routes names
    |--------------------------------------------------------------------------
    |
    | Set Titles for each admin routes names
    */

    'admin' => [
        'crawler' => [
            'index' => 'crawlers',
            'report' => 'report',
            'lotteries' => 'lotteries',
            'result_lotteries' => 'report'
        ],
        'lotteries' => [
            'index' => 'crawlers',
            'report' => 'report',
            'lotteries' => 'lotteries',
            'create' => 'create_lotteries',
            'result_lotteries' => 'report'
        ],
        'advertises' => [
            'index' => 'advertises',
            'edit' => 'advertises',
            'create' => 'advertises',
            'update' => 'advertises',
        ],
        'result_lotteries' => [
            'index' => 'crawlers',
            'report' => 'report',
            'edit' => 'result_lotteries_edit'
        ],
        'index' => 'admin',
    ],
    'users' => [
        'index' => 'usersGestion',
        'edit' => 'userEdit',
    ],
    'contacts' => [
        'index' => 'contactsGestion',
    ],
    'posts' => [
        'index' => 'postsGestion',
        'edit' => 'postEdit',
        'create' => 'postCreate',
        'show' => 'postShow',
    ],
    'notifications' => [
        'index' => 'notificationsGestion',
    ],
    'comments' => [
        'index' => 'commentsGestion',
    ],
    'medias' => [
        'index' => 'mediasGestion',
    ],
    'settings' => [
        'edit' => 'settings',
    ],
    'categories' => [
        'index' => 'categoriesGestion',
        'create' => 'categoryCreate',
        'edit' => 'categoryEdit',
    ],

    'notify' => [
        'index' => 'notify',
        'create' => 'notifyCreate',
        'edit' => 'notifyEdit',
    ],

    'sites' => [
        'index' => 'sites',
        'create' => 'sitesCreate',
        'edit' => 'sitesEdit',
    ],

];