@extends('admin.admin_master') @section('admin')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div
                    class="page-title-box d-sm-flex align-items-center justify-content-between"
                >
                    <h4 class="mb-sm-0">{{ __('Purchase All') }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a
                            href="{{ route('purchase.add') }}"
                            class="btn btn-dark btn-rounded waves-effect waves-light"
                            style="float: right"
                            ><i class="fas fa-plus-circle">
                                {{ __('Add Purchase') }}
                            </i></a
                        >
                        <br />
                        <br />

                        <h4 class="card-title">{{ __('Purchase All Pending Data') }}</h4>

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
                                <th>{{ __('Purhase No') }}</th>
                                <th>{{ __('Product Name') }}</th>
                                <th>{{ __('Supplier') }}</th>
                                <th>{{ __('Category') }}</th>
                                <th>{{ __('Qty') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created by') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>

                            <tbody>
                                @foreach($allData as $key => $item)
                                <tr>
                                    <td>{{ $key+1}}</td>
                                    <td>{{ $item->purchase_no }}</td>
                                    
                                    <td>{{ $item['product']['name'] }}</td>
                                    <td>{{ $item['supplier']['name'] }}</td>
                                    <td>{{ $item['category']['name'] }}</td>
                                    <td>{{ $item->buying_qty }}</td>
                                    <td>
                                        {{ date('d-m-Y',strtotime($item->date))
                                        }}
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
                                    <td>{{ $item->user->name }}</td>

                                    <td>
                                        @if($item->status == '0')
                                        <a
                                            href="{{ route('purchase.approve',$item->id) }} "
                                            class="btn btn-danger sm"
                                            title="{{ __('Approve') }}"
                                            id="ApproveBtn"
                                        >
                                            <i class="fas fa-check-circle"></i>
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
