<?php
return [
    'index' => [
        'icon' => 'home',
        'text' => '系统首页',
        'link' => '__URL__/index.php/member/index/index/',
    ],
    'sales' => [
        'icon' => 'cog',
        'text' => '销售管理',
        'link' => '',
        'children' => [
            'add' => [
                'icon' => '',
                'text' => '新增销售订单',
                'link' => '__URL__/index.php/member/sales/add',
            ],
            'list' => [
                'icon' => '',
                'text' => '未处理订单',
                'link' => '__URL__/index.php/member/sales/index',
                'auth' =>[
                    'add' => '新增',
                    'edit' => '编辑',
                    'delete' => '删除',
                ],
            ],
            'returnorder' => [
                'icon' => '',
                'text' => '退回订单管理',
                'link' => '__URL__/index.php/member/sales/returnorder',
            ],
            'unsubscribe' => [
                'icon' => '',
                'text' => '客户退订管理',
                'link' => '__URL__/index.php/member/sales/unsubscribe',
            ],
        ],
    ],
    'customer' => [
        'icon' => 'cog',
        'text' => '客户管理',
        'link' => '',
        'children' => [
            'list' => [
                'icon' => '',
                'text' => '客户基本信息',
                'link' => '__URL__/index.php/member/customer/index',
                'auth' =>[
                    'all' => '列出所有客户',
                    'add' => '新增',
                    'edit' => '编辑',
                    'delete' => '删除',
                ],
            ],
            'track' => [
                'icon' => '',
                'text' => '客户跟踪记录',
                'link' => '__URL__/index.php/member/customer/track',
                'auth' =>[
                    'add' => '新增',
                    'edit' => '编辑',
                    'delete' => '删除',
                ],
            ],
            'visit' => [
                'icon' => '',
                'text' => '客户回访提醒',
                'link' => '__URL__/index.php/member/customer/visit',
                'auth' =>[
                    'add' => '新增',
                    'edit' => '编辑',
                    'delete' => '删除',
                ],
            ],
            'search' => [
                'icon' => '',
                'text' => '客户搜索',
                'link' => '__URL__/index.php/member/customer/search',
            ],
        ],
    ],
    'stock' => [
        'icon' => 'cog',
        'text' => '库存管理',
        'link' => '',
        'children' => [
            'orders' => [
                'icon' => '',
                'text' => '订单管理',
                'link' => '__URL__/index.php/member/stock/orders',
            ],
            'storage' => [
                'icon' => '',
                'text' => '采购入库',
                'link' => '__URL__/index.php/member/stock/storage',
                'auth' =>[
                    'add' => '新增',
                ],
            ],
            'inventory' => [
                'icon' => '',
                'text' => '库存盘点',
                'link' => '__URL__/index.php/member/stock/inventory',
            ],
            'product' => [
                'icon' => '',
                'text' => '产品设置',
                'link' => '__URL__/index.php/member/stock/product',
            ],
            'setting' => [
                'icon' => '',
                'text' => '库存参数设置',
                'link' => '__URL__/index.php/member/stock/setting',
            ],
        ],
    ],
    'finance' => [
        'icon' => 'cog',
        'text' => '财务管理',
        'link' => '',
        'children' => [
            'audit' => [
                'icon' => '',
                'text' => '未审核订单',
                'link' => '__URL__/index.php/member/finance/audit',
            ],
            'auditok' => [
                'icon' => '',
                'text' => '已审核订单',
                'link' => '__URL__/index.php/member/finance/audit_ok',
            ],
            'report' => [
                'icon' => '',
                'text' => '财务报表',
                'link' => '__URL__/index.php/member/finance/report',
            ],
        ],
    ],
    'user' => [
        'icon' => 'cog',
        'text' => '员工管理',
        'link' => '',
        'children' => [
            'list' => [
                'icon' => '',
                'text' => '员工管理',
                'link' => '__URL__/index.php/member/member/index',
                'auth' =>[
                    'add' => '新增',
                    'edit' => '编辑',
                    'delete' => '删除',
                ],
            ],
            'role' => [
                'icon' => '',
                'text' => '权限/角色管理',
                'link' => '__URL__/index.php/member/member/role',
                'auth' =>[
                    'add' => '新增',
                    'edit' => '编辑',
                    'delete' => '删除',
                ],
            ],
        ],
    ],
    'shop' => [
        'icon' => 'cog',
        'text' => '系统设置',
        'link' => '',
        'children' => [
            'list' => [
                'icon' => '',
                'text' => '基本信息设置',
                'link' => '__URL__/index.php/member/shop/index',
            ],

        ],
    ],


];