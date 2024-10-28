@extends('admin.admin_master') @section('admin')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div
                    class="page-title-box d-sm-flex align-items-center justify-content-between"
                >
                    <h4 class="mb-sm-0">{{ __('Invoice All') }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a
                            href="{{ route('invoice.add') }}"
                            class="btn btn-dark btn-rounded waves-effect waves-light"
                            style="float: right"
                            ><i class="fas fa-plus-circle"> {{ __('Add Invoice') }} </i></a
                        >
                        <br />
                        <br />

                        <h4 class="card-title">{{ __('Invoice All Data') }}</h4>

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
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Created by') }}</th>
                                    <th>{{ __('Action') }}</th>
                                    <th>{{ __('Status') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($allData as $key => $item)
                                <tr>
                                    <td>{{ $key+1}}</td>
                                    <td>
                                        {{ $item['payment']['customer']['name']
                                        }}
                                    </td>
                                    <td>#{{ $item->invoice_no }}</td>
                                    <td>
                                        {{ date('d-m-Y',strtotime($item->date))
                                        }}
                                    </td>

                                    <td>{{ $item->description }}</td>

                                    <td>
                                        $ {{ $item['payment']['total_amount'] }}
                                    </td>
                                    <td>
                                         {{ $item->user->name}}
                                    </td>

                                    <td>
                                        @if($item->status == '0')
                                        <span class="btn btn-warning"
                                            >{{ __('Pending') }}</span
                                        >
                                        @elseif($item->status == '1')
                                        <span class="btn btn-success"
                                            >{{ __('Approved') }}</span
                                        >
                                        @endif
                                    </td>

                                    <td>
                                        @if($item->status == '0')
                                        <a
                                            href="{{ route('invoice.approve',$item->id) }}"
                                            class="btn btn-dark sm"
                                            title="{{ __('Approve Data') }}"
                                        >
                                            <i class="fas fa-check-circle"></i>
                                        </a>

                                        <a
                                            href="{{ route('invoice.delete',$item->id) }}"
                                            class="btn btn-danger sm"
                                            title="{{ __('Delete Data') }}"
                                            id="delete"
                                        >
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @endif
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
