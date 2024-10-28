<?php

namespace App\Http\Controllers\Pos;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\InvoiceDetail;

class SupplierController extends Controller
{
    public function SupplierAll()
    {
        // $suppliers = Supplier::all();
        $suppliers = Supplier::latest()->get();
        return view('backend.supplier.supplier_all', compact('suppliers'));
    } // End Method 


    public function SupplierAdd()
    {
        return view('backend.supplier.supplier_add');
    } // End Method 


    public function SupplierStore(Request $request)
    {

        Supplier::insert([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'address' => $request->address,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Supplier Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('supplier.all')->with($notification);
    } // End Method 


    public function SupplierEdit($id)
    {

        $supplier = Supplier::findOrFail($id);
        return view('backend.supplier.supplier_edit', compact('supplier'));
    } // End Method 

    public function SupplierUpdate(Request $request)
    {

        $sullier_id = $request->id;

        Supplier::findOrFail($sullier_id)->update([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'address' => $request->address,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Supplier Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('supplier.all')->with($notification);
    } // End Method 


    public function SupplierDelete($id)
    {

        Supplier::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Supplier Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method 



    public function supplierWiseReportCsv()
    {
        $allData = Product::with(['supplier', 'unit', 'category'])->get();

        $csvData = [];

        foreach ($allData as $key => $item) {
            $buying_total = Purchase::where('category_id', $item->category_id)
                                    ->where('product_id', $item->id)
                                    ->where('status', '1')
                                    ->sum('buying_qty');
            $selling_total = InvoiceDetail::where('category_id', $item->category_id)
                                          ->where('product_id', $item->id)
                                          ->where('status', '1')
                                          ->sum('selling_qty');

            $csvData[] = [
                'Sl' => $key + 1,
                'Supplier Name' => $item['supplier']['name'],
                'Unit' => $item['unit']['name'],
                'Category' => $item['category']['name'],
                'Product Name' => $item->name,
                'In Qty' => $buying_total,
                'Out Qty' => $selling_total,
                'Stock' => $item->quantity,
            ];
        }

        if (empty($csvData)) {
            return redirect()->back()->with('error', 'No data available to download');
        }

        $filename = "supplier_wise_stock_report_" . date('YmdHis') . ".csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array_keys($csvData[0]));

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
