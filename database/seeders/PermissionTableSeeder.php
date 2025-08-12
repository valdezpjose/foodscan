<?php

namespace Database\Seeders;

use App\Libraries\AppLibrary;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'title'      => 'Dashboard',
                'name'       => 'dashboard',
                'guard_name' => 'sanctum',
                'url'        => 'dashboard',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Items',
                'name'       => 'items',
                'guard_name' => 'sanctum',
                'url'        => 'items',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Items Create',
                        'name'       => 'items_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'items/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Items Edit',
                        'name'       => 'items_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'items/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Items Delete',
                        'name'       => 'items_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'items/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Items Show',
                        'name'       => 'items_show',
                        'guard_name' => 'sanctum',
                        'url'        => 'items/show',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]
            ],
            [
                'title'      => 'Dining Tables',
                'name'       => 'dining-tables',
                'guard_name' => 'sanctum',
                'url'        => 'dining-tables',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Dining Tables Create',
                        'name'       => 'dining_tables_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'dining-table/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Dining Tables Edit',
                        'name'       => 'dining_tables_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'dining-table/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Dining Tables Delete',
                        'name'       => 'dining_tables_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'dining-tables/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Dining Tables Show',
                        'name'       => 'dining_tables_show',
                        'guard_name' => 'sanctum',
                        'url'        => 'dining-tables/show',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]
            ],
            [
                'title'      => 'POS',
                'name'       => 'pos',
                'guard_name' => 'sanctum',
                'url'        => 'pos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'POS Orders',
                'name'       => 'pos-orders',
                'guard_name' => 'sanctum',
                'url'        => 'pos-orders',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Table Orders',
                'name'       => 'table-orders',
                'guard_name' => 'sanctum',
                'url'        => 'table-orders',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'K.D.S',
                'name'       => 'kitchen-display-system',
                'guard_name' => 'sanctum',
                'url'        => 'kitchen-display-system',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'O.S.S',
                'name'       => 'order-status-screen',
                'guard_name' => 'sanctum',
                'url'        => 'order-status-screen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Offers',
                'name'       => 'offers',
                'guard_name' => 'sanctum',
                'url'        => 'offers',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Offers Create',
                        'name'       => 'offers_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'offers/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Offers Edit',
                        'name'       => 'offers_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'offers/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Offers Delete',
                        'name'       => 'offers_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'offers/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Offers Show',
                        'name'       => 'offers_show',
                        'guard_name' => 'sanctum',
                        'url'        => 'offers/show',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]
            ],
            [
                'title'      => 'Administrators',
                'name'       => 'administrators',
                'guard_name' => 'sanctum',
                'url'        => 'administrators',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Administrators Create',
                        'name'       => 'administrators_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'administrators/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Administrators Edit',
                        'name'       => 'administrators_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'administrators/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Administrators Delete',
                        'name'       => 'administrators_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'administrators/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Administrators Show',
                        'name'       => 'administrators_show',
                        'guard_name' => 'sanctum',
                        'url'        => 'administrators/show',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]
            ],
            [
                'title'      => 'Delivery Boys',
                'name'       => 'delivery-boys',
                'guard_name' => 'sanctum',
                'url'        => 'delivery-boys',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Delivery Boys Create',
                        'name'       => 'delivery-boys_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'delivery-boys/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Delivery Boys Edit',
                        'name'       => 'delivery-boys_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'delivery-boys/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Delivery Boys Delete',
                        'name'       => 'delivery-boys_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'delivery-boys/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Delivery Boys Show',
                        'name'       => 'delivery-boys_show',
                        'guard_name' => 'sanctum',
                        'url'        => 'delivery-boys/show',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]
            ],
            [
                'title'      => 'Customers',
                'name'       => 'customers',
                'guard_name' => 'sanctum',
                'url'        => 'customers',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Customers Create',
                        'name'       => 'customers_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'customers/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Customers Edit',
                        'name'       => 'customers_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'customers/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Customers Delete',
                        'name'       => 'customers_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'customers/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Customers Show',
                        'name'       => 'customers_show',
                        'guard_name' => 'sanctum',
                        'url'        => 'customers/show',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]
            ],
            [
                'title'      => 'Employees',
                'name'       => 'employees',
                'guard_name' => 'sanctum',
                'url'        => 'employees',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Employees Create',
                        'name'       => 'employees_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'employees/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Employees Edit',
                        'name'       => 'employees_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'employees/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Employees Delete',
                        'name'       => 'employees_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'employees/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Employees Show',
                        'name'       => 'employees_show',
                        'guard_name' => 'sanctum',
                        'url'        => 'employees/show',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]
            ],
            [
                'title'      => 'Waiters',
                'name'       => 'waiters',
                'guard_name' => 'sanctum',
                'url'        => 'waiters',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Waiters Create',
                        'name'       => 'waiters_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'waiters/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Waiters Edit',
                        'name'       => 'waiters_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'waiters/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Waiters Delete',
                        'name'       => 'waiters_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'waiters/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Waiters Show',
                        'name'       => 'waiters_show',
                        'guard_name' => 'sanctum',
                        'url'        => 'waiters/show',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]
            ],
            [
                'title'      => 'Chefs',
                'name'       => 'chefs',
                'guard_name' => 'sanctum',
                'url'        => 'chefs',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Chefs Create',
                        'name'       => 'chefs_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'chefs/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Chefs Edit',
                        'name'       => 'chefs_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'chefs/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Chefs Delete',
                        'name'       => 'chefs_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'chefs/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Chefs Show',
                        'name'       => 'chefs_show',
                        'guard_name' => 'sanctum',
                        'url'        => 'chefs/show',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]
            ],
            [
                'title'      => 'Transactions',
                'name'       => 'transactions',
                'guard_name' => 'sanctum',
                'url'        => 'transactions',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Sales Report',
                'name'       => 'sales-report',
                'guard_name' => 'sanctum',
                'url'        => 'sales-report',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Items Report',
                'name'       => 'items-report',
                'guard_name' => 'sanctum',
                'url'        => 'items-report',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Credit Balance Report',
                'name'       => 'credit-balance-report',
                'guard_name' => 'sanctum',
                'url'        => 'credit-balance-report',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Settings',
                'name'       => 'settings',
                'guard_name' => 'sanctum',
                'url'        => 'settings',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        $permissions = AppLibrary::associativeToNumericArrayBuilder($permissions);
        Permission::insert($permissions);
    }
}
