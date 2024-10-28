@extends('admin.admin_master') @section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ __('Add User Page') }}
                        </h4>
                        <br /><br />

                        <form
                            method="post"
                            action="{{ route('user.store') }}"
                            id="myForm"
                            enctype="multipart/form-data"
                        >
                            @csrf

                            <div class="row mb-3">
                                <label
                                    for="example-text-input"
                                    class="col-sm-2 col-form-label"
                                    >{{ __('Name') }}</label
                                >
                                <div class="form-group col-sm-10">
                                    <input
                                        name="name"
                                        class="form-control"
                                        type="text"
                                    />
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label
                                    for="example-text-input"
                                    class="col-sm-2 col-form-label"
                                    >{{ __('Username') }}
                                </label>
                                <div class="form-group col-sm-10">
                                    <input
                                        name="username"
                                        class="form-control"
                                        type="text"
                                    />
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label
                                    for="example-text-input"
                                    class="col-sm-2 col-form-label"
                                    >{{ __('User Email') }}
                                </label>
                                <div class="form-group col-sm-10">
                                    <input
                                        name="email"
                                        class="form-control"
                                        type="email"
                                    />
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label for="role" class="col-sm-2 col-form-label">{{ __('User Role') }}</label>
                                <div class="form-group col-sm-10">
                                    <select name="role" id="role" class="form-control form-select" 
                                    >
                                        <option value="user">{{ __('User') }}</option>
                                        <option value="admin">{{ __('Admin') }}</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- end row -->

                            <div class="row mb-3">
                              <label
                                  for="example-text-input"
                                  class="col-sm-2 col-form-label"
                                  >{{ __('Password') }}
                              </label>
                              <div class="form-group col-sm-10">
                                  <input
                                      name="password"
                                      class="form-control"
                                      type="text"
                                  />
                              </div>
                          </div>
                          <!-- end row -->

                            

                           

                            <input
                                type="submit"
                                class="btn btn-info waves-effect waves-light"
                                value="{{ __('Add User') }}"
                            />
                        </form>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#myForm").validate({
            rules: {
                name: {
                    required: true,
                },
                username: {
                    required: true,
                },
                email: {
                    required: true,
                },
                role: {
                    required: true,
                },
                password: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "{{ __('Please Enter Name') }}",
                },
                username: {
                    required: "{{ __('Please Enter Username') }}",
                },
                email: {
                    required: "{{ __('Please Enter User Email') }}",
                },
                role: {
                    required: "{{ __('Please Enter User Role') }}",
                },
                password: {
                    required: "{{ __('Please Enter Password') }}",
                },
            },
            errorElement: "span",
            errorPlacement: function (error, element) {
                error.addClass("invalid-feedback");
                element.closest(".form-group").append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass("is-invalid");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass("is-invalid");
            },
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#image").change(function (e) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#showImage").attr("src", e.target.result);
            };
            reader.readAsDataURL(e.target.files["0"]);
        });
    });
</script>

@endsection
