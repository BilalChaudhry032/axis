<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkOrderController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\BillingAddressController;
use App\Http\Controllers\PartsController;
use App\Http\Controllers\PaymentController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Auth;


Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/validate-login', [AuthController::class, 'validateLogin']);

Route::middleware([AuthMiddleware::class])->group(function () {

    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/', function () {
        return view('layouts.master');
    });

    Route::get('/vendor', [VendorController::class, 'index'])->name('vendor');
    Route::get('/vendor/list', [VendorController::class, 'getVendors'])->name('vendor.list');//AJAX
    Route::get('/get-vendor', [VendorController::class, 'getVendor']);//AJAX
    Route::post('/vendor', [VendorController::class, 'store']);
    Route::put('/vendor/{vendor_id}', [VendorController::class, 'update']);
    Route::delete('/vendor/{vendor_id}', [VendorController::class, 'destroy']);

    Route::get('/payments', [PaymentController::class, 'index'])->name('payments');
    Route::get('/payments/list', [PaymentController::class, 'getPayments'])->name('payments.list');//AJAX
    Route::post('/update-payment-received', [PaymentController::class, 'updateReceived']);//AJAX
    Route::get('/get-invoice-amounts', [PaymentController::class, 'getAmounts']);//AJAX
    Route::get('/get-payment-data', [PaymentController::class, 'getPayment']);//AJAX

    Route::get('/company', [CompanyController::class, 'index'])->name('company');
    Route::post('/company', [CompanyController::class, 'store']);
    Route::put('/company/{company_id}', [CompanyController::class, 'update']);
    Route::delete('/company/{company_id}', [CompanyController::class, 'destroy']);

    Route::get('/billing-address', [BillingAddressController::class, 'index'])->name('billingAddress');
    Route::post('/billing-address', [BillingAddressController::class, 'store']);
    Route::put('/billing-address/{billing_address_id}', [BillingAddressController::class, 'update']);
    Route::delete('/billing-address/{billing_address_id}', [BillingAddressController::class, 'destroy']);

    Route::get('/parts', [PartsController::class, 'index'])->name('parts');
    Route::post('/parts', [PartsController::class, 'store']);
    Route::put('/parts/{part_id}', [PartsController::class, 'update']);
    Route::delete('/parts/{part_id}', [PartsController::class, 'destroy']);

    // *** Routes for Workorders -Start- ***
    Route::get('/workorders', [WorkOrderController::class, 'index'])->name('workorders');
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

});


Route::get('/users', function () {
    return view('Users');
});

Route::get('/archived', function () {
    return view('Archived');
});

Route::get('/reports', function () {
    return view('Reports');
});

Route::get('/customers', function () {
    return view('Customers');
});

