@extends('layouts.auth')
@section('content')
    <div class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <!--begin::Aside-->
        <div class="login-aside order-2 order-lg-1 d-flex flex-row-auto position-relative overflow-hidden">
            <!--begin: Aside Container-->
            <div class="d-flex flex-column-fluid flex-column justify-content-between py-9 px-7 py-lg-13 px-lg-35">
                <!--begin::Logo-->
                <a href="{{url('/')}}" class="text-center pt-2">
                    <img src="{{asset('assets/media/logos/logo-dark.png')}}" class="max-h-75px" alt=""/>
                </a>
                <!--end::Logo-->

                <!--begin::Aside body-->
                <div class="d-flex flex-column-fluid flex-column flex-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="form" id="kt_forget_password" method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <!--begin::Title-->
                        <div class="text-center pb-8">
                            <h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Forgotten Password ?</h2>
                            <p class="text-muted font-weight-bold font-size-h4">Enter your email to reset your
                                password</p>
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('email') is-invalid @enderror"
                                   type="email" placeholder="Email" name="email" autocomplete="off"/>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group d-flex flex-wrap flex-center pb-lg-0 pb-3">
                            <button id="forget_password_submit"
                                    class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">Submit
                            </button>
                            <a href="{{url('login')}}"
                               class="btn btn-danger font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="content order-1 order-lg-2 d-flex flex-column w-100 pb-0" style="background-color: #B1DCED;">
            <!--begin::Title-->
            <div class="d-flex flex-column justify-content-center text-center pt-lg-40 pt-md-5 pt-sm-5 px-lg-0 pt-5 px-7">
                <h3 class="display4 font-weight-bolder my-7 text-dark" style="color: #986923;">Amazing Wireframes</h3>
                <p class="font-weight-bolder font-size-h2-md font-size-lg text-dark opacity-70">User Experience &amp;
                    Interface Design, Product Strategy
                    <br/>Web Application SaaS Solutions</p>
            </div>
            <div class="content-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center"
                 style="background-image: url({{asset('assets/media/svg/illustrations/login-visual-2.svg')}});"></div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
    <script>
        var form = document.getElementById('kt_forget_password');
        var validator = FormValidation.formValidation(
            form,
            {
                fields: {
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
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap(),
                }
            }
        );
        var submitButton = document.getElementById('forget_password_submit');
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
@endpush
