@extends('admin.admin_master')
@section('admin')

<div class="page-content">
<div class="container-fluid">


<div class="row">
    <div class="col-lg-6">
        <div class="card"><br><br>
<center>
            <img class="rounded-circle avatar-xl" src="{{ (!empty($adminData->profile_image))? url('upload/admin_images/'.$adminData->profile_image):url('upload/no_image.jpg') }}" alt="Card image cap">
</center>

            <div class="card-body">
                <h4 class="card-title">{{ __('Name') }} : {{ $adminData->name }} </h4>
                <hr>
                <h4 class="card-title">{{ __('User Email') }} : {{ $adminData->email }} </h4>
                <hr>
                <h4 class="card-title">{{ __('Username') }} : {{ $adminData->username }} </h4>
                <hr>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('edit.profile') }}" class="btn btn-info btn-rounded waves-effect waves-light" > {{ __('Edit Profile') }}</a>
                    
                    <a href="{{ route('delete.profile') }}" class="btn btn-danger btn-rounded waves-effect waves-light" id="delete"  > {{ __('Delete Profile') }}</a>
                </div>
            </div>
        </div>
    </div> 
                            
        
                        </div> 


</div>
</div>

@endsection 
