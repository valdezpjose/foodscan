<?php

namespace Database\Seeders;

use App\Libraries\AppLibrary;
use App\Models\Menu;
use Illuminate\Database\Seeder;


class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            [
                'name'       => 'Dashboard',
                'language'   => 'dashboard',
                'url'        => 'dashboard',
                'icon'       => 'lab lab-dashboard',
                'priority'   => 100,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Items',
                'language'   => 'items',
                'url'        => 'items',
                'icon'       => 'lab lab-items',
                'priority'   => 100,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now()

            ],
            [
                'name'       => 'Dining Tables',
                'language'   => 'dining_tables',
                'url'        => 'dining-tables',
                'icon'       => 'lab lab-dining-table',
                'priority'   => 100,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now()

            ],
            [
                'name'       => 'Pos & Orders',
                'language'   => 'pos_and_orders',
                'url'        => '#',
                'icon'       => 'lab lab-pos',
                'priority'   => 100,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'name'       => 'POS',
                        'url'        => 'pos',
                        'language'   => 'pos',
                        'icon'       => 'lab lab-pos',
                        'priority'   => 100,
                        'status'     => 1,
                        'created_at' => now(),
                        'updated_at' => now()

                    ],
                    [
                        'name'       => 'POS Orders',
                        'language'   => 'pos_orders',
                        'url'        => 'pos-orders',
                        'icon'       => 'lab lab-pos-orders',
                        'priority'   => 100,
                        'status'     => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ],
                    [
                        'name'       => 'Table Orders',
                        'language'   => 'table_orders',
                        'url'        => 'table-orders',
                        'icon'       => 'lab lab-reserve-line',
                        'priority'   => 100,
                        'status'     => 1,
                        'created_at' => now(),
                        'updated_at' => now()

                    ],
                    [
                        'name'       => 'K.D.S',
                        'language'   => 'k_d_s',
                        'url'        => 'kitchen-display-system',
                        'icon'       => 'lab lab-kds',
                        'priority'   => 100,
                        'status'     => 1,
                        'created_at' => now(),
                        'updated_at' => now()

                    ],
                    [
                        'name'       => 'O.S.S',
                        'language'   => 'o_s_s',
                        'url'        => 'order-status-screen',
                        'icon'       => 'lab lab-cds',
                        'priority'   => 100,
                        'status'     => 1,
                        'created_at' => now(),
                        'updated_at' => now()

                    ]
                ],
            ],
            [
                'name'       => 'Promo',
                'language'   => 'promo',
                'url'        => '#',
                'icon'       => 'lab ',
                'priority'   => 100,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'name'       => 'Offers',
                        'language'   => 'offers',
                        'url'        => 'offers',
                        'icon'       => 'lab lab-offers',
                        'priority'   => 100,
                        'status'     => 1,
                        'created_at' => now(),
                        'updated_at' => now()

                    ]
                ]
            ],
            [
                'name'       => 'Users',
                'language'   => 'users',
                'url'        => '#',
                'icon'       => 'lab ',
                'priority'   => 100,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'name'       => 'Administrators',
                        'language'   => 'administrators',
                        'url'        => 'administrators',
                        'icon'       => 'lab lab-administrators',
                        'priority'   => 100,
                        'status'     => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ],
                    [
                        'name'       => 'Customers',
                        'language'   => 'customers',
                        'url'        => 'customers',
                        'icon'       => 'lab lab-customers',
                        'priority'   => 100,
                        'status'     => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ],
                    [
                        'name'       => 'Employees',
                        'language'   => 'employees',
                        'url'        => 'employees',
                        'icon'       => 'lab lab-employee',
                        'priority'   => 100,
                        'status'     => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ],
                    [
                        'name'       => 'Waiters',
                        'language'   => 'waiters',
                        'url'        => 'waiters',
                        'icon'       => 'lab lab-waiter',
                        'priority'   => 100,
                        'status'     => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ],
                    [
                        'name'       => 'Chef',
                        'language'   => 'chefs',
                        'url'        => 'chefs',
                        'icon'       => 'lab lab-chef',
                        'priority'   => 100,
                        'status'     => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ],
                ]
            ],
            [
                'name'       => 'Accounts',
                'language'   => 'accounts',
                'url'        => '#',
                'icon'       => 'lab ',
                'priority'   => 100,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'name'       => 'Transactions',
                        'language'   => 'transactions',
                        'url'        => 'transactions',
                        'icon'       => 'lab lab-transactions',
                        'priority'   => 100,
                        'status'     => 1,
                        'created_at' => now(),
                        'updated_at' => now()

                    ]
                ]
            ],
            [
                'name'       => 'Reports',
                'language'   => 'reports',
                'url'        => '#',
                'icon'       => 'lab ',
                'priority'   => 100,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'name'       => 'Sales Report',
                        'language'   => 'sales_report',
                        'url'        => 'sales-report',
                        'icon'       => 'lab lab-sales-report',
                        'priority'   => 100,
                        'status'     => 1,
                        'created_at' => now(),
                        'updated_at' => now()

                    ],

                    [
                        'name'       => 'Items Report',
                        'language'   => 'items_report',
                        'url'        => 'items-report',
                        'icon'       => 'lab lab-items-report',
                        'priority'   => 100,
                        'status'     => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ],
                    [
                        'name'       => 'Credit Balance Report',
                        'language'   => 'credit_balance_report',
                        'url'        => 'credit-balance-report',
                        'icon'       => 'lab lab-credit-balance-report',
                        'priority'   => 100,
                        'status'     => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]

                ]
            ],
            [
                'name'       => 'Setup',
                'language'   => 'setup',
                'url'        => '#',
                'icon'       => 'lab ',
                'priority'   => 100,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'name'       => 'Settings',
                        'language'   => 'settings',
                        'url'        => 'settings',
                        'icon'       => 'lab lab-settings',
                        'priority'   => 100,
                        'status'     => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                ]
            ]
        ];

        Menu::insert(AppLibrary::associativeToNumericArrayBuilder($menus));
    }
}
