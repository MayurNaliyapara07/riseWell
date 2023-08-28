@inject('baseHelper','App\Helpers\User\Helper')
@extends('layouts.auth')
@section('content')
    <?php
    $siteDarkLogo = $baseHelper->siteDarkLogo();
    ?>
    <!--begin::Login-->
    <div class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <!--begin::Aside-->
        <div class="login-aside order-2 order-lg-1 d-flex flex-row-auto position-relative overflow-hidden">
            <!--begin: Aside Container-->
            <div class="d-flex flex-column-fluid flex-column justify-content-between py-9 px-7 py-lg-13 px-lg-35">
                <!--begin::Logo-->
                <a href="#" class="text-center pt-2">
                    <img src="{{$siteDarkLogo}}" class="max-h-75px" alt=""/>
                </a>
                <!--end::Logo-->
                <!--begin::Aside body-->
                <div class="d-flex flex-column-fluid flex-column flex-center">
                    <!--begin::Signin-->
                    <div class="login-form login-signin py-11">
                        <!--begin::Form-->

                        <form action="{{ route('register') }}" method="post" novalidate="novalidate"
                              class="form scroll scroll-pull" data-scroll="true" data-wheel-propagation="true"
                              style="height:700px" id="kt_register">
                            @csrf
                            <div class="text-center pb-8">
                                <h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Sign Up</h2>
                                <p class="text-muted font-weight-bold font-size-h4">Enter your details to create your
                                    account</p>
                            </div>
                            <div class="form-group">
                                <select id="user_type"
                                        class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('user_type') is-invalid @enderror"
                                        name="user_type" autocomplete="off" >
                                    <option value="" >Select Your Role</option>
                                    <option value="Provider" {{old('user_type')=='Provider' ? 'selected' : ' '}}>Provider</option>
                                    <option value="Admin" {{old('user_type')=='Admin' ? 'selected' : ' '}}>Admin</option>
                                </select>
                                @error('user_type')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('first_name') is-invalid @enderror"
                                       type="text" placeholder="First Name" name="first_name" autocomplete="off"
                                       value="{{old('first_name')}}"/>
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('last_name') is-invalid @enderror"
                                       type="text" placeholder="Last Name" name="last_name" autocomplete="off"
                                       value="{{old('last_name')}}"/>
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('email') is-invalid @enderror"
                                       type="email" placeholder="Email" name="email" autocomplete="off"
                                       value="{{old('email')}}"/>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group admin">
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('dob') is-invalid @enderror"
                                       id="kt_datepicker_1"
                                       type="text" placeholder="Dob" name="dob" autocomplete="off"
                                       value="{{old('dob')}}"/>
                                @error('dob')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group admin">
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('ssn') is-invalid @enderror"
                                       type="text" placeholder="SSN Last 4 digits" name="ssn" autocomplete="off"
                                       value="{{old('ssn')}}" maxlength="4" minlength="4"/>
                                @error('ssn')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('password') is-invalid @enderror"
                                       type="password" placeholder="Password" name="password" autocomplete="off"/>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('confirmed') is-invalid @enderror"
                                       type="password" placeholder="Confirm password" name="confirmed"
                                       autocomplete="off"/>
                                @error('confirmed')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <p><b>Privacy Restrictions :</b> You are only allowed to use this portal to access
                                    information related to your job with DocDay. All DocDay providers are required to
                                    follow HIPAA and all applicable federal <br> and state regulations. <br><br>By
                                    clicking sign up you agree to the privacy restriction terms and conditions. </p>
                            </div>
                            <div class="form-group d-flex flex-wrap flex-center pb-lg-0 pb-3">
                                <button id="register_submit"
                                        class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">
                                    Submit
                                </button>
                                <a type="button" href="{{url('/')}}"
                                   class="btn btn-danger font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">Cancel</a>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
            <!--end: Aside Container-->
        </div>
        <!--begin::Aside-->
        <!--begin::Content-->
        <div class="content order-1 order-lg-2 d-flex flex-column w-100 pb-0" style="background-color: #B1DCED;">
            <!--begin::Title-->
            <div class="d-flex flex-column justify-content-center text-center pt-lg-40 pt-md-5 pt-sm-5 px-lg-0 pt-5 px-7">
                <h3 class="display4 font-weight-bolder my-7 text-dark" style="color: #986923;">Amazing Wireframes</h3>
                <p class="font-weight-bolder font-size-h2-md font-size-lg text-dark opacity-70">User Experience &amp;
                    Interface Design, Product Strategy
                    <br/>Web Application SaaS Solutions</p>
            </div>
            <!--end::Title-->
            <!--begin::Image-->
            <div class="content-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center"
                 style="background-image: url({{asset('assets/media/svg/illustrations/login-visual-2.svg')}});"></div>
            <!--end::Image-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Login-->
@endsection
@push('scripts')
    <script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
    <script>
        var form = document.getElementById('kt_register');
        var validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    user_type: {
                        validators: {
                            notEmpty: {
                                message: 'The role field is required.'
                            },
                        }
                    },
                    first_name: {
                        validators: {
                            notEmpty: {
                                message: 'The first name field is required.'
                            },
                        }
                    },
                    last_name: {
                        validators: {
                            notEmpty: {
                                message: 'The last name field is required.'
                            },
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'The email field is required.'
                            },
                            emailAddress: {
                                message: 'The email address is not a valid'
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'The password field is required.'
                            },
                        }
                    },
                    confirmed: {
                        validators: {
                            notEmpty: {
                                message: 'The confirmation password field is required.'
                            },
                            identical: {
                                compare: function () {
                                    return form.querySelector('[name="password"]').value;
                                },
                                message: 'The password and its confirm are not the same'
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap(),
                }
            });
        var submitButton = document.getElementById('register_submit');
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();
            if (validator) {
                validator.validate().then(function (status) {
                    if (status == 'Valid') {
                        submitButton.setAttribute('data-kt-indicator', 'on');
                        submitButton.disabled = true;
                        setTimeout(function () {
                            submitButton.removeAttribute('data-kt-indicator');
                            submitButton.disabled = false;
                            form.submit();
                        }, 1000);
                    }
                });
            }
        });
    </script>
    <script>
        $('#user_type').change(function () {
            if ($(this).val() == 'Admin') {
                $('.admin').hide();

            } else {
                $('.admin').show();
            }
        })
    </script>
    <script></script>
@endpush
