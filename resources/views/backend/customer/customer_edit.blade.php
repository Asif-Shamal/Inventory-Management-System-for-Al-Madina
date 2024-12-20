@extends('admin.admin_master') @section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ __('Edit Customer Page') }}
                        </h4>
                        <br /><br />

                        <form
                            method="post"
                            action="{{ route('customer.update') }}"
                            id="myForm"
                            enctype="multipart/form-data"
                        >
                            @csrf

                            <input
                                type="hidden"
                                name="id"
                                value="{{ $customer->id }}"
                            />
                            <div class="row mb-3">
                                <label
                                    for="example-text-input"
                                    class="col-sm-2 col-form-label"
                                    >{{ __('Customer Name') }}
                                </label>
                                <div class="form-group col-sm-10">
                                    <input
                                        name="name"
                                        value="{{ $customer->name }}"
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
                                    >{{ __('Customer Mobile') }}
                                </label>
                                <div class="form-group col-sm-10">
                                    <input
                                        name="mobile_no"
                                        value="{{ $customer->mobile_no }}"
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
                                    >{{ __('Customer Email') }}
                                </label>
                                <div class="form-group col-sm-10">
                                    <input
                                        name="email"
                                        value="{{ $customer->email }}"
                                        class="form-control"
                                        type="email"
                                    />
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label
                                    for="example-text-input"
                                    class="col-sm-2 col-form-label"
                                    >{{ __('Customer Address') }}
                                </label>
                                <div class="form-group col-sm-10">
                                    <input
                                        name="address"
                                        value="{{ $customer->address }}"
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
                                    >{{ __('Customer Image') }}
                                </label>
                                <div class="form-group col-sm-10">
                                    <input
                                        name="customer_image"
                                        class="form-control"
                                        type="file"
                                        id="image"
                                    />
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label
                                    for="example-text-input"
                                    class="col-sm-2 col-form-label"
                                >
                                </label>
                                <div class="col-sm-10">
                                    <img
                                        id="showImage"
                                        class="rounded avatar-lg"
                                        src="{{ asset($customer->customer_image) }}"
                                        alt="Card image cap"
                                    />
                                </div>
                            </div>
                            <!-- end row -->

                            <input
                                type="submit"
                                class="btn btn-info waves-effect waves-light"
                                value="{{ __('Update Customer') }}"
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
                mobile_no: {
                    required: true,
                },
                email: {
                    required: true,
                },
                address: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "{{ __('Please Enter Customer Name') }}",
                },
                mobile_no: {
                    required: "{{ __('Please Enter Customer Mobile Number') }}",
                },
                email: {
                    required: "{{ __('Please Enter Customer Email') }}",
                },
                address: {
                    required: "{{ __('Please Enter Customer Address') }}",
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
