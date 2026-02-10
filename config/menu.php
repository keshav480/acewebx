<?php

return [
    'items' => [
        [
            'title' => 'Dashboard',
            'route' => 'admin.dashboard',
            'icon'  => 'fa fa-home',
            'pattern' => 'admin.dashboard',
        ],
        [
            'title' => 'Users',
            'route' => 'admin.users.index',
            'icon'  => 'fa fa-users',
            'pattern' => 'admin.users.*',
        ],
        [
            'title' => 'Settings',
            'route' => 'admin.settings',
            'icon'  => 'fa fa-cog',
            'pattern' => 'admin.settings',
        ],
    ],
    'header' => [
        [
            'title' => 'Dashboard',
            'route' => 'admin.dashboard',
            'icon'  => 'fa fa-home',
            'pattern' => 'admin.dashboard',
        ],
        [
            'title' => 'Users',
            'route' => 'admin.users.index',
            'icon'  => 'fa fa-users',
            'pattern' => 'admin.users.*',
        ],
    ],
];
