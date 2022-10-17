<?php

use App\Http\Controllers\ArchivedController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkOrderController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\BillingAddressController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\PartsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\UserPermissions;
use Illuminate\Support\Facades\Auth;


Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/validate-login', [AuthController::class, 'validateLogin']);

Route::middleware([AuthMiddleware::class])->group(function () {

    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/', function () {
        return view('layouts.master');
    });

    Route::get('/users', [UsersController::class, 'index'])->name('Users')->middleware([UserPermissions::class]);
    Route::get('/users/list', [UsersController::class, 'getUsers'])->name('users.list');//AJAX
    Route::post('/user', [UsersController::class, 'store']);
    Route::get('/get-user', [UsersController::class, 'getUser']);
    Route::put('/user/{user_id}', [UsersController::class, 'edit']);
    Route::delete('/user/{user_id}', [UsersController::class, 'destroy']);

    Route::get('/get-page-user', [UsersController::class, 'getPageUser'])->name('page.user');//AJAX
    Route::post('/update-user-rights', [UsersController::class, 'updateUserRights']);
    Route::get('/get-button-user', [UsersController::class, 'getButtoneUser'])->name('button.user');//AJAX
    Route::post('/update-button-user', [UsersController::class, 'updateButtonUser']);

    Route::get('/vendor', [VendorController::class, 'index'])->name('Vendor')->middleware([UserPermissions::class]);
    Route::get('/vendor/list', [VendorController::class, 'getVendors'])->name('vendor.list');//AJAX
    Route::get('/get-vendor', [VendorController::class, 'getVendor']);//AJAX
    Route::post('/vendor', [VendorController::class, 'store']);
    Route::put('/vendor/{vendor_id}', [VendorController::class, 'update']);
    Route::delete('/vendor/{vendor_id}', [VendorController::class, 'destroy']);

    Route::get('/payments', [PaymentController::class, 'index'])->name('Payments')->middleware([UserPermissions::class]);
    Route::get('/payments/list', [PaymentController::class, 'getPayments'])->name('payments.list');//AJAX
    Route::post('/update-payment-received', [PaymentController::class, 'updateReceived']);//AJAX
    Route::get('/get-invoice-amounts', [PaymentController::class, 'getAmounts']);//AJAX
    Route::get('/get-payment-data', [PaymentController::class, 'getPayment']);//AJAX

    Route::get('/archived', [ArchivedController::class, 'index'])->name('Archived')->middleware([UserPermissions::class]);
    Route::get('/archived/list', [ArchivedController::class, 'getArchived'])->name('archived.list');//AJAX
    Route::put('/workorder/{workorder_id}/un-archived', [ArchivedController::class, 'workorderUnArchive']);

    Route::get('/customers', [CustomersController::class, 'index'])->name('Customers')->middleware([UserPermissions::class]);
    Route::get('/customers/list', [CustomersController::class, 'getCustomers'])->name('customers.list');//AJAX
    Route::get('/customers/create', [CustomersController::class, 'createCustomer']);
    Route::post('/customers/store', [CustomersController::class, 'storeCustomer']);
    Route::get('/customers/{customer_id}/update', [CustomersController::class, 'updateCustomer']);
    Route::put('/customers/{customer_id}/update', [CustomersController::class, 'editCustomer']);
    Route::delete('/customer/{customer_id}', [CustomersController::class, 'destroyCustomer']);
    Route::get('/contacts/list', [CustomersController::class, 'getContacts'])->name('contacts.list');//AJAX
    Route::get('/get-contact', [CustomersController::class, 'getContact']);//AJAX
    Route::put('/contacts/contact/{contact_id}', [CustomersController::class, 'editContact']);
    Route::post('/contacts/store', [CustomersController::class, 'storeContact']);
    Route::delete('/contact/{contact_id}', [CustomersController::class, 'destroyContact']);

    Route::get('/company', [CompanyController::class, 'index'])->name('Company')->middleware([UserPermissions::class]);
    Route::post('/company', [CompanyController::class, 'store']);
    Route::put('/company/{company_id}', [CompanyController::class, 'update']);
    Route::delete('/company/{company_id}', [CompanyController::class, 'destroy']);

    Route::get('/billing-address', [BillingAddressController::class, 'index'])->name('Billing Address')->middleware([UserPermissions::class]);
    Route::post('/billing-address', [BillingAddressController::class, 'store']);
    Route::put('/billing-address/{billing_address_id}', [BillingAddressController::class, 'update']);
    Route::delete('/billing-address/{billing_address_id}', [BillingAddressController::class, 'destroy']);

    Route::get('/parts', [PartsController::class, 'index'])->name('Parts')->middleware([UserPermissions::class]);
    Route::post('/parts', [PartsController::class, 'store']);
    Route::put('/parts/{part_id}', [PartsController::class, 'update']);
    Route::delete('/parts/{part_id}', [PartsController::class, 'destroy']);

    // *** Routes for Workorders -Start- ***
    Route::get('/workorders', [WorkOrderController::class, 'index'])->name('Workorders')->middleware([UserPermissions::class]);
        Route::get('/workorders/list', [WorkOrderController::class, 'getWorkOrders'])->name('workorders.list');//AJAX

        Route::get('/workorder/{workorder_id}/invoice', [WorkOrderController::class, 'workorderInvoice']);

        Route::put('/workorder/{workorder_id}/archived', [WorkOrderController::class, 'archiveWorkorder']);
        Route::put('/workorder/{workorder_id}/cancelled', [WorkOrderController::class, 'cancelWorkorder']);

        // *** Routes for Workorder CREATE and related items -Start- ***
        Route::get('/workorders/create', [WorkOrderController::class, 'createWorkorder']);
        Route::post('/workorders/store', [WorkOrderController::class, 'storeWorkorder']);
        // *** Routes for Workorder CREATE and related items -End- ***

        // *** Routes for Workorder UPDATE and related items -Start- ***
        Route::get('/workorders/workorder/{workorder_id}', [WorkOrderController::class, 'editWorkorder']);
        Route::put('/workorders/workorder/{workorder_id}', [WorkOrderController::class, 'updateWorkorder']);
        Route::get('/get-company-addresses', [WorkOrderController::class, 'getCompanyAddresses']);//AJAX
        Route::get('/get-company-persons', [WorkOrderController::class, 'getCompanyPersons']);//AJAX

        Route::post('/workorders/parts', [WorkOrderController::class, 'storeParts']);
        Route::put('/workorders/part/{wo_part_id}', [WorkOrderController::class, 'updateParts']);
        Route::delete('/workorders/part/{wo_part_id}', [WorkOrderController::class, 'destroyParts']);
        Route::get('/get-product', [WorkOrderController::class, 'getProduct']);//AJAX

        Route::post('/workorders/labors', [WorkOrderController::class, 'storeLabors']);
        Route::put('/workorders/labor/{wo_labor_id}', [WorkOrderController::class, 'updateLabors']);
        Route::delete('/workorders/labor/{wo_labor_id}', [WorkOrderController::class, 'destroyLabors']);

        Route::post('/workorders/payments', [WorkOrderController::class, 'storePayments']);
        Route::put('/workorders/payment/{payment_id}', [WorkOrderController::class, 'updatePayments']);
        Route::delete('/workorders/payment/{payment_id}', [WorkOrderController::class, 'destroyPayments']);

        Route::get('/get-company-history', [WorkOrderController::class, 'getCompanyHistory']);//AJAX
        // *** Routes for Workorder UPDATE and related items -End- ***

    // *** Routes for Workorders -End- ***

    Route::get('/reports', [ReportsController::class, 'index'])->name('Reports')->middleware([UserPermissions::class]);
    Route::get('/reports/monthly-sale', [ReportsController::class, 'getMonthlySale']);
    Route::get('/reports/receivable', [ReportsController::class, 'getReceivable']);
    Route::get('/reports/pending', [ReportsController::class, 'getPending']);
    Route::get('/reports/product', [ReportsController::class, 'getProduct']);
    Route::get('/reports/tax', [ReportsController::class, 'getTax']);
    Route::get('/reports/stat', [ReportsController::class, 'getStat']);
    Route::get('/reports/branch', [ReportsController::class, 'getBranch']);
    Route::get('/reports/order-list', [ReportsController::class, 'getOrderList']);
    Route::get('/reports/vendor', [ReportsController::class, 'getVendor']);
    Route::get('/reports/report-name', [ReportsController::class, 'getReportName']);
    Route::get('/reports/country', [ReportsController::class, 'getCountry']);

});

