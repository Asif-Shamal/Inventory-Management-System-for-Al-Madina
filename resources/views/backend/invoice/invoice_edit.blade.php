@extends('admin.admin_master')

@section('admin')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('Edit Invoice') }}</h4>
                        <br /><br />

                        <form method="post" action="{{ route('invoice.update', $invoice->id) }}">
                            @csrf
                            <table class="table-sm table-bordered" width="100%" style="border-color: #ddd">
                                <thead>
                                    <tr>
                                        <th>{{ __('Category') }}</th>
                                        <th>{{ __('Product Name') }}</th>
                                        <th width="7%">{{ __('PSC/KG') }}</th>
                                        <th width="10%">{{ __('Unit Price') }}</th>
                                        <th width="15%">{{ __('Total Price') }}</th>
                                        <th width="7%">{{ __('Action') }}</th>
                                    </tr>
                                </thead>

                                <tbody id="addRow" class="addRow">
                                    @foreach($invoice_details as $detail)
                                    <tr>
                                        <input type="hidden" name="date" value="{{ $invoice->date }}" />
                                        <input type="hidden" name="invoice_no" value="{{ $invoice->invoice_no }}" />

                                        <td>
                                            <input type="hidden" name="category_id[]" value="{{ $detail->category_id }}" />
                                            {{ $detail->category->name }}
                                        </td>

                                        <td>
                                            <input type="hidden" name="product_id[]" value="{{ $detail->product_id }}" />
                                            {{ $detail->product->name }}
                                        </td>

                                        <td>
                                            <input type="number" min="1" class="form-control selling_qty text-right" name="selling_qty[]" value="{{ $detail->selling_qty }}" />
                                        </td>

                                        <td>
                                            <input type="number" class="form-control unit_price text-right" name="unit_price[]" value="{{ $detail->unit_price }}" />
                                        </td>

                                        <td>
                                            <input type="number" class="form-control selling_price text-right" name="selling_price[]" value="{{ $detail->selling_price }}" readonly />
                                        </td>

                                        <td>
                                            <i class="btn btn-danger btn-sm fas fa-window-close removeeventmore"></i>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                                <tbody>
                                    <tr>
                                        <td colspan="4">{{ __('Discount') }}</td>
                                        <td>
                                            <input type="text" name="discount_amount" id="discount_amount" class="form-control estimated_amount" placeholder="{{ __('Discount Amount') }}" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="4">{{ __('Grand Total') }}</td>
                                        <td>
                                            <input type="text" name="estimated_amount" value="{{ $payment->total_amount }}" id="estimated_amount" class="form-control estimated_amount" readonly style="background-color: #ddd" />
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <br />

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <textarea name="description" class="form-control" id="description" placeholder="{{ __('Write Description Here') }}">{{ $invoice->description }}</textarea>
                                </div>
                            </div>
                            <br />

                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>{{ __('Paid Status') }}</label>
                                    <select name="paid_status" id="paid_status" class="form-select">
                                        <option value="full_paid" {{ $payment->paid_status == 'full_paid' ? 'selected' : '' }}>{{ __('Full Paid') }}</option>
                                        <option value="full_due" {{ $payment->paid_status == 'full_due' ? 'selected' : '' }}>{{ __('Full Due') }}</option>
                                        <option value="partial_paid" {{ $payment->paid_status == 'partial_paid' ? 'selected' : '' }}>{{ __('Partial Paid') }}</option>
                                    </select>
                                    <input type="text" name="paid_amount" class="form-control paid_amount" placeholder="{{ __('Enter Paid Amount') }}" style="display: {{ $payment->paid_status == 'partial_paid' ? 'block' : 'none' }};" value="{{ $payment->paid_amount }}" />
                                </div>

                                <div class="form-group col-md-9">
                                    <label>{{ __('Customer Name') }}</label>
                                    <select name="customer_id" id="customer_id" class="form-select">
                                        <option value="">{{ __('Select Customer') }}</option>
                                        @foreach($customers as $cust)
                                        <option value="{{ $cust->id }}" {{ $invoice->customer_id == $cust->id ? 'selected' : '' }}>{{ $cust->name }} - {{ $cust->mobile_no }}</option>
                                        @endforeach
                                        <option value="0">{{ __('New Customer') }}</option>
                                    </select>
                                </div>
                            </div>
                            <!-- // end row -->
                            <br />

                            <!-- Hide Add Customer Form -->
                            <div class="row new_customer" style="display: none;">
                                <div class="form-group col-md-4">
                                    <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Write Customer Name') }}" />
                                </div>

                                <div class="form-group col-md-4">
                                    <input type="text" name="mobile_no" id="mobile_no" class="form-control" placeholder="{{ __('Write Customer Mobile No') }}" />
                                </div>

                                <div class="form-group col-md-4">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('Write Customer Email') }}" />
                                </div>
                            </div>
                            <!-- End Hide Add Customer Form -->

                            <br />
                            <div class="form-group">
                                <button type="submit" class="btn btn-info" id="updateButton">{{ __('Update Invoice') }}</button>
                            </div>
                        </form>
                    </div>
                    <!-- End card-body -->
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- container-fluid -->
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(document).on("click", ".removeeventmore", function (event) {
            $(this).closest(".delete_add_more_item").remove();
            totalAmountPrice();
        });

        $(document).on("keyup click", ".unit_price,.selling_qty", function () {
            var unit_price = $(this).closest("tr").find("input.unit_price").val();
            var qty = $(this).closest("tr").find("input.selling_qty").val();
            var total = unit_price * qty;
            $(this).closest("tr").find("input.selling_price").val(total);
            $("#discount_amount").trigger("keyup");
        });

        $(document).on("keyup", "#discount_amount", function () {
            totalAmountPrice();
        });

        // Calculate sum of amount in invoice
        function totalAmountPrice() {
            var sum = 0;
            $(".selling_price").each(function () {
                var value = $(this).val();
                if (!isNaN(value) && value.length != 0) {
                    sum += parseFloat(value);
                }
            });

            var discount_amount = parseFloat($("#discount_amount").val());
            if (!isNaN(discount_amount) && discount_amount.length != 0) {
                sum -= parseFloat(discount_amount);
            }

            $("#estimated_amount").val(sum);
        }

        // Show/hide elements based on paid status
        $(document).on("change", "#paid_status", function () {
            var paid_status = $(this).val();
            if (paid_status == "partial_paid") {
                $(".paid_amount").show();
            } else {
                $(".paid_amount").hide();
            }
        });

        // Show/hide add new customer form
        $(document).on("change", "#customer_id", function () {
            var customer_id = $(this).val();
            if (customer_id == "0") {
                $(".new_customer").show();
            } else {
                $(".new_customer").hide();
            }
        });

        // Trigger initial calculations if there's any existing data
        totalAmountPrice();
    });
</script>

@endsection
