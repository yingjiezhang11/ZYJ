<?php
return [
    'system' => [
        'icon' => 'cog',
        'text' => '系统管理',
        'link' => '',
        'children' => [
            'list' => [
                'icon' => '',
                'text' => '系统设置',
                'link' => '/360/public_html/index.php/admin/system/index',
            ],
            'log' => [
                'icon' => '',
                'text' => '操作日志',
                'link' => '/360/public_html/index.php/admin/system/log',
            ],
            'attachment' => [
                'icon' => '',
                'text' => '附件列表',
                'link' => '/360/public_html/index.php/admin/system/attachment',
                'auth' => [
                    'delete' => '删除附件',
                ]
            ],
        ],
    ],
    'user' => [
        'icon' => 'user',
        'text' => '用户管理',
        'link' => '',
        'children' => [
            'list' => [
                'icon' => '',
                'text' => '管理员管理',
                'link' => '/360/public_html/index.php/admin/user/index',
                'auth' =>[
                    'edit' => '新增/编辑用户',
                    'delete' => '删除用户',
                ],
            ],
            'member' => [
                'icon' => '',
                'text' => '会员管理',
                'link' => '/360/public_html/index.php/admin/user/member',
                'auth' =>[
                    'add' => '新增用户',
                    'edit' => '编辑用户',
                    'delete' => '删除用户',
                ],
            ],
            'role' => [
                'icon' => '',
                'text' => '角色/权限设置',
                'link' => '/360/public_html/index.php/admin/role/index',
            ],
        ],
    ],
    'content' => [
        'icon' => 'book',
        'text' => '内容管理',
        'link' => '',
        'children' => [
            'list' => [
                'icon' => '',
                'text' => '栏目设置',
                'link' => '/360/public_html/index.php/admin/column/index',
                'auth' =>[
                    'add' => '添加栏目',
                    'edit' => '编辑栏目',
                    'delete' => '删除栏目',
                ],
            ],
            'article' => [
                'icon' => '',
                'text' => '文章管理',
                'link' => '/360/public_html/index.php/admin/article/index',
                'auth' =>[
                    'add' => '添加文章',
                    'edit' => '编辑文章',
                    'delete' => '删除文章',
                ],
            ],
            'page' => [
                'icon' => '',
                'text' => '单页管理',
                'link' => '/360/public_html/index.php/admin/page/index',
            ],
        ],
    ],
    'weixin' => [
        'icon' => 'wechat',
        'text' => '微信管理',
        'link' => '',
        'children' => [
            'list' => [
                'icon' => '',
                'text' => '微信用户',
                'link' => '/360/public_html/index.php/admin/weixin/index',
                'auth' =>[
                    'edit' => '新增编辑用户',
                    'delete' => '删除用户',
                ],
            ],
            'yiren' => [
                'icon' => '',
                'text' => '艺人管理',
                'link' => '/360/public_html/index.php/admin/weixin/yiren',
                'auth' =>[
                    'edit' => '新增编辑用户',
                    'delete' => '删除用户',
                ],
            ],
            'huodong' => [
                'icon' => '',
                'text' => '活动管理',
                'link' => '/360/public_html/index.php/admin/weixin/huodong',
                'auth' =>[
                    'edit' => '新增编辑用户',
                    'delete' => '删除用户',
                ],
            ],


        ],
    ],
];