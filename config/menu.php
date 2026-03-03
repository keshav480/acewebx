<?php

return [
        'items' => [

        [
            'title' => 'Dashboard',
            'route' => 'admin.dashboard',
            'icon'  => 'fa fa-home',
            'pattern' => 'admin.dashboard',
            'permissions' => ['view dashboard']
        ],

        [
            'title' => 'Media',
            'route' => 'admin.media',
            'icon'  => 'fa fa-image',
            'pattern' => 'admin.media.*',
            'permissions' => ['view media','create media','update media','delete media']
        ],

        [
            'title' => 'Pages',
            'route' => 'admin.pages',
            'icon'  => 'fa fa-file',
            'pattern' => 'admin.pages.*',
            'permissions' => ['view pages','create pages','update pages','delete pages']
        ],

        [
            'title' => 'Users',
            'route' => 'admin.users.index',
            'icon'  => 'fa fa-users',
            'pattern' => 'admin.users.*',
            'permissions' => ['view users','create users','update users','delete users']
        ],
        [
            'title' => 'Role',
            'route' => 'admin.roles.index',
            'icon'  => 'fa fa-user-shield',
            'pattern' => 'admin.roles.*',
            'permissions' => ['view roles','create roles','update roles','delete roles']
        ],

        [
            'title' => 'Settings',
            'route' => 'admin.settings',
            'icon'  => 'fa fa-cog',
            'pattern' => 'admin.settings',
            'permissions' => ['view settings','update settings']
        ],

        [
            'title' => 'Menu',
            'route' => 'admin.menu',
            'icon'  => 'fa fa-bars',
            'pattern' => 'admin.menu',
            'permissions' => ['view menu','create menu','update menu','delete menu']
        ],
        

    ],

    'header' => [
        [
            'title' => 'Visit Site',
            'route' => 'home',
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
