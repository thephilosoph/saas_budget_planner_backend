<?php

return [

    'platform' => [
        'users' => ['create', 'update', 'delete', 'view'],
        'plans' => ['create', 'update', 'delete', 'view'],
        'tenants' => ['view', 'suspend'],
        'billing' => ['view'],
    ],

    'tenant' => [
        'budgets' => ['create', 'update', 'delete', 'view'],
        'transactions' => ['create', 'update', 'delete', 'view'],
        'categories' => ['create', 'update', 'delete', 'view'],
        'reports' => ['export', 'view'],
        'settings' => ['update'],
    ],

];
