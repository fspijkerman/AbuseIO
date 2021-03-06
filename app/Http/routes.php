<?php
Route::controllers(
    [
        'auth' => 'Auth\AuthController',
        'password' => 'Auth\PasswordController',
    ]
);

// Go to admin home when / is called.
Route::get(
    "/",
    function () {
        return Redirect::to('/admin/home');
    }
);

// All calls within the 'admin' prefix
Route::group(
    [
        'prefix' => 'admin',
        'middleware' => [
            'auth',
            'acl:admin_login'
        ],
    ],
    function () {

        Route::get(
            "/",
            function () {
                return Redirect::to('/admin/home');
            }
        );

        Route::get(
            'home',
            'HomeController@index'
        );

        // Contact routes
        Route::model('contacts', 'AbuseIO\Models\Contact');
        Route::resource('contacts', 'ContactsController');
        Route::get(
            'export/contacts',
            [
                'as' => 'admin.export.contacts',
                'uses' => 'ContactsController@export',
            ]
        );

        // Netblock routes
        Route::model('netblocks', 'AbuseIO\Models\Netblock');
        Route::resource('netblocks', 'NetblocksController');
        Route::get(
            'export/netblocks',
            [
                'as' => 'admin.export.netblocks',
                'uses' => 'NetblocksController@export',
            ]
        );

        // Domain routes
        Route::model('domains', 'AbuseIO\Models\Domain');
        Route::resource('domains', 'DomainsController');
        Route::get(
            'export/domains',
            [
                'as' => 'admin.export.domains',
                'uses' => 'DomainsController@export',
            ]
        );

        // Tickets routes
        Route::model('tickets', 'AbuseIO\Models\Ticket');
        Route::resource('tickets', 'TicketsController');
        Route::get(
            'export/tickets',
            [
                'as' => 'admin.export.tickets',
                'uses' => 'TicketsController@export',
            ]
        );

        Route::group(
            [
                'prefix' => 'tickets/status'
            ],
            function () {
                Route::resource('open', 'TicketsController@statusOpen');
                Route::resource('closed', 'TicketsController@statusClosed');
            }
        );

        // Search routes
        Route::get('search', 'SearchController@index');

        // Analytics routes
        Route::get('analytics', 'AnalyticsController@index');

        // Language switcher
        Route::get('locale/{locale?}', 'LocaleController@setLocale');

        // Settings related
        Route::model('accounts', 'AbuseIO\Models\Account');
        Route::resource('accounts', 'AccountsController');

        Route::model('brands', 'AbuseIO\Models\Brand');
        Route::resource('brands', 'BrandsController');

        Route::model('users', 'AbuseIO\Models\User');
        Route::resource('users', 'UsersController');

        Route::resource('profile', 'ProfilesController');
    }
);

// Ash routes
Route::group(
    [
        'prefix' => 'ash',
    ],
    function () {
        Route::get('collect/{ticketID}/{token}', 'AshController@index');

        // Language switcher
        Route::get('locale/{locale?}', 'LocaleController@setLocale');
    }
);

// Api routes
Route::group(
    [
        'prefix' => 'api',
    ],
    function () {
        // TODO
    }
);
