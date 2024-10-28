<div class="vertical-menu flex" >
    <div data-simplebar class="h-100">
        <!-- User details -->

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title fs-6">{{ __('Menu') }}</li>

                <li>
                    <a
                        href="{{ url('/dashboard') }}"
                        class="waves-effect"
                    >
                        <i class="ri-home-fill"></i>
                        <span>{{ __('Dashboard') }}</span>
                    </a>
                </li>

                <li>
                    <a
                        href="javascript: void(0);"
                        class="has-arrow waves-effect"
                    >
                        <i class="ri-hotel-fill"></i>
                        <span >{{ __('Manage Suppliers') }}</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('supplier.all') }}"
                                >{{ __('All Suppliers') }}</a
                            >
                        </li>
                    </ul>
                </li>

                <li>
                    <a
                        href="javascript: void(0);"
                        class="has-arrow waves-effect"
                    >
                        <i class="ri-shield-user-fill"></i>
                        <span>{{ __('Manage Customers') }}</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('customer.all') }}"
                                >{{ __('All Customers') }}</a
                            >
                        </li>
                        <li>
                            <a href="{{ route('credit.customer') }}"
                                >{{ __('Credit Customers') }}</a
                            >
                        </li>

                        <li>
                            <a href="{{ route('paid.customer') }}"
                                >{{ __('Paid Customers') }}</a
                            >
                        </li>
                        <li>
                            <a href="{{ route('customer.wise.report') }}"
                                >{{ __('Customer Wise Report') }}</a
                            >
                        </li>
                        
                    </ul>
                </li>

                <li>
                    <a
                        href="javascript: void(0);"
                        class="has-arrow waves-effect"
                    >
                        <i class="ri-delete-back-fill"></i>
                        <span>{{ __('Manage Units') }}</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('unit.all') }}">{{ __('All Units') }}</a></li>
                    </ul>
                </li>

                <li>
                    <a
                        href="javascript: void(0);"
                        class="has-arrow waves-effect"
                    >
                        <i class="ri-apps-2-fill"></i>
                        <span>{{ __('Manage Categories') }}</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('category.all') }}"
                                >{{ __('All Categories') }}</a
                            >
                        </li>
                    </ul>
                </li>

                <li>
                    <a
                        href="javascript: void(0);"
                        class="has-arrow waves-effect"
                    >
                        <i class="ri-reddit-fill"></i>
                        <span>{{ __('Manage Products') }}</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('product.all') }}">{{ __('All Products') }}</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a
                        href="javascript: void(0);"
                        class="has-arrow waves-effect"
                    >
                        <i class="ri-oil-fill"></i>
                        <span>{{ __('Manage Purchases') }}</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('purchase.all') }}"
                                >{{ __('All Purchases') }}</a
                            >
                        </li>
                        <li>
                            <a href="{{ route('purchase.pending') }}"
                                >{{ __('Approval Purchase') }}</a
                            >
                        </li>
                        <li>
                            <a href="{{ route('daily.purchase.report') }}"
                                >{{ __('Daily Purchase Report') }}</a
                            >
                        </li>
                    </ul>
                </li>

                <li>
                    <a
                        href="javascript: void(0);"
                        class="has-arrow waves-effect"
                    >
                        <i class="ri-compass-2-fill"></i>
                        <span>{{ __('Manage Invoice') }}</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('invoice.all') }}">{{ __('All Invoice') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('invoice.pending.list') }}"
                                >{{ __('Approval Invoice') }}</a
                            >
                        </li>
                        <li>
                            <a href="{{ route('print.invoice.list') }}"
                                >{{ __('Print Invoice List') }}</a
                            >
                        </li>
                        <li>
                            <a href="{{ route('daily.invoice.report') }}"
                                >{{ __('Daily Invoice Report') }}</a
                            >
                        </li>
                    </ul>
                </li>

                <li class="menu-title fs-6">{{ __('Stock') }}</li>

                <li>
                    <a
                        href="javascript: void(0);"
                        class="has-arrow waves-effect"
                    >
                        <i class="ri-gift-fill"></i>
                        <span>{{ __('Manage Stock') }}</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('stock.report') }}"
                                >{{ __('Stock Report') }}</a
                            >
                        </li>
                        <li>
                            <a href="{{ route('stock.supplier.wise') }}"
                                >{{ __('Supplier / Product Wise') }}
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Admin role --}}

                @auth
                @if(Auth::user()->role == 'admin')
                <li class="menu-title fs-6">{{ __('Users') }}</li>
                <li>
                    <a
                        href="javascript: void(0);"
                        class="has-arrow waves-effect"
                    >
                        <i class="ri-gift-fill"></i>
                        <span>{{ __('Manage Users') }}</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('user.all') }}"
                                >{{ __('All Users') }}</a
                            >
                        </li>
                    </ul>
                    
                </li>
                @endif
                @endauth

                {{-- <li>
                    <a
                        href="javascript: void(0);"
                        class="has-arrow waves-effect"
                    >
                        <i class="ri-profile-line"></i>
                        <span>Support</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="pages-starter.html">Starter Page</a></li>
                        <li><a href="pages-timeline.html">Timeline</a></li>
                        <li><a href="pages-directory.html">Directory</a></li>
                        <li><a href="pages-invoice.html">Invoice</a></li>
                        <li><a href="pages-404.html">Error 404</a></li>
                        <li><a href="pages-500.html">Error 500</a></li>
                    </ul>
                </li> --}}
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
