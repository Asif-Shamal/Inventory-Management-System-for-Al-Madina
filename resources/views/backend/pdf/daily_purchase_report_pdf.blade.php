@extends('admin.admin_master')
@section('admin')

 <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">{{ __('Daily Purchase Report') }}</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);"> </a></li>
                                            <li class="breadcrumb-item active">{{ __('Daily Purchase Report') }}</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
        
    <div class="row">
        <div class="col-12">
            <div class="invoice-title">
                
                <h3>
                    <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="logo" height="24"/> {{ __('Al-Madina') }}
                </h3>
            </div>
            <hr>
             
            <div class="row">
                <div class="col-6 mt-4">
                    <address>
                        <strong>{{ __('Al-Madina') }}:</strong><br>
                        {{ __('Al-Madina Address') }}<br>
                        {{ __('Al-Madina Email') }}
                    </address>
                </div>
                <div class="col-6 mt-4 text-end">
                    <address>
                       
                    </address>
                </div>
            </div>
        </div>
    </div>

      

    <div class="row">
        <div class="col-12">
            <div>
                <div class="p-2">
                    <h3 class="font-size-16"><strong>{{ __('Daily Purchase Report') }} 
    <span class="btn btn-info"> {{ date('d-m-Y',strtotime($start_date)) }} </span> -
     <span class="btn btn-success"> {{ date('d-m-Y',strtotime($end_date)) }} </span>
                    </strong></h3>
                </div>
                
            </div>

        </div>
    </div> <!-- end row -->





   <div class="row">
        <div class="col-12">
            <div>
                <div class="p-2">
                     
                </div>
                <div class="">
<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <td><strong>{{ __('Sl') }} </strong></td>
            <td class="text-center"><strong>{{ __('Purchase No') }} </strong></td>
            <td class="text-center"><strong>{{ __('Date') }}  </strong>
            </td>
            <td class="text-center"><strong>{{ __('Product Name') }}</strong>
            </td>
            <td class="text-center"><strong>{{ __('Quantity') }}</strong>
            </td>
            <td class="text-center"><strong>{{ __('Unit Price') }}  </strong>
            </td>
            <td class="text-center"><strong>{{ __('Total Price') }}  </strong>
            <td class="text-center"><strong>{{ __('Created by') }}  </strong>
            </td>
            
            
        </tr>
        </thead>
        <tbody>
        <!-- foreach ($order->lineItems as $line) or some such thing here -->
        
      @php
        $total_sum = '0';
        @endphp
        @foreach($allData as $key => $item)
        <tr>
           <td class="text-center">{{ $key+1 }}</td>
            <td class="text-center">{{ $item->purchase_no }}</td>
            <td class="text-center">{{ date('d-m-Y',strtotime($item->date)) }}</td>
            <td class="text-center">{{ $item['product']['name'] }}</td>
            <td class="text-center">{{ $item->buying_qty }} {{ $item['product']['unit']['name'] }} </td>
            <td class="text-center">{{ $item->unit_price }}</td>
            <td class="text-center">{{ $item->buying_price }}</td>
            <td class="text-center">{{ $item->user->name }}</td>
            
            
        </tr>
         @php
        $total_sum += $item->buying_price;
        @endphp
        @endforeach
            
           
           
            <tr>
                <td class="no-line"></td>
                <td class="no-line"></td>
                <td class="no-line"></td> 
                <td class="no-line"></td>
                <td class="no-line text-center">
                    <strong>{{ __('Grand Amount') }}</strong></td>
                <td class="no-line text-end"><h4 class="m-0">${{ $total_sum}}</h4></td>
            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-print-none">
                        <div class="float-end">
                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
                            <a href="{{ route('daily-purchase-report.download', ['start_date' => $start_date, 'end_date' => $end_date]) }}" class="btn btn-primary waves-effect waves-light ms-2">{{ __('Download') }}</a>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div> <!-- end row -->

 




</div>
</div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                    </div> <!-- container-fluid -->
                </div>


@endsection