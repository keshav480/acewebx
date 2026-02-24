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
            'title' => 'Pages',
            'route' => 'admin.pages', 
            'icon'  => 'fa fa-file',       
            'pattern' => 'admin.pages.*',  
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
          [
            'title' => 'Menu',
            'route' => 'admin.menu',
            'icon'  => 'fa fa-bars',
            'pattern' => 'admin.menu',
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
