@inject('baseHelper','App\Helpers\Frontend\Helper')
@extends('layouts.frontend')
@section('content')
    <section>
        <?php
        $getGender = $baseHelper->getGender();
        $getWeekday = $baseHelper->getWeekday();
        $getWeekends = $baseHelper->getWeekend();
        $selectedWeekday = !empty($patient->weekday) ? explode(',', $patient->weekday) : '';
        $selectedWeekend = !empty($patient->weekend) ? explode(',', $patient->weekend) : '';
        ?>
        <div class="form-area-section">
            <div class="container">
                <div class="step-list">
                    <ul class="step">
                        <li class="active">
                            <div class="circle"></div>
                            Step 1<span>Basic Questions</span></li>
                        <li>
                            <div class="circle"></div>
                            Step 2<span>Medical History</span></li>
                        <li>
                            <div class="circle"></div>
                            Step 3<span>Sexual Health</span></li>
                        <li>
                            <div class="circle"></div>
                            Step 4<span>Checkout</span></li>
                    </ul>
                </div>
                <div class="right-form-area">
                    <h1>Basic Questions</h1>
                    <form action="{{route('save-ed-step-one')}}" method="post" enctype="multipart/form-data"
                          class="ajax-form">
                        @csrf
                        <div class="form-block">
                            <p>You are about to begin the Male Excel Online Medical Consult. It is a <b>HIPAAM</b>
                                compliant
                                system; your data is secure and will not be sold to any third parties. Please fill out
                                the
                                following medical consult as honestly and accurately as possible. Your medical provider
                                will
                                use the information to determine your best course of treatment.<b> Please have the names
                                    of
                                    your current medications ready.</b></p>
                            <div class="gap-40">
                                <div class="row">

                                    <input type="hidden" name="member_id" value="{{!empty($memberId)?$memberId:''}}">
                                    <input type="hidden" name="product_id" value="{{!empty($productId)?$productId:''}}">
                                    <input type="hidden" name="survey_form_type" value="{{!empty($productType)?$productType:''}}">


                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="">What's your legal first name ?</label>
                                            <input type="text" autocomplete="off" id="first_name"
                                                   onkeyup="setLocalStorage()"
                                                   class="form-control required"
                                                   data-msg-required="First Name is required"
                                                   placeholder="Please enter your first name" name="first_name"
                                                   @php if(!empty($patient->first_name)) echo 'readonly' @endphp
                                                   value="{{!empty($patient)?$patient->first_name:old('first_name')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="">What's your legal last name ?</label>
                                            <input type="text" class="form-control required" onkeyup="setLocalStorage()"
                                                   data-msg-required="Last Name is required"
                                                   @php if(!empty($patient->last_name)) echo 'readonly' @endphp
                                                   placeholder="Please enter your last name" name="last_name"
                                                   id="last_name"
                                                   value="{{!empty($patient)?$patient->last_name:old('last_name')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="">Email Address</label>
                                            <input type="text" class="form-control required"
                                                   data-rule-email="true"
                                                   data-msg-required="Email Address is required"
                                                   placeholder="Please enter your email"
                                                   name="email"
                                                   @php if(!empty($patient->email)) echo 'readonly' @endphp
                                                   value="{{!empty($patient)?$patient->email:old('email')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="">Phone Number</label>
                                            <input type="text" class="form-control required"
                                                   data-msg-required="Phone No is required"
                                                   placeholder="Please enter your phone number"
                                                   name="phone_no"
                                                   @php if(!empty($patient->phone_no)) echo 'readonly' @endphp
                                                   value="{{!empty($patient)?$patient->phone_no:old('phone_no')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="gap-60">
                                <h3>What time of day is best to call if a doctor has any questions regarding your
                                    medical
                                    intake form?
                                </h3>
                                <div class="checkbox-area">
                                    <h4>Weekdays</h4>
                                    <ul class="flex-check">
                                        @if($getWeekday)
                                            @foreach($getWeekday as $key=>$weekday)
                                                <li>
                                                    <input class="css-checkbox required" value="{{$weekday['value']}}"
                                                           type="checkbox" name="weekday[]"
                                                           data-msg-required="Weekday is required"
                                                           {{  !empty($selectedWeekday) && in_array($weekday['value'],$selectedWeekday) ?  'checked':'' }}
                                                           id="checkboxWeekday{{$key}}" >
                                                    <label for="checkboxWeekday{{$key}}" class="css-label">{{$weekday['label']}} </label>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                <div class="checkbox-area">
                                    <h4>Weekends</h4>
                                    <ul class="flex-check">
                                        @if($getWeekends)
                                            @foreach($getWeekends as $key=>$weekend)
                                                <li>
                                                    <input type="checkbox" name="weekend[]"
                                                           data-msg-required="Weekend is required"
                                                           value="{{$weekend['value']}}"
                                                           {{  !empty($selectedWeekend) && in_array($weekend['value'],$selectedWeekend) ?  'checked':'' }}
                                                           id="checkboxWeekend{{$key}}" class="css-checkbox required">
                                                    <label for="checkboxWeekend{{$key}}"
                                                           class="css-label">{{$weekend['label']}}</label>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>What is your biological sex?</h4>
                                    <ul class="flex-check">
                                        @if($getGender)
                                            @foreach($getGender as $key=>$gender)
                                                <li>
                                                    <input type="radio" name="gender" id="{{$key}}"
                                                           data-msg-required="Biological sex is required"
                                                           value="{{$gender['value']}}"
                                                           {{ !empty($patient->gender) && $patient->gender == $gender['value'] ? 'checked' : ''}} class="css-radio required">
                                                    <label for="{{$key}}"
                                                           class="css-label">{{$gender['label']}} </label>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    <div class="row md-30">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="">Height</label>
                                                <input type="text" class="form-control required" placeholder="Height"
                                                       name="height"
                                                       data-msg-required="Height is required"
                                                       value="{{!empty($patient) ? $patient->height : old('height')}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="">Weight</label>
                                                <input type="text" class="form-control required"
                                                       data-msg-required="Weight is required"
                                                       placeholder="Weight" name="weight"
                                                       value="{{!empty($patient) ? $patient->weight : old('weight')}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="">DOB</label>
                                                <input type="date" class="form-control required" placeholder=""
                                                       name="dob"
                                                       data-msg-required="DOB is required"
                                                       @php if(!empty($patient->dob)) echo 'readonly' @endphp
                                                       value="{{!empty($patient) ? $patient->dob : old('dob')}}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="gap-60">
                                <div class="checkbox-area">
                                    <ul class="full-flex-check">
                                        <li>
                                            <input type="checkbox" name="policy" id="policy"
                                                   data-msg-required="Privacy Policy is required"
                                                   class="css-checkbox required" {{ !empty($patient) && $patient->policy == 1 ? 'checked' : ''}}>
                                            <label for="policy" class="css-label terms">Click here to consent to <a
                                                    href="#">Privacy Policy</a> and <a href="#">Terms.</a></label>
                                        </li>
{{--                                        <li>--}}
{{--                                            <input type="checkbox" name="terms" id="terms"--}}
{{--                                                   data-msg-required="Terms is required"--}}
{{--                                                   class="css-checkbox required" {{ !empty($patient) && $patient->terms == 1 ? 'checked' : ''}}>--}}
{{--                                            <label for="terms" class="css-label terms">I agree to <a href="#"> receive via SMS news and special offers. </a> </label>--}}
{{--                                        </li>--}}
                                    </ul>

                                </div>
                            </div>
                            <button type="submit" class="btn-continue">Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>

        function setLocalStorage() {
            var firstName = $('#first_name').val();
            var LastName = $('#last_name').val();
            localStorage.setItem("firstName", firstName);
            localStorage.setItem("lastName", LastName);
        }
    </script>
@endpush
