<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Category;
use Auth;
use Illuminate\Support\Carbon;

class PurchaseController extends Controller
{
    public function PurchaseAll(){

        $allData = Purchase::with('user')->orderBy('date','desc')->orderBy('id','desc')->get();
        return view('backend.purchase.purchase_all',compact('allData'));

    } // End Method



    public function PurchaseAdd(){

        $supplier = Supplier::all();
        $unit = Unit::all();
        $category = Category::all();
        return view('backend.purchase.purchase_add',compact('supplier','unit','category'));

    } // End Method 


    public function PurchaseStore(Request $request){

    if ($request->category_id == null) {

       $notification = array(
        'message' => 'Sorry you do not select any item', 
        'alert-type' => 'error'
    );
    return redirect()->back( )->with($notification);
    } else {

        $count_category = count($request->category_id);
        for ($i=0; $i < $count_category; $i++) { 
            $purchase = new Purchase();
            $purchase->date = date('Y-m-d', strtotime($request->date[$i]));
            $purchase->purchase_no = $request->purchase_no[$i];
            $purchase->supplier_id = $request->supplier_id[$i];
            $purchase->category_id = $request->category_id[$i];

            $purchase->product_id = $request->product_id[$i];
            $purchase->buying_qty = $request->buying_qty[$i];
            $purchase->unit_price = $request->unit_price[$i];
            $purchase->buying_price = $request->buying_price[$i];
            $purchase->description = $request->description[$i];

            $purchase->created_by = Auth::user()->id;
            $purchase->status = '0';
            $purchase->save();
        } // end foreach
    } // end else 

    $notification = array(
        'message' => 'Data Save Successfully', 
        'alert-type' => 'success'
    );
    return redirect()->route('purchase.all')->with($notification); 
    } // End Method 


    public function PurchaseDelete($id){

        Purchase::findOrFail($id)->delete();

         $notification = array(
        'message' => 'Purchase Iteam Deleted Successfully', 
        'alert-type' => 'success'
    );
    return redirect()->back()->with($notification); 

    } // End Method 


    public function PurchasePending(){

        $allData = Purchase::orderBy('date','desc')->orderBy('id','desc')->where('status','0')->get();
        return view('backend.purchase.purchase_pending',compact('allData'));
    }// End Method 


    public function PurchaseApprove($id){

        $purchase = Purchase::findOrFail($id);
        $product = Product::where('id',$purchase->product_id)->first();
        $purchase_qty = ((float)($purchase->buying_qty))+((float)($product->quantity));
        $product->quantity = $purchase_qty;

        if($product->save()){

            Purchase::findOrFail($id)->update([
                'status' => '1',
            ]);

             $notification = array(
        'message' => 'Status Approved Successfully', 
        'alert-type' => 'success'
          );
    return redirect()->route('purchase.all')->with($notification); 

        }

    }// End Method 


    public function DailyPurchaseReport(){
        return view('backend.purchase.daily_purchase_report');
    }// End Method 


    public function DailyPurchasePdf(Request $request){

        $sdate = date('Y-m-d',strtotime($request->start_date));
        $edate = date('Y-m-d',strtotime($request->end_date));
        $allData = Purchase::whereBetween('date',[$sdate,$edate])->where('status','1')->get();


        $start_date = date('Y-m-d',strtotime($request->start_date));
        $end_date = date('Y-m-d',strtotime($request->end_date));
        return view('backend.pdf.daily_purchase_report_pdf',compact('allData','start_date','end_date'));

    }// End Method 


    public function dailyPurchaseReportCsv(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $allData = Purchase::with(['product', 'user'])
            ->whereBetween('date', [$start_date, $end_date])
            ->get();

        $csvData = [
            ['Sl', 'Purchase No', 'Date', 'Product Name', 'Quantity', 'Unit Price', 'Total Price', 'Created by'],
        ];

        $total_sum = 0;
        foreach ($allData as $key => $item) {
            $csvData[] = [
                $key + 1,
                $item->purchase_no,
                date('d-m-Y', strtotime($item->date)),
                $item['product']['name'],
                $item->buying_qty . ' ' . $item['product']['unit']['name'],
                $item->unit_price,
                $item->buying_price,
                $item->user->name,
            ];
            $total_sum += $item->buying_price;
        }

        $csvData[] = [
            '', '', '', '', '', '', 'Grand Amount', $total_sum
        ];

        $filename = "daily_purchase_report_" . date('YmdHis') . ".csv";
        $handle = fopen($filename, 'w+');

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

    //End Method


}
  