<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OtpController;
use App\Http\Controllers\Admin\PosController;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\Admin\ChefController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\MailController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\ThemeController;
use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\WaiterController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\LicenseController;
use App\Http\Controllers\Admin\AnalyticController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\PosOrderController;
use App\Http\Controllers\Admin\TimezoneController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ItemAddonController;
use App\Http\Controllers\Admin\ItemExtraController;
use App\Http\Controllers\Admin\OfferItemController;
use App\Http\Controllers\Auth\DeactivateController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\SimpleUserController;
use App\Http\Controllers\Admin\SmsGatewayController;
use App\Http\Controllers\Auth\GuestSignupController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\SettingController;
use App\Http\Controllers\Admin\ChefAddressController;
use App\Http\Controllers\Admin\CountryCodeController;
use App\Http\Controllers\Admin\DiningTableController;
use App\Http\Controllers\Admin\ItemsReportController;
use App\Http\Controllers\Admin\MenuSectionController;
use App\Http\Controllers\Admin\PosCategoryController;
use App\Http\Controllers\Admin\SalesReportController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Auth\RefreshTokenController;
use App\Http\Controllers\Admin\ItemCategoryController;
use App\Http\Controllers\Admin\MenuTemplateController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\AdministratorController;
use App\Http\Controllers\Admin\DefaultAccessController;
use App\Http\Controllers\Admin\ItemAttributeController;
use App\Http\Controllers\Admin\ItemVariationController;
use App\Http\Controllers\Admin\WaiterAddressController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Frontend\TokenStoreController;
use App\Http\Controllers\Admin\MyOrderDetailsController;
use App\Http\Controllers\Admin\PaymentGatewayController;
use App\Http\Controllers\Admin\AnalyticSectionController;
use App\Http\Controllers\Admin\CustomerAddressController;
use App\Http\Controllers\Admin\EmployeeAddressController;
use App\Http\Controllers\Admin\NotificationAlertController;
use App\Http\Controllers\Admin\OrderStatusScreenController;
use App\Http\Controllers\Admin\CreditBalanceReportController;
use App\Http\Controllers\Admin\AdministratorAddressController;
use App\Http\Controllers\Admin\KitchenDisplaySystemController;
use App\Http\Controllers\Table\OrderController as TableOrderController;
use App\Http\Controllers\Frontend\ItemController as FrontendItemController;
use App\Http\Controllers\Frontend\PageController as FrontendPageController;
use App\Http\Controllers\Frontend\BranchController as FrontendBranchController;
use App\Http\Controllers\Admin\TableOrderController as AdminTableOrderController;
use App\Http\Controllers\Frontend\LanguageController as FrontendLanguageController;
use App\Http\Controllers\Table\DiningTableController as TableDiningTableController;
use App\Http\Controllers\Table\ItemCategoryController as TableItemCategoryController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::match(['get', 'post'], '/login', function () {
    return response()->json(['errors' => 'unauthenticated'], 401);
})->name('login');

Route::match(['get', 'post'], '/refresh-token', [RefreshTokenController::class, 'refreshToken'])->middleware(['installed']);

Route::prefix('auth')->middleware(['installed', 'apiKey', 'localization'])->name('auth.')->namespace('Auth')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);

    Route::prefix('forgot-password')->name('forgot-password.')->group(function () {
        Route::post('/', [ForgotPasswordController::class, 'forgotPassword']);
        Route::post('/verify-code', [ForgotPasswordController::class, 'verifyCode']);
        Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);
    });

    Route::prefix('signup')->name('signup.')->group(function () {
        Route::post('/otp', [SignupController::class, 'otp']);
        Route::post('/verify', [SignupController::class, 'verify']);
        Route::post('/register', [SignupController::class, 'register']);
    });

    Route::prefix('guest-signup')->name('guest-signup.')->group(function () {
        Route::post('/otp', [GuestSignupController::class, 'otp']);
        Route::post('/verify', [GuestSignupController::class, 'verify']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('verify.api')->group(function () {
            Route::post('/logout', [LoginController::class, 'logout']);
            Route::post('/delete-account', [DeactivateController::class, 'deleteAccount']);
        });
    });

    Route::post('/authcheck', function () {
        if (Auth::check()) {
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    });
});

/* all routes must be singular word*/
Route::prefix('profile')->name('profile.')->middleware(['installed', 'apiKey', 'auth:sanctum', 'localization'])->group(function () {
    Route::get('/', [ProfileController::class, 'profile']);
    Route::match(['put', 'patch'], '/', [ProfileController::class, 'update']);
    Route::match(['put', 'patch'], '/change-password', [ProfileController::class, 'changePassword']);
    Route::post('/change-image', [ProfileController::class, 'changeImage']);
});

Route::prefix('admin')->name('admin.')->middleware(['installed', 'apiKey', 'auth:sanctum', 'localization'])->group(function () {
    Route::prefix('default-access')->name('default-access.')->group(function () {
        Route::get('/', [DefaultAccessController::class, 'index']);
        Route::post('/', [DefaultAccessController::class, 'storeOrUpdate']);
    });

    Route::prefix('setting')->name('setting.')->group(function () {
        Route::prefix('company')->name('company.')->group(function () {
            Route::get('/', [CompanyController::class, 'index']);
            Route::match(['put', 'patch'], '/', [CompanyController::class, 'update']);
        });

        Route::prefix('site')->name('site.')->group(function () {
            Route::get('/', [SiteController::class, 'index']);
            Route::match(['put', 'patch'], '/', [SiteController::class, 'update']);
        });

        Route::prefix('mail')->name('mail.')->group(function () {
            Route::get('/', [MailController::class, 'index']);
            Route::match(['put', 'patch'], '/', [MailController::class, 'update']);
        });

        Route::prefix('currency')->name('currency.')->group(function () {
            Route::get('/', [CurrencyController::class, 'index']);
            Route::get('/show/{currency}', [CurrencyController::class, 'show']);
            Route::post('/', [CurrencyController::class, 'store']);
            Route::match(['put', 'patch'], '/{currency}', [CurrencyController::class, 'update']);
            Route::delete('/{currency}', [CurrencyController::class, 'destroy']);
        });

        Route::prefix('tax')->name('tax.')->group(function () {
            Route::get('/', [TaxController::class, 'index']);
            Route::get('/show/{tax}', [TaxController::class, 'show']);
            Route::post('/', [TaxController::class, 'store']);
            Route::match(['put', 'patch'], '/{tax}', [TaxController::class, 'update']);
            Route::delete('/{tax}', [TaxController::class, 'destroy']);
        });

        Route::prefix('item-category')->name('item-category.')->group(function () {
            Route::get('/', [ItemCategoryController::class, 'index']);
            Route::get('/show/{itemCategory}', [ItemCategoryController::class, 'show']);
            Route::post('/', [ItemCategoryController::class, 'store']);
            Route::match(['post', 'put', 'patch'], '/{itemCategory}', [ItemCategoryController::class, 'update']);
            Route::delete('/{itemCategory}', [ItemCategoryController::class, 'destroy']);
            Route::post('/sort/category', [ItemCategoryController::class, 'sortCategory']);
            Route::get('/export', [ItemCategoryController::class, 'export']);
            Route::get('/download-sample', [ItemCategoryController::class, 'downloadSample']);
            Route::post('/import/file', [ItemCategoryController::class, 'import']);
        });

        Route::prefix('item-attribute')->name('item-attribute.')->group(function () {
            Route::get('/', [ItemAttributeController::class, 'index']);
            Route::get('/show/{itemAttribute}', [ItemAttributeController::class, 'show']);
            Route::post('/', [ItemAttributeController::class, 'store']);
            Route::match(['put', 'patch'], '/{itemAttribute}', [ItemAttributeController::class, 'update']);
            Route::delete('/{itemAttribute}', [ItemAttributeController::class, 'destroy']);
        });

        Route::prefix('branch')->name('branch.')->group(function () {
            Route::get('/', [BranchController::class, 'index']);
            Route::get('/show/{branch}', [BranchController::class, 'show']);
            Route::post('/', [BranchController::class, 'store']);
            Route::match(['put', 'patch'], '/{branch}', [BranchController::class, 'update']);
            Route::delete('/{branch}', [BranchController::class, 'destroy']);
        });

        Route::prefix('menu-section')->name('menu-section.')->group(function () {
            Route::get('/', [MenuSectionController::class, 'index']);
        });

        Route::prefix('menu-template')->name('menu-template.')->group(function () {
            Route::get('/', [MenuTemplateController::class, 'index']);
            Route::get('/show/{menuTemplate}', [MenuTemplateController::class, 'show']);
            Route::post('/', [MenuTemplateController::class, 'store']);
            Route::match(['put', 'patch'], '/{menuTemplate}', [MenuTemplateController::class, 'update']);
            Route::delete('/{menuTemplate}', [MenuTemplateController::class, 'destroy']);
        });

        Route::prefix('page')->name('page.')->group(function () {
            Route::get('/', [PageController::class, 'index']);
            Route::get('/show/{page}', [PageController::class, 'show']);
            Route::post('/', [PageController::class, 'store']);
            Route::match(['post', 'put', 'patch'], '/{page}', [PageController::class, 'update']);
            Route::delete('/{page}', [PageController::class, 'destroy']);
        });

        Route::prefix('license')->name('license.')->group(function () {
            Route::get('/', [LicenseController::class, 'index']);
            Route::match(['put', 'patch'], '/', [LicenseController::class, 'update']);
        });

        Route::prefix('theme')->name('theme.')->group(function () {
            Route::get('/', [ThemeController::class, 'index']);
            Route::post('/', [ThemeController::class, 'update']);
        });

        Route::prefix('sms-gateway')->name('sms-gateway.')->group(function () {
            Route::get('/', [SmsGatewayController::class, 'index']);
            Route::match(['put', 'patch'], '/', [SmsGatewayController::class, 'update']);
        });

        Route::prefix('payment-gateway')->name('payment-gateway.')->group(function () {
            Route::get('/', [PaymentGatewayController::class, 'index']);
            Route::match(['put', 'patch'], '/', [PaymentGatewayController::class, 'update']);
        });

        Route::prefix('analytic')->name('analytic.')->group(function () {
            Route::get('/', [AnalyticController::class, 'index']);
            Route::get('/show/{analytic}', [AnalyticController::class, 'show']);
            Route::post('/', [AnalyticController::class, 'store']);
            Route::match(['put', 'patch'], '/{analytic}', [AnalyticController::class, 'update']);
            Route::delete('/{analytic}', [AnalyticController::class, 'destroy']);
        });

        Route::prefix('analytic-section')->name('analytic-section.')->group(function () {
            Route::get('/{analytic}', [AnalyticSectionController::class, 'index']);
            Route::post('/{analytic}', [AnalyticSectionController::class, 'store']);
            Route::match(
                ['put', 'patch'],
                '/{analytic}/{analyticSection}',
                [AnalyticSectionController::class, 'update']
            );
            Route::delete('/{analytic}/{analyticSection}', [AnalyticSectionController::class, 'destroy']);
        });

        Route::prefix('otp')->name('otp.')->group(function () {
            Route::get('/', [OtpController::class, 'index']);
            Route::match(['put', 'patch'], '/', [OtpController::class, 'update']);
        });

        Route::prefix('role')->name('role.')->group(function () {
            Route::get('/', [RoleController::class, 'index']);
            Route::post('/', [RoleController::class, 'store']);
            Route::get('/show/{role}', [RoleController::class, 'show']);
            Route::match(['put', 'patch'], '/{role}', [RoleController::class, 'update']);
            Route::delete('/{role}', [RoleController::class, 'destroy']);
        });

        Route::prefix('permission')->name('permission.')->group(function () {
            Route::get('/{role}', [PermissionController::class, 'index']);
            Route::match(['put', 'patch'], '/{role}', [PermissionController::class, 'update']);
        });


        Route::prefix('language')->name('language.')->group(function () {
            Route::get('/', [LanguageController::class, 'index']);
            Route::post('/', [LanguageController::class, 'store']);
            Route::get('/show/{language}', [LanguageController::class, 'show']);
            Route::match(['post', 'put', 'patch'], '/update/{language}', [LanguageController::class, 'update']);
            Route::delete('/{language}', [LanguageController::class, 'destroy']);

            Route::get('/file-list/{language:code}', [LanguageController::class, 'fileList']);
            Route::post('/file-text', [LanguageController::class, 'fileText']);
            Route::post('/file-text/store', [LanguageController::class, 'fileTextStore']);
        });

        Route::prefix('notification-alert')->name('notification-alert.')->group(function () {
            Route::get('/', [NotificationAlertController::class, 'index']);
            Route::match(['put', 'patch'], '/', [NotificationAlertController::class, 'update']);
        });

        Route::prefix('notification')->name('notification.')->group(function () {
            Route::get('/', [NotificationController::class, 'index']);
            Route::post('/', [NotificationController::class, 'update']);
        });
    });

    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/', [CustomerController::class, 'index']);
        Route::post('/', [CustomerController::class, 'store']);
        Route::get('/show/{customer}', [CustomerController::class, 'show']);
        Route::match(['post', 'put', 'patch'], '/{customer}', [CustomerController::class, 'update']);
        Route::delete('/{customer}', [CustomerController::class, 'destroy']);

        Route::get('/export', [CustomerController::class, 'export']);
        Route::post('/change-password/{customer}', [CustomerController::class, 'changePassword']);
        Route::post('/change-image/{customer}', [CustomerController::class, 'changeImage']);

        Route::get('/my-order/{customer}', [CustomerController::class, 'myOrder']);

        Route::get('/address/{customer}', [CustomerAddressController::class, 'index']);
        Route::get('/address/show/{customer}/{address}', [CustomerAddressController::class, 'show']);
        Route::post('/address/{customer}', [CustomerAddressController::class, 'store']);
        Route::match(['put', 'patch'], '/address/{customer}/{address}', [CustomerAddressController::class, 'update']);
        Route::delete('/address/{customer}/{address}', [CustomerAddressController::class, 'destroy']);
    });

    Route::prefix('my-order')->name('my-order.')->group(function () {
        Route::get('/show/{user}/{order}', [MyOrderDetailsController::class, 'orderDetails']);
    });

    Route::prefix('employee')->name('employee.')->group(function () {
        Route::get('/', [EmployeeController::class, 'index']);
        Route::post('/', [EmployeeController::class, 'store']);
        Route::get('/show/{employee}', [EmployeeController::class, 'show']);
        Route::match(['put', 'patch'], '/{employee}', [EmployeeController::class, 'update']);
        Route::delete('/{employee}', [EmployeeController::class, 'destroy']);

        Route::get('/export', [EmployeeController::class, 'export']);
        Route::post('/change-password/{employee}', [EmployeeController::class, 'changePassword']);
        Route::post('/change-image/{employee}', [EmployeeController::class, 'changeImage']);

        Route::get('/my-order/{employee}', [EmployeeController::class, 'myOrder']);

        Route::get('/address/{employee}', [EmployeeAddressController::class, 'index']);
        Route::get('/address/show/{employee}/{address}', [EmployeeAddressController::class, 'show']);
        Route::post('/address/{employee}', [EmployeeAddressController::class, 'store']);
        Route::match(['put', 'patch'], '/address/{employee}/{address}', [EmployeeAddressController::class, 'update']);
        Route::delete('/address/{employee}/{address}', [EmployeeAddressController::class, 'destroy']);
    });


    Route::prefix('offer')->name('offer.')->group(function () {
        Route::get('/', [OfferController::class, 'index']);
        Route::get('/show/{offer}', [OfferController::class, 'show']);
        Route::post('/', [OfferController::class, 'store']);
        Route::match(['post', 'put', 'patch'], '/{offer}', [OfferController::class, 'update']);
        Route::delete('/{offer}', [OfferController::class, 'destroy']);
        Route::get('/export', [OfferController::class, 'export']);
        Route::post('/change-image/{offer}', [OfferController::class, 'changeImage']);

        Route::get('/item/{offer}', [OfferItemController::class, 'index']);
        Route::post('/item/{offer}', [OfferItemController::class, 'store']);
        Route::delete('/item/{offer}/{offerItem}', [OfferItemController::class, 'destroy']);
    });

    Route::prefix('item')->name('item.')->group(function () {
        Route::get('/', [ItemController::class, 'index']);
        Route::get('/show/{item}', [ItemController::class, 'show']);
        Route::post('/', [ItemController::class, 'store']);
        Route::match(['post', 'put', 'patch'], '/{item}', [ItemController::class, 'update']);
        Route::delete('/{item}', [ItemController::class, 'destroy']);
        Route::post('/change-image/{item}', [ItemController::class, 'changeImage']);
        Route::get('/export', [ItemController::class, 'export']);
        Route::get('/download-sample', [ItemController::class, 'downloadSample']);
        Route::post('/import/file', [ItemController::class, 'import']);
        Route::get('/details/{item}', [ItemController::class, 'itemDetails']);

        Route::get('/variation/{item}', [ItemVariationController::class, 'index']);
        Route::get('/variation/group-by-attribute/{item}', [ItemVariationController::class, 'listGroupByAttribute']);
        Route::post('/variation/{item}', [ItemVariationController::class, 'store']);
        Route::match(['put', 'patch'], '/variation/{item}/{itemVariation}', [ItemVariationController::class, 'update']);
        Route::delete('/variation/{item}/{itemVariation}', [ItemVariationController::class, 'destroy']);
        Route::get('/variation/{item}/show/{itemVariation}', [ItemVariationController::class, 'show']);

        Route::get('/extra/{item}', [ItemExtraController::class, 'index']);
        Route::post('/extra/{item}', [ItemExtraController::class, 'store']);
        Route::match(['put', 'patch'], '/extra/{item}/{itemExtra}', [ItemExtraController::class, 'update']);
        Route::delete('/extra/{item}/{itemExtra}', [ItemExtraController::class, 'destroy']);
        Route::get('/extra/{item}/show/{itemExtra}', [ItemExtraController::class, 'show']);

        Route::get('/addon/{item}', [ItemAddonController::class, 'index']);
        Route::post('/addon/{item}', [ItemAddonController::class, 'store']);
        Route::delete('/addon/{item}/{itemAddon}', [ItemAddonController::class, 'destroy']);
    });

    Route::prefix('pos')->name('pos.')->group(function () {
        Route::post('/', [PosController::class, 'store']);
        Route::post('/customer', [PosController::class, 'storeCustomer']);
    });

    Route::prefix('pos-order')->name('posOrder.')->group(function () {
        Route::get('/', [PosOrderController::class, 'index']);
        Route::get('show/{order}', [PosOrderController::class, 'show']);
        Route::delete('/{order}', [PosOrderController::class, 'destroy']);
        Route::get('/export', [PosOrderController::class, 'export']);
        Route::post('/change-status/{order}', [PosOrderController::class, 'changeStatus']);
        Route::post('/change-payment-status/{order}', [PosOrderController::class, 'changePaymentStatus']);
    });

    Route::prefix('table-order')->name('tableOrder.')->group(function () {
        Route::get('/', [AdminTableOrderController::class, 'index']);
        Route::get('/show/{order}', [AdminTableOrderController::class, 'show']);
        Route::delete('/{order}', [AdminTableOrderController::class, 'destroy']);
        Route::get('/export', [AdminTableOrderController::class, 'export']);
        Route::post('/change-status/{order}', [AdminTableOrderController::class, 'changeStatus']);
        Route::post('/change-payment-status/{order}', [AdminTableOrderController::class, 'changePaymentStatus']);
        Route::post('/token-create/{order}', [AdminTableOrderController::class, 'tokenCreate']);
    });


    Route::prefix('administrator')->name('administrator.')->group(function () {
        Route::get('/', [AdministratorController::class, 'index']);
        Route::get('/show/{administrator}', [AdministratorController::class, 'show']);
        Route::post('/', [AdministratorController::class, 'store']);
        Route::match(['post', 'put', 'patch'], '/{administrator}', [AdministratorController::class, 'update']);
        Route::delete('/{administrator}', [AdministratorController::class, 'destroy']);

        Route::get('/export', [AdministratorController::class, 'export']);
        Route::post('/change-password/{administrator}', [AdministratorController::class, 'changePassword']);
        Route::post('/change-image/{administrator}', [AdministratorController::class, 'changeImage']);

        Route::get('/my-order/{administrator}', [AdministratorController::class, 'myOrder']);

        Route::get('/address/{administrator}', [AdministratorAddressController::class, 'index']);
        Route::get('/address/show/{administrator}/{address}', [AdministratorAddressController::class, 'show']);
        Route::post('/address/{administrator}', [AdministratorAddressController::class, 'store']);
        Route::match(
            ['put', 'patch'],
            '/address/{administrator}/{address}',
            [AdministratorAddressController::class, 'update']
        );
        Route::delete('/address/{administrator}/{address}', [AdministratorAddressController::class, 'destroy']);
    });

    Route::prefix('timezone')->name('timezone.')->group(function () {
        Route::get('/', [TimezoneController::class, 'index']);
    });

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/total-sales', [DashboardController::class, 'totalSales']);
        Route::get('/total-orders', [DashboardController::class, 'totalOrders']);
        Route::get('/total-customers', [DashboardController::class, 'totalCustomers']);
        Route::get('/total-menu-items', [DashboardController::class, 'totalMenuItems']);
        Route::get('/sales-summary', [DashboardController::class, 'salesSummary']);
        Route::get('/customer-states', [DashboardController::class, 'customerStates']);
        Route::get('/featured-items', [DashboardController::class, 'featuredItems']);
        Route::get('/popular-items', [DashboardController::class, 'mostPopularItems']);
    });

    Route::prefix('sales-report')->name('sales-report.')->group(function () {
        Route::get('/', [SalesReportController::class, 'index']);
        Route::get('/export', [SalesReportController::class, 'export']);
        Route::get('/pdf', [SalesReportController::class, 'pdf']);
        Route::get('/overview', [SalesReportController::class, 'salesReportOverview']);
    });

    Route::prefix('items-report')->name('items-report.')->group(function () {
        Route::get('/', [ItemsReportController::class, 'index']);
        Route::get('/export', [ItemsReportController::class, 'export']);
        Route::get('/pdf', [ItemsReportController::class, 'pdf']);
    });

    Route::prefix('credit-balance-report')->name('credit-balance-report.')->group(function () {
        Route::get('/', [CreditBalanceReportController::class, 'index']);
        Route::get('/export', [CreditBalanceReportController::class, 'export']);
    });


    Route::prefix('country-code')->name('country-code.')->group(function () {
        Route::get('/', [CountryCodeController::class, 'index']);
        Route::get('/show/{country}', [CountryCodeController::class, 'show']);
    });

    Route::prefix('transaction')->name('transaction.')->middleware(['auth:sanctum'])->group(function () {
        Route::get('/', [TransactionController::class, 'index']);
        Route::get('/export', [TransactionController::class, 'export']);
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [SimpleUserController::class, 'index']);
    });

    Route::prefix('pos-category')->name('pos-category.')->group(function () {
        Route::get('/', [PosCategoryController::class, 'index']);
    });

    Route::prefix('dining-table')->name('dining-table.')->group(function () {
        Route::get('/', [DiningTableController::class, 'index']);
        Route::get('/show/{diningTable}', [DiningTableController::class, 'show']);
        Route::post('/', [DiningTableController::class, 'store']);
        Route::match(['post', 'put', 'patch'], '/{diningTable}', [DiningTableController::class, 'update']);
        Route::delete('/{diningTable}', [DiningTableController::class, 'destroy']);
        Route::get('/export', [DiningTableController::class, 'export']);
    });

    Route::prefix('kds-order')->name('kdsOrder.')->group(function () {
        Route::get('/', [KitchenDisplaySystemController::class, 'index']);
        Route::post('/change-status/{order}', [KitchenDisplaySystemController::class, 'changeStatus']);
        Route::get('/items', [KitchenDisplaySystemController::class, 'orderItems']);
    });
    Route::prefix('oss-order')->name('ossOrder.')->group(function () {
        Route::get('/', [OrderStatusScreenController::class, 'index']);
        Route::get('/popular-items', [OrderStatusScreenController::class, 'mostPopularItems']);
    });

    Route::prefix('waiter')->name('waiter.')->group(function () {
        Route::get('/', [WaiterController::class, 'index']);
        Route::post('/', [WaiterController::class, 'store']);
        Route::get('/show/{waiter}', [WaiterController::class, 'show']);
        Route::match(['post', 'put', 'patch'], '/{waiter}', [WaiterController::class, 'update']);
        Route::delete('/{waiter}', [WaiterController::class, 'destroy']);

        Route::get('/export', [WaiterController::class, 'export']);
        Route::post('/change-password/{waiter}', [WaiterController::class, 'changePassword']);
        Route::post('/change-image/{waiter}', [WaiterController::class, 'changeImage']);

        Route::get('/my-order/{waiter}', [WaiterController::class, 'myOrder']);

        Route::get('/address/{waiter}', [WaiterAddressController::class, 'index']);
        Route::get('/address/show/{waiter}/{address}', [WaiterAddressController::class, 'show']);
        Route::post('/address/{waiter}', [WaiterAddressController::class, 'store']);
        Route::match(['put', 'patch'], '/address/{waiter}/{address}', [WaiterAddressController::class, 'update']);
        Route::delete('/address/{waiter}/{address}', [WaiterAddressController::class, 'destroy']);
    });

    Route::prefix('chef')->name('chef.')->group(function () {
        Route::get('/', [ChefController::class, 'index']);
        Route::post('/', [ChefController::class, 'store']);
        Route::get('/show/{chef}', [ChefController::class, 'show']);
        Route::match(['post', 'put', 'patch'], '/{chef}', [ChefController::class, 'update']);
        Route::delete('/{chef}', [ChefController::class, 'destroy']);

        Route::get('/export', [ChefController::class, 'export']);
        Route::post('/change-password/{chef}', [ChefController::class, 'changePassword']);
        Route::post('/change-image/{chef}', [ChefController::class, 'changeImage']);

        Route::get('/my-order/{chef}', [ChefController::class, 'myOrder']);

        Route::get('/address/{chef}', [ChefAddressController::class, 'index']);
        Route::get('/address/show/{chef}/{address}', [ChefAddressController::class, 'show']);
        Route::post('/address/{chef}', [ChefAddressController::class, 'store']);
        Route::match(['put', 'patch'], '/address/{chef}/{address}', [ChefAddressController::class, 'update']);
        Route::delete('/address/{chef}/{address}', [ChefAddressController::class, 'destroy']);
    });
});

Route::prefix('frontend')->name('frontend.')->middleware(['installed', 'apiKey', 'localization'])->group(function () {
    Route::prefix('setting')->name('setting.')->group(function () {
        Route::get('/', [SettingController::class, 'index']);
    });

    Route::prefix('page')->name('page.')->group(function () {
        Route::get('/', [FrontendPageController::class, 'index']);
        Route::get('/show/{page:slug}', [FrontendPageController::class, 'show']);
        Route::get('/page-info/{page}', [FrontendPageController::class, 'show']);
    });

    Route::prefix('branch')->name('branch.')->group(function () {
        Route::get('/', [FrontendBranchController::class, 'index']);
        Route::get('/show/{branch}', [FrontendBranchController::class, 'show']);
    });

    Route::prefix('language')->name('language.')->group(function () {
        Route::get('/', [FrontendLanguageController::class, 'index']);
        Route::get('/show/{language}', [FrontendLanguageController::class, 'show']);
    });

    Route::prefix('item')->name('item.')->group(function () {
        Route::get('/', [FrontendItemController::class, 'index']);
        Route::get('/featured-items', [FrontendItemController::class, 'featuredItems']);
        Route::get('/popular-items', [FrontendItemController::class, 'mostPopularItems']);
        Route::get('/details/{item}', [FrontendItemController::class, 'itemDetails']);
    });

    Route::prefix('device-token')->name('device-token.')->middleware(['auth:sanctum'])->group(function () {
        Route::post('/web', [TokenStoreController::class, 'webToken']);
        Route::post('/mobile', [TokenStoreController::class, 'deviceToken']);
    });
});

Route::prefix('table')->name('table.')->middleware(['installed', 'apiKey', 'localization'])->group(function () {

    Route::prefix('item-category')->name('item-category.')->group(function () {
        Route::get('/', [TableItemCategoryController::class, 'index']);
        Route::get('/show/{itemCategory:slug}', [TableItemCategoryController::class, 'show']);
    });

    Route::prefix('dining-table')->name('dining-table.')->group(function () {
        Route::get('/', [TableDiningTableController::class, 'index']);
        Route::get('/show/{frontendDiningTable:slug}', [TableDiningTableController::class, 'show']);
    });

    Route::prefix('dining-order')->name('dining-order.')->group(function () {
        Route::get('/show/{frontendOrder}', [TableOrderController::class, 'show']);
        Route::post('/', [TableOrderController::class, 'store']);
    });
});
