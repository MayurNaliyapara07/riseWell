@extends('layouts.auth')
@section('content')
    <div class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <div class="login-aside order-2 order-lg-1 d-flex flex-row-auto position-relative overflow-hidden">
            <div class="d-flex flex-column-fluid flex-column justify-content-between py-9 px-7 py-lg-13 px-lg-35">
                <a href="#" class="text-center pt-2">
                    <img src="{{ asset('assets/media/logos/logos.png')}}" class="max-h-75px" alt=""/>
                </a>
                <div class="d-flex flex-column-fluid flex-column flex-center">
                    <div class="login-form login-signin py-11 ">
                        <form action="{{ route('register') }}" id="provider_register" method="post"
                              enctype="multipart/form-data" class="form scroll scroll-pull" novalidate="novalidate"
                              data-scroll="true" data-wheel-propagation="true" style="height: 700px">
                            @csrf
                            <div class="text-center pb-8">
                                <h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Sign Up</h2>
                                <p class="text-muted font-weight-bold font-size-h4">Enter your details to create your
                                    account</p>
                            </div>
                            <input type="hidden" placeholder="" name="user_type" value="Provider"/>
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
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('middle_name') is-invalid @enderror"
                                       type="text" placeholder="Middle Name" name="middle_name" autocomplete="off"
                                       value="{{old('middle_name')}}"/>
                                @error('middle_name')
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
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('age') is-invalid @enderror"
                                       type="text" placeholder="Age" name="age" autocomplete="off"
                                       value="{{old('age')}}"/>
                                @error('age')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <select class="form-control form-control-solid state-select2" name="state_of_lic[]"
                                        multiple="multiple">
                                    <option value="">Select State Of Lic</option>
                                </select>
                                @error('state_of_lic')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <textarea
                                        class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6  @error('bio') is-invalid @enderror"
                                        placeholder="Bio" name="bio" autocomplete="off">{{old('bio')}}</textarea>
                                @error('bio')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <textarea
                                        class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('address') is-invalid @enderror"
                                        placeholder="Address" name="address"
                                        autocomplete="off">{{old('address')}}</textarea>
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <select class="form-control form-control-solid state-select2 mt-2" name="state_id">
                                    <option value=""></option>
                                </select>
                                @error('state_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('city_name') is-invalid @enderror"
                                       type="text" placeholder="City" name="city_name" autocomplete="off"
                                       value="{{old('city_name')}}"/>
                                @error('city_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('zip') is-invalid @enderror"
                                       type="text" placeholder="Zip" name="zip" autocomplete="off"
                                       value="{{old('zip')}}"/>
                                @error('zip')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('hours_of_operation') is-invalid @enderror"
                                       type="text" placeholder="Hours of operation" name="hours_of_operation"
                                       autocomplete="off" value="{{old('hours_of_operation')}}"/>
                                @error('hours_of_operation')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <textarea
                                        class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('education') is-invalid @enderror"
                                        placeholder="Education" name="education"
                                        autocomplete="off">{{old('education')}}</textarea>
                                @error('education')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('insurance_document') is-invalid @enderror"
                                       type="file" placeholder="Insurance Photo" name="insurance_document"
                                       autocomplete="off"/>
                                <span class="form-text text-muted">Insurance photo allowed file types:  png, jpg, jpeg. </span>
                                @error('insurance_document')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6  @error('email') is-invalid @enderror"
                                       type="email" placeholder="Email" name="email" autocomplete="off"
                                       value="{{old('email')}}"/>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 @error('phone_no') is-invalid @enderror"
                                       type="text" placeholder="Phone No" name="phone_no" autocomplete="off"
                                       value="{{old('phone_no')}}"/>
                                @error('phone_no')
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
                                <label class="checkbox mb-0">Payment to physician ?
                                    <div class="form-check checkbox-inline">
                                        <label class="checkbox checkbox-outline">
                                            <input type="checkbox" name="payment_to_physician"
                                                   class="@error('payment_to_physician') is-invalid @enderror"/>
                                            <span></span>
                                        </label>
                                    </div>
                                </label>
                                @error('payment_to_physician')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-group d-flex flex-wrap flex-center pb-lg-0 pb-3">
                                <button id="provider_register_submit"
                                        class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">
                                    Submit
                                </button>
                                <a href="{{url('/')}}" type="button"
                                   class="btn btn-danger font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="content order-1 order-lg-2 d-flex flex-column w-100 pb-0" style="background-color: #B1DCED;">
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
@push('styles')
    <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endpush
@push('scripts')
    <script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
    <script src="{{asset('assets/js/pages/crud/forms/widgets/select2.js')}}"></script>
    <script>
        $('.select2-control').select2({
            placeholder: "Select ...",
            allowClear: false
        });
        $(".state-select2").select2({
            ajax: {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ url('state-list')}}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                    };
                }, processResults: function (response) {
                    return {results: response};
                }, cache: true
            }
        });
    </script>
    <script>

        var form = document.getElementById('provider_register');
        var validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    first_name: {
                        validators: {
                            notEmpty: {
                                message: 'The first name field is required.'
                            },
                            // stringLength: {
                            //     min:1,
                            //     max:50,
                            //     message: 'Please enter a menu within text length range 1 and 50'
                            // }
                        }
                    },
                    last_name: {
                        validators: {
                            notEmpty: {
                                message: 'The last name field is required.'
                            },
                        }
                    },
                    middle_name: {
                        validators: {
                            notEmpty: {
                                message: 'The middle name field is required.'
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
                    phone_no: {
                        validators: {
                            notEmpty: {
                                message: 'The phone no field is required.'
                            },
                        }
                    },
                    dob: {
                        validators: {
                            notEmpty: {
                                message: 'The dob field is required.'
                            },
                        }
                    },
                    age: {
                        validators: {
                            notEmpty: {
                                message: 'The age field is required.'
                            },
                            digits: {
                                message: 'The value is not a valid digits'
                            }
                        }
                    },
                    state_of_lic: {
                        validators: {
                            notEmpty: {
                                message: 'The state of lic field is required.'
                            }
                        }
                    },
                    state_id: {
                        validators: {
                            notEmpty: {
                                message: 'The state field is required.'
                            }
                        }
                    },
                    bio: {
                        validators: {
                            notEmpty: {
                                message: 'The bio field is required.'
                            },
                        }
                    },
                    address: {
                        validators: {
                            notEmpty: {
                                message: 'The address field is required.'
                            },
                        }
                    },
                    city_name: {
                        validators: {
                            notEmpty: {
                                message: 'The city field is required.'
                            },
                        }
                    },
                    zip: {
                        validators: {
                            notEmpty: {
                                message: 'The zip field is required.'
                            },
                            digits: {
                                message: 'The value is not a valid digits'
                            }
                        }
                    },
                    hours_of_operation: {
                        validators: {
                            notEmpty: {
                                message: 'The hours of operation field is required.'
                            },
                        }
                    },
                    education: {
                        validators: {
                            notEmpty: {
                                message: 'The education field is required.'
                            },
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
                    insurance_document: {
                        validators: {
                            notEmpty: {
                                message: 'Please select an insurance photo'
                            },
                            file: {
                                extension: 'jpg,jpeg,png',
                                type: 'image/jpeg,image/png',
                                message: 'The selected file is not valid'
                            },
                        }
                    },
                    payment_to_physician: {
                        validators: {
                            choice: {
                                min: 1,
                                message: 'Please payment to physician check this'
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

        var submitButton = document.getElementById('provider_register_submit');
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

