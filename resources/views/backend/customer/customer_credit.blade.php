@extends('admin.admin_master') @section('admin')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div
                    class="page-title-box d-sm-flex align-items-center justify-content-between"
                >
                    <h4 class="mb-sm-0">{{ __('Credit Customer All') }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a
                            href="{{ route('credit.customer.print.pdf') }}"
                            target="_blank"
                            class="btn btn-dark btn-rounded waves-effect waves-light"
                            style="float: right"
                            ><i class="fa fa-print">
                                {{ __('Print Credit Customer') }}
                            </i></a
                        >
                        <br />
                        <br />

                        <h4 class="card-title">{{ __('Credit Customer Data') }}</h4>

                        <table
                            id="datatable"
                            class="table table-bordered dt-responsive nowrap"
                            style="
                                border-collapse: collapse;
                                border-spacing: 0;
                                width: 100%;
                            "
                        >
                            <thead>
                                <tr>
                                    <th>{{ __('Sl') }}</th>
                                    <th>{{ __('Customer Name') }}</th>
                                    <th>{{ __('Invoice No') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Due Amount') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($allData as $key => $item)
                                <tr>
                                    <td>{{ $key+1}}</td>
                                    <td>{{ $item['customer']['name'] }}</td>
                                    <td>
                                        #{{ $item['invoice']['invoice_no'] }}
                                    </td>
                                    <td>
                                        {{
                                        date('d-m-Y',strtotime($item['invoice']['date']))
                                        }}
                                    </td>
                                    <td>{{ $item->due_amount }}</td>
                                    <td>
                                        <a
                                            href="{{ route('customer.edit.invoice',$item->invoice_id) }}"
                                            class="btn btn-info sm"
                                            title="{{ __('Edit Data') }}"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a
                                            href="{{ route('customer.invoice.details.pdf',$item->invoice_id) }}"
                                            target="_blank"
                                            class="btn btn-danger sm"
                                            title="{{ __('Customer Invoice Details') }}"
                                        >
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- container-fluid -->
</div>

@endsection
