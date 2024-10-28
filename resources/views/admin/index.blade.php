@extends('admin.admin_master')
@section('admin')


<div class="page-content">
<div class="container-fluid">

<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
    <h4 class="mb-sm-0">{{ __('Dashboard') }}</h4>

</div>
</div>
</div>
<!-- end page title -->


<div class="row">
    <!-- Card 1: Total Sales Revenue -->
    <div class="col-xl-4 col-md-6">
      <div class="card">
          <div class="card-body">
              <div class="d-flex">
                  <div class="flex-grow-1">
                      <p class="text-truncate font-size-14 mb-2">{{ __('Total Sales Revenue') }}</p>
                      <h4 class="mb-2">${{ number_format($totalSalesRevenue, 2) }}</h4>
                  </div>
                  <div class="avatar-sm">
                      <span class="avatar-title bg-light text-primary rounded-3">
                          <i class="ri-money-dollar-circle-line font-size-24"></i>
                      </span>
                  </div>
              </div>
          </div><!-- end cardbody -->
      </div><!-- end card -->
  </div><!-- end col -->


      <!-- Card 2: Number of Products -->
      <div class="col-xl-4 col-md-6">
          <div class="card">
              <div class="card-body">
                  <div class="d-flex">
                      <div class="flex-grow-1">
                          <p class="text-truncate font-size-14 mb-2">{{ __('Number of Products') }}</p>
                          <h4 class="mb-2">{{ $numberOfProducts }}</h4> <!-- Dynamic data -->
                      </div>
                      <div class="avatar-sm">
                          <span class="avatar-title bg-light text-success rounded-3">
                              <i class="ri-shopping-bag-line font-size-24"></i> <!-- Icon representing products -->
                          </span>
                      </div>
                  </div>
              </div><!-- end cardbody -->
          </div><!-- end card -->
      </div><!-- end col -->

<!-- Card 3: Total Units Sold -->
<div class="col-xl-4 col-md-6">
<div class="card">
  <div class="card-body">
      <div class="d-flex">
          <div class="flex-grow-1">
              <p class="text-truncate font-size-14 mb-2">{{ __('Total Units Sold') }}</p>
              <h4 class="mb-2">{{ $totalUnitsSold }}</h4>
          </div>
          <div class="avatar-sm">
              <span class="avatar-title bg-light text-success rounded-3">
                  <i class="ri-shopping-cart-line font-size-24"></i>
              </span>
          </div>
      </div>
  </div><!-- end cardbody -->
</div><!-- end card -->
</div><!-- end col -->

  <div class="row">
      <div class="col-xl-12">
          <div class="card">
              <div class="card-body">
                  <div class="dropdown float-end">
                      <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="mdi mdi-dots-vertical"></i>
                      </a>
                  </div>

                  <h4 class="card-title mb-4">{{ __('Top Sellers') }}</h4>

                  <div class="table-responsive">
                      <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                          <thead class="table-light">
                              <tr>
                                  <th>{{ __('Serial Number') }}</th>
                                  <th>{{ __('Product Name') }}</th>
                                  <th>{{ __('Quantity Sold') }}</th>
                                  <th>{{ __('Remaining Stock') }}</th>
                              </tr>
                          </thead><!-- end thead -->
                          <tbody>
                              @foreach($topSellers as $seller)
                              @php
                              $product = $seller->product;
                              $remainingStock = $product->quantity; // Assuming 'quantity' represents remaining stock in Product model
                              @endphp
                              <tr>
                                  <td>{{ $product->id }}</td>
                                  <td><h6 class="mb-0">{{ $product->name }}</h6></td>
                                  <td>{{ $seller->total_quantity }}</td>
                                  <td>{{ $remainingStock }}</td>
                              </tr>
                              @endforeach
                          </tbody><!-- end tbody -->
                      </table> <!-- end table -->
                  </div>
              </div><!-- end card -->
          </div><!-- end card -->
      </div><!-- end col -->
  </div><!-- end row -->

  <div class="row">
      @include('components.line-bar')
      @include('components.doughnut-chart')
  </div>
    </div>
</div>

@endsection