<?php

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\InvoiceDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Pos\UnitController;
use App\Http\Controllers\Demo\DemoController;
use App\Http\Controllers\Pos\StockController;
use App\Http\Controllers\Pos\DefaultController;
use App\Http\Controllers\Pos\InvoiceController;
use App\Http\Controllers\Pos\ProductController;
use App\Http\Controllers\Pos\CategoryController;
use App\Http\Controllers\Pos\CustomerController;
use App\Http\Controllers\Pos\PurchaseController;
use App\Http\Controllers\Pos\SupplierController;



Route::get('/', function () {
    return redirect()->route('login');
});


Route::controller(DemoController::class)->group(function () {
    Route::get('/about', 'Index')->name('about.page')->middleware('check');
    Route::get('/contact', 'ContactMethod')->name('cotact.page');
});


Route::middleware('auth')->group(function () {



    // Admin All Route 
    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin/logout', 'destroy')->name('admin.logout');
        Route::get('/admin/profile', 'Profile')->name('admin.profile');
        Route::get('/edit/profile', 'EditProfile')->name('edit.profile');
        Route::post('/store/profile', 'StoreProfile')->name('store.profile');
        Route::get('/delete/prfoile', 'DeleteProfile')->name('delete.profile');

        Route::get('/change/password', 'ChangePassword')->name('change.password');
        Route::post('/update/password', 'UpdatePassword')->name('update.password');
    });


    // Supplier All Route 
    Route::controller(SupplierController::class)->group(function () {


        Route::get('/supplier/all', 'SupplierAll')->name('supplier.all');
        Route::get('/supplier/add', 'SupplierAdd')->name('supplier.add');
        Route::post('/supplier/store', 'SupplierStore')->name('supplier.store');
        Route::get('/supplier/edit/{id}', 'SupplierEdit')->name('supplier.edit');
        Route::post('/supplier/update', 'SupplierUpdate')->name('supplier.update');
        Route::get('/supplier/delete/{id}', 'SupplierDelete')->name('supplier.delete');


        // supplier wise report
        Route::get('/admin/supplier-stock-report/download', 'supplierWiseReportCsv')->name('supplier.stock.report.download');
    });


    // Customer All Route 
    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customer/all', 'CustomerAll')->name('customer.all');
        Route::get('/customer/add', 'CustomerAdd')->name('customer.add');
        Route::post('/customer/store', 'CustomerStore')->name('customer.store');
        Route::get('/customer/edit/{id}', 'CustomerEdit')->name('customer.edit');
        Route::post('/customer/update', 'CustomerUpdate')->name('customer.update');
        Route::get('/customer/delete/{id}', 'CustomerDelete')->name('customer.delete');

        Route::get('/credit/customer', 'CreditCustomer')->name('credit.customer');
        Route::get('/credit/customer/print/pdf', 'CreditCustomerPrintPdf')->name('credit.customer.print.pdf');

        Route::get('/customer/edit/invoice/{invoice_id}', 'CustomerEditInvoice')->name('customer.edit.invoice');
        Route::post('/customer/update/invoice/{invoice_id}', 'CustomerUpdateInvoice')->name('customer.update.invoice');

        Route::get('/customer/invoice/details/{invoice_id}', 'CustomerInvoiceDetails')->name('customer.invoice.details.pdf');

        Route::get('/paid/customer', 'PaidCustomer')->name('paid.customer');
        Route::get('/paid/customer/print/pdf', 'PaidCustomerPrintPdf')->name('paid.customer.print.pdf');

        Route::get('/customer/wise/report', 'CustomerWiseReport')->name('customer.wise.report');
        Route::get('/customer/wise/credit/report', 'CustomerWiseCreditReport')->name('customer.wise.credit.report');
        Route::get('/customer/wise/paid/report', 'CustomerWisePaidReport')->name('customer.wise.paid.report');


        Route::get('/download-report/{type}', 'downloadReport')->name('report.download');


        // customer wise paid report
        Route::get('/admin/customer-wise-paid-report/download', 'customerWisePaidReportCsv')->name('customer-wise-paid-report.download');

        // customer paid report
        Route::get('/admin/customer-paid-report/download', 'customerPaidReportCsv')->name('customer-paid-report.download');

        // customer credit report
        Route::get('/admin/customer-credit-report/download', 'customerCreditReportCsv')->name('customer-credit-report.download');
    });


    // Unit All Route 
    Route::controller(UnitController::class)->group(function () {
        Route::get('/unit/all', 'UnitAll')->name('unit.all');
        Route::get('/unit/add', 'UnitAdd')->name('unit.add');
        Route::post('/unit/store', 'UnitStore')->name('unit.store');
        Route::get('/unit/edit/{id}', 'UnitEdit')->name('unit.edit');
        Route::post('/unit/update', 'UnitUpdate')->name('unit.update');
        Route::get('/unit/delete/{id}', 'UnitDelete')->name('unit.delete');
    });


    // Category All Route 
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category/all', 'CategoryAll')->name('category.all');
        Route::get('/category/add', 'CategoryAdd')->name('category.add');
        Route::post('/category/store', 'CategoryStore')->name('category.store');
        Route::get('/category/edit/{id}', 'CategoryEdit')->name('category.edit');
        Route::post('/category/update', 'CategoryUpdate')->name('category.update');
        Route::get('/category/delete/{id}', 'CategoryDelete')->name('category.delete');
    });


    // Product All Route 
    Route::controller(ProductController::class)->group(function () {
        Route::get('/product/all', 'ProductAll')->name('product.all');
        Route::get('/product/add', 'ProductAdd')->name('product.add');
        Route::post('/product/store', 'ProductStore')->name('product.store');
        Route::get('/product/edit/{id}', 'ProductEdit')->name('product.edit');
        Route::post('/product/update', 'ProductUpdate')->name('product.update');
        Route::get('/product/delete/{id}', 'ProductDelete')->name('product.delete');

        //Product wise stock report
        Route::get('/admin/product-stock-report/download', 'productWiseReportCsv')->name('product.stock.report.download');
    });



    // Purchase All Route 
    Route::controller(PurchaseController::class)->group(function () {
        Route::get('/purchase/all', 'PurchaseAll')->name('purchase.all');
        Route::get('/purchase/add', 'PurchaseAdd')->name('purchase.add');
        Route::post('/purchase/store', 'PurchaseStore')->name('purchase.store');
        Route::get('/purchase/delete/{id}', 'PurchaseDelete')->name('purchase.delete');
        Route::get('/purchase/pending', 'PurchasePending')->name('purchase.pending');
        Route::get('/purchase/approve/{id}', 'PurchaseApprove')->name('purchase.approve');

        Route::get('/daily/purchase/report', 'DailyPurchaseReport')->name('daily.purchase.report');
        Route::get('/daily/purchase/pdf', 'DailyPurchasePdf')->name('daily.purchase.pdf');

        //Daily purchase report
        Route::get('/admin/daily-purchase-report/download', 'dailyPurchaseReportCsv')->name('daily-purchase-report.download');
    });


    // Invoice All Route 
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('/invoice/all', 'InvoiceAll')->name('invoice.all');
        Route::get('/invoice/add', 'invoiceAdd')->name('invoice.add');
        Route::post('/invoice/store', 'InvoiceStore')->name('invoice.store');

        Route::get('/invoice/pending/list', 'PendingList')->name('invoice.pending.list');
        Route::get('/invoice/delete/{id}', 'InvoiceDelete')->name('invoice.delete');
        Route::get('/invoice/approve/{id}', 'InvoiceApprove')->name('invoice.approve');

        Route::post('/approval/store/{id}', 'ApprovalStore')->name('approval.store');
        Route::get('/print/invoice/list', 'PrintInvoiceList')->name('print.invoice.list');
        Route::get('/print/invoice/{id}', 'PrintInvoice')->name('print.invoice');

        Route::get('/daily/invoice/report', 'DailyInvoiceReport')->name('daily.invoice.report');
        Route::get('/daily/invoice/pdf', 'DailyInvoicePdf')->name('daily.invoice.pdf');


        // invoice report
        Route::get('/admin/invoice/{id}/download', 'invoiceReportCsv')->name('invoice.download');

        // daily invoice report
        Route::get('/admin/daily-invoice-report/download',  'dailyInvoiceReportCsv')->name('daily-invoice-report.download');
    });





    // Stock All Route 
    Route::controller(StockController::class)->group(function () {
        Route::get('/stock/report', 'StockReport')->name('stock.report');
        Route::get('/stock/report/pdf', 'StockReportPdf')->name('stock.report.pdf');

        Route::get('/stock/supplier/wise', 'StockSupplierWise')->name('stock.supplier.wise');
        Route::get('/supplier/wise/pdf', 'SupplierWisePdf')->name('supplier.wise.pdf');
        Route::get('/product/wise/pdf', 'ProductWisePdf')->name('product.wise.pdf');

        // Stock report
        Route::get('/admin/stock-report/download', 'stockReportCsv')->name('stock.report.download');
    });
}); // End Group Middleware




// Default All Route 
Route::controller(DefaultController::class)->group(function () {
    Route::get('/get-category', 'GetCategory')->name('get-category');
    Route::get('/get-product', 'GetProduct')->name('get-product');
    Route::get('/check-product', 'GetStock')->name('check-product-stock');
});





Route::get('/dashboard', function () {
    // Number of products
    $numberOfProducts = Product::count();

    // Total inventory value
    $totalSalesRevenue = DB::table('payments')
        ->join('invoice_details', 'payments.invoice_id', '=', 'invoice_details.invoice_id')
        ->where('invoice_details.status', 1) // Filter by status = 1 in invoice_details
        ->sum('payments.paid_amount');

    // $totalSalesRevenue = DB::table('payments') // Approved invoices
    //     ->sum('paid_amount');
    // Top sellers
    $topSellers = InvoiceDetail::selectRaw('product_id, SUM(selling_qty) as total_quantity')
        ->where('status', 1) // Only consider approved invoices
        ->groupBy('product_id')
        ->orderBy('total_quantity', 'desc')
        ->take(5) // Assuming you want top 5 sellers
        ->with('product')
        ->get();

    $totalUnitsSold = DB::table('invoice_details')->where('status', 1)->sum('selling_qty');

    // line chart
    $monthlySales = DB::table('invoice_details')
        ->select(
            DB::raw('SUM(selling_price) as total_sales'),
            DB::raw('DATE_FORMAT(date, "%Y-%m") as month')
        )
        ->where('status', 1) // Add this line to filter by status
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

    // doughnut chart
    $categorySales = DB::table('invoice_details')
        ->join('categories', 'invoice_details.category_id', '=', 'categories.id')
        ->select(
            'categories.name as category_name',
            DB::raw('SUM(invoice_details.selling_price) as total_sales')
        )
        ->where('invoice_details.status', 1)
        ->groupBy('categories.name')
        ->orderBy('total_sales', 'desc')
        ->get();

    return view('admin.index', compact('numberOfProducts', 'totalSalesRevenue', 'topSellers', 'totalUnitsSold', 'monthlySales', 'categorySales'));
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';


// Route::get('/contact', function () {
//     return view('contact');
// });


// Change language route
Route::get('lang/{lang}', [LanguageController::class, 'switchLang'])->name('lang.switch');


// admin role
Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/manage-users', [RoleController::class, 'index'])->name('manage.users');
});


// User all routes
Route::controller(RoleController::class)->group(function () {
    Route::get('/user/all', 'UserAll')->name('user.all');
    Route::get('/user/add', 'UserAdd')->name('user.add');
    Route::get('/user/edit/{id}', 'UserEdit')->name('user.edit');
    Route::post('/user/update', 'UserUpdate')->name('user.update');
    Route::get('/user/delete/{id}', 'UserDelete')->name('user.delete');
    Route::post('/user/store', 'UserStore')->name('user.store');
});
