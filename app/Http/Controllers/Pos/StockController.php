<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\InvoiceDetail;
use App\Models\Unit;
use Auth;
use Illuminate\Support\Carbon;
 
class StockController extends Controller
{
    public function StockReport(){

        $allData = Product::orderBy('supplier_id','asc')->orderBy('category_id','asc')->get();
        return view('backend.stock.stock_report',compact('allData'));

    } // End Method


    public function StockReportPdf(){

        $allData = Product::orderBy('supplier_id','asc')->orderBy('category_id','asc')->get();
        return view('backend.pdf.stock_report_pdf',compact('allData'));

    } // End Method


    public function StockSupplierWise(){

        $supppliers = Supplier::all();
        $category = Category::all();
        return view('backend.stock.supplier_product_wise_report',compact('supppliers','category'));

    } // End Method


    public function SupplierWisePdf(Request $request){

        $allData = Product::orderBy('supplier_id','asc')->orderBy('category_id','asc')->where('supplier_id',$request->supplier_id)->get();
        return view('backend.pdf.supplier_wise_report_pdf',compact('allData'));

    } // End Method


    public function ProductWisePdf(Request $request){

        $product = Product::where('category_id',$request->category_id)->where('id',$request->product_id)->first();
        return view('backend.pdf.product_wise_report_pdf',compact('product'));
    } // End Method



    public function stockReportCsv()
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

        $filename = "stock_report_" . date('YmdHis') . ".csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array_keys($csvData[0]));

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

    // End Method

    
}
 