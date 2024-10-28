<?php

namespace App\Http\Controllers\Pos;

use App\Models\Payment;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\PaymentDetail;
use Illuminate\Support\Carbon;
// use Image; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;


// use Imagine\Image\Box;
// use Imagine\Gd\Imagine;
// use Imagine\Imagick\Imagine;

class CustomerController extends Controller
{
    public function CustomerAll()
    {

        $customers = Customer::latest()->get();
        return view('backend.customer.customer_all', compact('customers'));
    } // End Method


    public function CustomerAdd()
    {
        return view('backend.customer.customer_add');
    }    // End Method


    public function CustomerStore(Request $request)
    {

        $image = $request->file('customer_image');
        if ($image) {
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(200, 200)->save('upload/customer/' . $name_gen);
            $save_url = 'upload/customer/' . $name_gen;
        } else {
            $save_url = 'upload/no_image.jpg';
        }


        Customer::insert([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'address' => $request->address,
            'customer_image' => $save_url,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Customer Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('customer.all')->with($notification);
    } // End Method


    public function CustomerEdit($id)
    {

        $customer = Customer::findOrFail($id);
        return view('backend.customer.customer_edit', compact('customer'));
    } // End Method


    public function CustomerUpdate(Request $request)
    {

        $customer_id = $request->id;
        if ($request->file('customer_image')) {

            $image = $request->file('customer_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); // 343434.png
            Image::make($image)->resize(200, 200)->save('upload/customer/' . $name_gen);
            $save_url = 'upload/customer/' . $name_gen;

            Customer::findOrFail($customer_id)->update([
                'name' => $request->name,
                'mobile_no' => $request->mobile_no,
                'email' => $request->email,
                'address' => $request->address,
                'customer_image' => $save_url,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),

            ]);

            $notification = array(
                'message' => 'Customer Updated with Image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('customer.all')->with($notification);
        } else {

            Customer::findOrFail($customer_id)->update([
                'name' => $request->name,
                'mobile_no' => $request->mobile_no,
                'email' => $request->email,
                'address' => $request->address,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),

            ]);

            $notification = array(
                'message' => 'Customer Updated without Image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('customer.all')->with($notification);
        } // end else 

    } // End Method


    public function CustomerDelete($id)
    {

        $customers = Customer::findOrFail($id);
        $img = $customers->customer_image;

        if ($img) {
            unlink($img);
        }


        Customer::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Customer Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method


    public function CreditCustomer()
    {

        $allData = Payment::whereIn('paid_status', ['full_due', 'partial_paid'])->get();
        return view('backend.customer.customer_credit', compact('allData'));
    } // End Method


    public function CreditCustomerPrintPdf()
    {

        $allData = Payment::whereIn('paid_status', ['full_due', 'partial_paid'])->get();
        return view('backend.pdf.customer_credit_pdf', compact('allData'));
    } // End Method



    public function CustomerEditInvoice($invoice_id)
    {

        $payment = Payment::where('invoice_id', $invoice_id)->first();
        return view('backend.customer.edit_customer_invoice', compact('payment'));
    } // End Method


    public function CustomerUpdateInvoice(Request $request, $invoice_id)
    {

        if ($request->new_paid_amount < $request->paid_amount) {

            $notification = array(
                'message' => 'Sorry You Paid Maximum Value',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } else {
            $payment = Payment::where('invoice_id', $invoice_id)->first();
            $payment_details = new PaymentDetail();
            $payment->paid_status = $request->paid_status;

            if ($request->paid_status == 'full_paid') {
                $payment->paid_amount = Payment::where('invoice_id', $invoice_id)->first()['paid_amount'] + $request->new_paid_amount;
                $payment->due_amount = '0';
                $payment_details->current_paid_amount = $request->new_paid_amount;
            } elseif ($request->paid_status == 'partial_paid') {
                $payment->paid_amount = Payment::where('invoice_id', $invoice_id)->first()['paid_amount'] + $request->paid_amount;
                $payment->due_amount = Payment::where('invoice_id', $invoice_id)->first()['due_amount'] - $request->paid_amount;
                $payment_details->current_paid_amount = $request->paid_amount;
            }

            $payment->save();
            $payment_details->invoice_id = $invoice_id;
            $payment_details->date = date('Y-m-d', strtotime($request->date));
            $payment_details->updated_by = Auth::user()->id;
            $payment_details->save();

            $notification = array(
                'message' => 'Invoice Update Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('credit.customer')->with($notification);
        }
    } // End Method



    public function CustomerInvoiceDetails($invoice_id)
    {

        $payment = Payment::where('invoice_id', $invoice_id)->first();
        return view('backend.pdf.invoice_details_pdf', compact('payment'));
    } // End Method

    public function PaidCustomer()
    {
        $allData = Payment::where('paid_status', '!=', 'full_due')->get();
        return view('backend.customer.customer_paid', compact('allData'));
    } // End Method

    public function PaidCustomerPrintPdf()
    {

        $allData = Payment::where('paid_status', '!=', 'full_due')->get();
        return view('backend.pdf.customer_paid_pdf', compact('allData'));
    } // End Method


    public function CustomerWiseReport()
    {

        $customers = Customer::all();
        return view('backend.customer.customer_wise_report', compact('customers'));
    } // End Method


    public function CustomerWiseCreditReport(Request $request)
    {
        $customers = Customer::find($request->customer_id);
        $allData = Payment::where('customer_id', $request->customer_id)->whereIn('paid_status', ['full_due', 'partial_paid'])->get();
        return view('backend.pdf.customer_wise_credit_pdf', compact('allData', 'customers'));
    } // End Method


    public function CustomerWisePaidReport(Request $request)
    {

        $allData = Payment::where('customer_id', $request->customer_id)->where('paid_status', '!=', 'full_due')->get();
        return view('backend.pdf.customer_wise_paid_pdf', compact('allData'));
    } // End Method

    // new method

    public function customerWisePaidReportCsv(Request $request)
    {
        $allData = Payment::with(['customer', 'invoice'])
            ->where('due_amount', '=', 0)
            ->get();

        $csvData = [
            ['Sl', 'Customer Name', 'Invoice No', 'Date', 'Due Amount'],
        ];

        $total_due = 0;
        foreach ($allData as $key => $item) {
            $csvData[] = [
                $key + 1,
                $item['customer']['name'],
                '#' . $item['invoice']['invoice_no'],
                date('d-m-Y', strtotime($item['invoice']['date'])),
                $item->due_amount,
            ];
            $total_due += $item->due_amount;
        }

        $csvData[] = [
            '', '', '', 'Grand Due Amount', $total_due
        ];

        $filename = "customer_wise_paid_report_" . date('YmdHis') . ".csv";
        $handle = fopen($filename, 'w+');

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

    // End method

    public function customerPaidReportCsv(Request $request)
    {
        $allData = Payment::with(['customer', 'invoice'])
            ->where('due_amount', '!=', 0)
            ->get();

        $csvData = [
            ['Sl', 'Customer Name', 'Invoice No', 'Date', 'Due Amount'],
        ];

        $total_due = 0;
        foreach ($allData as $key => $item) {
            $csvData[] = [
                $key + 1,
                $item['customer']['name'],
                '#' . $item['invoice']['invoice_no'],
                date('d-m-Y', strtotime($item['invoice']['date'])),
                $item->due_amount,
            ];
            $total_due += $item->due_amount;
        }

        $csvData[] = [
            '', '', '', 'Grand Due Amount', $total_due
        ];

        $filename = "customer_paid_report_" . date('YmdHis') . ".csv";
        $handle = fopen($filename, 'w+');

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

    //End Method

    public function customerCreditReportCsv(Request $request)
    {
        $allData = Payment::where('due_amount', '>', 0)
            ->with('customer')
            ->get();

        $csvData = [
            ['Sl', 'Customer Name', 'Invoice No', 'Date', 'Due Amount'],
        ];

        $total_due = 0;
        foreach ($allData as $key => $item) {
            $csvData[] = [
                $key + 1,
                $item->customer->name,
                '#' . $item->invoice_no,
                date('d-m-Y', strtotime($item->date)),
                $item->due_amount,
            ];
            $total_due += $item->due_amount;
        }

        $csvData[] = [
            '', '', '', 'Grand Due Amount', $total_due
        ];

        $filename = "customer_credit_report_" . date('YmdHis') . ".csv";
        $handle = fopen($filename, 'w+');

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
   
}
