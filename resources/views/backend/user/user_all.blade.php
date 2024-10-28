@extends('admin.admin_master') @section('admin')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div
                    class="page-title-box d-sm-flex align-items-center justify-content-between"
                >
                    <h4 class="mb-sm-0">{{ __('User All') }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a
                            href="{{ route('user.add') }}"
                            class="btn btn-dark btn-rounded waves-effect waves-light"
                            style="float: right"
                            ><i class="fas fa-plus-circle">
                                {{ __('Add User') }}
                            </i></a
                        >
                        <br />
                        <br />

                        <h4 class="card-title">
                            {{ __('User All Data') }}
                        </h4>

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
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Username') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Role') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($users as $key => $item)
                                <tr>
                                    <td>{{ $key+1}}</td>
                                    <td>{{ $item->name }}</td>
                                    
                                    <td>{{ $item->username }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->role }}</td>
                                    <td>
                                        <a
                                            href="{{ route('user.edit',$item->id) }}"
                                            class="btn btn-info sm"
                                            title="{{ __('Edit Data') }}"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a
                                            href="{{ route('user.delete',$item->id) }}"
                                            class="btn btn-danger sm"
                                            title="{{ __('Delete Data') }}"
                                            id="delete"
                                        >
                                            <i class="fas fa-trash-alt"></i>
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
