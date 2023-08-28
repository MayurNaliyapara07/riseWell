@inject('baseHelper','App\Helpers\Frontend\Helper')
@extends('layouts.frontend')
@section('content')
    <?php
    $getExperience = $baseHelper->getExperience();
    ?>
        <!--get-started-->
    <section>
        <div class="trt-section">
            <div class="container">
                <ul class="nav trt-tab" id="myTab" role="tablist">
                    <li><a class="nav-link " id="step1-tab" data-toggle="tab" href="#step1" role="tab"
                           aria-controls="step1" aria-selected="false">
                            <div class="circle">1</div>
                            Personal Information</a></li>
                    <li><a class="nav-link" id="step2-tab" data-toggle="tab" href="#step2" role="tab"
                           aria-controls="step2" aria-selected="false">
                            <div class="circle">2</div>
                            Symptom Status</a></li>
                    <li><a class="nav-link" id="step3-tab" data-toggle="tab" href="#step3" role="tab"
                           aria-controls="step3" aria-selected="false">
                            <div class="circle">3</div>
                            Lifestyle & Treatment</a></li>
                    <li><a class="nav-link" id="step4-tab" data-toggle="tab" href="#step4" role="tab"
                           aria-controls="step4" aria-selected="false">
                            <div class="circle">4</div>
                            Symptom Assessment</a></li>
                    <li><a class="nav-link" id="step5-tab" data-toggle="tab" href="#step5" role="tab"
                           aria-controls="step5" aria-selected="false">
                            <div class="circle">5</div>
                            Shipping & Billing </a></li>
                    <li><a class="nav-link active" id="step6-tab" data-toggle="tab" href="#step6" role="tab"
                           aria-controls="step6" aria-selected="true">
                            <div class="circle">6</div>
                            Follow Up</a></li>

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="step6" role="tabpanel" aria-labelledby="step6-tab">
                        <form action="{{route('save-trt-step-six-refill')}}" method="post" enctype="multipart/form-data"
                              class="ajax-form">
                            @csrf
                            <div class="follow-step">
                                <h1>Follow Up</h1>
                                <input type="hidden" name="patients_id" value="{{!empty($patient)?$patient->patients_id:''}}">
                                <div class="form-group">
                                    <label for="">Any additional information you'd like to share?</label>
                                    <input type="text" class="form-control" placeholder=""
                                           name="additional_information" value="{{!empty($patient)?$patient->additional_information:''}}">
                                </div>
                                <div class="like-area">
                                    <p>Based on your experience, would you recommend Male Excel to someone that may
                                        benefit from hormone replacement therapy?</p>
                                    <div class="likely-block">
                                        <div class="subtitle">Not likely at all</div>
                                        <div class="like-checkarea">
                                            <ul class="like-number">
                                                @if(!empty($getExperience))
                                                    @foreach($getExperience as $key=>$value)
                                                        <li>
                                                            <input type="radio" name="experience"
                                                                   id="experience_{{$key}}" value="{{$value['value']}}"
                                                                   class="css-checkcircle">
                                                            <br><label for="experience_{{$key}}"
                                                                       class="css-radioinput">{{$value['label']}}</label>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                        <div class="subtitle">Extremely likely</div>
                                    </div>
                                </div>
                                <div class="btn-area text-center">
                                    <a href="{{route('trt-step5')}}" class="btn-back">Back</a>
                                    <button type="submit" class="btn-continue">Save Update</button>
                                </div>

                            </div>
                        </form>
                        <div class="thank-you" style="display: none">
                            <h1><i class="fas fa-check-circle"></i>Your medical refill Assessment was submitted
                                successfully!</h1>
                            <div class="note">Thank you for completing your assessment. Current processing times are 10
                                to 15 days. You will be notified when your order ships. Once your order ships, you can
                                track your order via our member portal. If you have any questions, text us at (833) 394
                                - 7744.
                            </div>
                            <h3>What Happens Next</h3>
                            <div class="icon-withtitle">
                                <div class="main-block">
                                    <div class="icon"><i class="fas fa-dollar-sign"></i></div>
                                    Automated prescription billing
                                </div>
                                <div class="center-icon"><i class="fas fa-arrow-right"></i></div>
                                <div class="main-block">
                                    <div class="icon"><i class="fas fa-truck"></i></div>
                                    Shipment of your medication to you
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
