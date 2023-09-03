@extends('layouts.frontend')
@section('content')
    <?php
        $patientsObj = new \App\Models\Patients();
        $billingStateId = !empty($patient->billing_state_id)?$patient->billing_state_id:"";
        $shippingStateId = !empty($patient->shipping_state_id)?$patient->shipping_state_id:"";
        $getBillingState =$patientsObj->getStateName($billingStateId);
        $getShippingState =$patientsObj->getStateName($shippingStateId);
        $billingStateName = !empty($getBillingState)?$getBillingState->state_name:"";
        $shippingStateName = !empty($getShippingState)?$getShippingState->state_name:"";
    ?>
    <!--get-started-->
    <section>
        <div class="trt-section">
            <div class="container">
                <ul class="nav trt-tab" id="myTab" role="tablist">
                    <li><a class="nav-link " id="step1-tab" data-toggle="tab" href="#step1" role="tab" aria-controls="step1" aria-selected="true"><div class="circle">1</div>Personal Information</a></li>
                    <li><a class="nav-link" id="step2-tab" data-toggle="tab" href="#step2" role="tab" aria-controls="step2" aria-selected="false"><div class="circle">2</div>Symptom Status</a></li>
                    <li><a class="nav-link" id="step3-tab" data-toggle="tab" href="#step3" role="tab" aria-controls="step3" aria-selected="false"><div class="circle">3</div>Lifestyle & Treatment</a></li>
                    <li><a class="nav-link" id="step4-tab" data-toggle="tab" href="#step4" role="tab" aria-controls="step4" aria-selected="false"><div class="circle">4</div>Symptom Assessment</a></li>
                    <li><a class="nav-link active" id="step5-tab" data-toggle="tab" href="#step5" role="tab" aria-controls="step5" aria-selected="false"><div class="circle">5</div>Shipping & Billing </a></li>
                    <li><a class="nav-link" id="step6-tab" data-toggle="tab" href="#step6" role="tab" aria-controls="step6" aria-selected="false"><div class="circle">6</div>Follow Up</a></li>

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="step4" role="tabpanel" aria-labelledby="step4-tab">
                        <div class="main-align-top">
                            <div class="detail-area">
                                <h1>Shipping & Billing</h1>
                                <p>Payment processed in the United States. Card information secured by SSL 128 bit encyption.</p>
                                <form action="{{route('save-trt-step-five-refill')}}" method="post" enctype="multipart/form-data"
                                      class="ajax-form">
                                    @csrf
                                <div class="logo-area">
                                    <div class="icon"><img src="{{asset('assets/frontend/images/usa.jpeg')}}" alt=""></div>
                                    <div class="icon"><img src="{{asset('assets/frontend/images/ssl-logo.jpeg')}}" alt=""></div>
                                </div>
                                <div class="radio-area">
                                    <h4>Use the same shipping & billing address as the previous order?</h4>
                                    <ul class="flex-radio">
                                        <li>
                                            <input type="radio" name="same_shipping_as_billing" value="Yes" {{ !empty($patient->same_shipping_as_billing) && $patient->same_shipping_as_billing == 1 ? 'checked' : ''}}  id="addressyes" class="css-radio">
                                            <label for="addressyes" class="css-label">Yes</label>
                                        </li>
                                        <li>
                                            <input type="radio" name="same_shipping_as_billing" value="No" {{ !empty($patient->same_shipping_as_billing) && $patient->same_shipping_as_billing == 0 ? 'checked' : ''}} id="addressnoe" class="css-radio">
                                            <label for="addressnoe" class="css-label">No</label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="radio-area">
                                    <h4>Use the same credit card on file?</h4>
                                    <ul class="flex-radio">
                                        <li>
                                            <input type="radio" name="same_as_credit_card" id="cardyes" {{ !empty($patient->same_as_credit_card) && $patient->same_as_credit_card == 1 ? 'checked' : ''}} value="Yes" class="css-radio">
                                            <label for="cardyes" class="css-label">Yes</label>
                                        </li>
                                        <li>
                                            <input type="radio" name="same_as_credit_card" id="cardno"  {{ !empty($patient->same_as_credit_card) && $patient->same_as_credit_card == 0 ? 'checked' : ''}} value="No" class="css-radio">
                                            <label for="cardno" class="css-label">No</label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="shipping-check">
                                    <input type="checkbox" name="acknowledge" value="Yes"  {{ !empty($patient->acknowledge) && $patient->acknowledge == 1 ? 'checked' : ''}} id="medical" class="css-checkbox">
                                    <label for="medical" class="css-label">I acknowledge that Med Excel Clinic P.A.'s medical providers exercise independent professional judgment in the treatment and medical care of patients. I further acknowledge that if my provider does not find that I am a candidate for hormone replacement therapy they will not prescribe me medication.</label>
                                </div>
                                <div class="btn-area">
                                    <a href="{{route('trt-step2')}}" class="btn-back">Back</a>
                                    <button type="submit" class="btn-continue">Continue</button>
                                </div>
                                </form>

                            </div>
                            <div class="payment-info">
                                <h3>Your information currently on file</h3>
                                <div class="pd-15">
                                    <p><strong>Billing Address</strong>{{!empty($patient)?$patient->billing_address_1.",".$patient->billing_city_name.",".$billingStateName.",".$patient->billing_zip:''}}</p>
                                    <p><strong>Shipping Address</strong>{{!empty($patient)?$patient->shipping_address_1.",".$patient->shipping_city_name.",".$shippingStateName.",".$patient->shipping_zip:''}}8</p>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
