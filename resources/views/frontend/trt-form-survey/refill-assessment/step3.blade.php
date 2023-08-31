@extends('layouts.frontend')
@section('content')
    <!--get-started-->
    <section>
        <div class="trt-section">
            <div class="container">
                <ul class="nav trt-tab" id="myTab" role="tablist">
                    <li><a class="nav-link " id="step1-tab" data-toggle="tab" href="#step1" role="tab"
                           aria-controls="step1" aria-selected="true">
                            <div class="circle">1</div>
                            Personal Information</a></li>
                    <li><a class="nav-link" id="step2-tab" data-toggle="tab" href="#step2" role="tab"
                           aria-controls="step2" aria-selected="false">
                            <div class="circle">2</div>
                            Symptom Status</a></li>
                    <li><a class="nav-link active" id="step3-tab" data-toggle="tab" href="#step3" role="tab"
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
                    <li><a class="nav-link" id="step6-tab" data-toggle="tab" href="#step6" role="tab"
                           aria-controls="step6" aria-selected="false">
                            <div class="circle">6</div>
                            Follow Up</a></li>

                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="step3" role="tabpanel" aria-labelledby="step3-tab">
                        <h1>Lifestyle & Treatment</h1>
                        <form action="{{route('save-trt-step-three-refill')}}" method="post" enctype="multipart/form-data"
                              class="ajax-form">
                            @csrf
                            <div class="radio-area">
                                <h4>Do you want to have children in the future?</h4>
                                <ul class="flex-radio">
                                    <li>
                                        <input type="radio" name="future_children" id="yes1" value="Yes"
                                               data-msg-required="Future children is required"
                                               {{ !empty($patient->future_children) && $patient->future_children == 1 ? 'checked' : ''}} class="css-radio required">
                                        <label for="yes1" class="css-label">Yes</label>
                                    </li>
                                    <li>
                                        <input type="radio" name="future_children"
                                               data-msg-required="Future children is required"
                                               id="no1" value="No" {{ !empty($patient->future_children) && $patient->future_children == 0 ? 'checked' : ''}} class="css-radio required">
                                        <label for="no1" class="css-label">No</label>
                                    </li>
                                </ul>
                            </div>
                            <div class="radio-area">
                                <h4>Do you have any children under the age of 5 years living in the home?</h4>
                                <ul class="flex-radio">
                                    <li>
                                        <input type="radio" name="living_children" id="Yes2"
                                               data-msg-required="Children under the age of 5 years living in the home is required"
                                               value="Yes"
                                               class="css-radio required"
                                               {{ !empty($patient->living_children) && $patient->living_children == 1 ? 'checked' : ''}} >
                                        <label for="Yes2" class="css-label">Yes</label>
                                    </li>
                                    <li>
                                        <input type="radio" name="living_children" id="No2"
                                               data-msg-required="Children under the age of 5 years living in the home is required"
                                               value="No" {{ !empty($patient->living_children) && $patient->living_children == 0 ? 'checked' : ''}} class="css-radio required">
                                        <label for="No2" class="css-label">No</label>
                                    </li>
                                </ul>
                            </div>
                            <div class="radio-area">
                                <h4>We offer testosterone in the form of injection, cream, and gel: are you interested
                                    in changing your treatment method?</h4>
                                <ul class="flex-radio">
                                    <li>
                                        <input type="radio" name="cream_and_gel" id="Yes3" value="Yes" {{ !empty($patient->cream_and_gel) && $patient->cream_and_gel == 1 ? 'checked' : ''}} class="css-radio required"
                                               data-msg-required="Testosterone is required">
                                        <label for="Yes3" class="css-label">Yes</label>
                                    </li>
                                    <li>
                                        <input type="radio" name="cream_and_gel" id="No3" value="No"  {{ !empty($patient->cream_and_gel) && $patient->cream_and_gel == 0 ? 'checked' : ''}} class="css-radio required"
                                               data-msg-required="Testosterone is required">
                                        <label for="No3" class="css-label">No</label>
                                    </li>
                                </ul>
                            </div>
                            <div class="radio-area">
                                <h4>Do you have any new allergies that we should know about?</h4>
                                <ul class="flex-radio">
                                    <li>
                                        <input type="radio" name="allergies" id="Yes4" value="Yes" {{ !empty($patient->allergies) && $patient->allergies == 1 ? 'checked' : ''}} class="css-radio required" data-msg-required="Allergies is required">
                                        <label for="Yes4" class="css-label">Yes</label>
                                    </li>
                                    <li>
                                        <input type="radio" name="allergies" id="No4"  value="No" {{ !empty($patient->allergies) && $patient->allergies == 0 ? 'checked' : ''}} class="css-radio required" data-msg-required="Allergies is required">
                                        <label for="No4" class="css-label">No</label>
                                    </li>
                                </ul>
                            </div>
                            <div class="radio-area">
                                <h4>Do you have any new prescription drugs, over-the-counter medicine, herbal or vitamin
                                    supplements that we should know about?</h4>
                                <ul class="flex-radio">
                                    <li>
                                        <input type="radio" name="herbal_or_vitamin" id="Yes5" value="Yes" {{ !empty($patient->herbal_or_vitamin) && $patient->herbal_or_vitamin == 1 ? 'checked' : ''}} class="css-radio required" data-msg-required="Prescription is required">
                                        <label for="Yes5" class="css-label">Yes</label>
                                    </li>
                                    <li>
                                        <input type="radio" name="herbal_or_vitamin" id="No5" value="No" {{ !empty($patient->herbal_or_vitamin) && $patient->herbal_or_vitamin == 0 ? 'checked' : ''}} class="css-radio required" data-msg-required="Prescription is required">
                                        <label for="No5" class="css-label">No</label>
                                    </li>
                                </ul>
                            </div>
                            <div class="radio-area">
                                <h4>Are you taking your medications as prescribed?</h4>
                                <ul class="flex-radio">
                                    <li>
                                        <input type="radio" name="medications_prescribed" id="Yes6" value="Yes" {{ !empty($patient->medications_prescribed) && $patient->medications_prescribed == 1 ? 'checked' : ''}} class="css-radio required" data-msg-required="Medications is required">
                                        <label for="Yes6" class="css-label">Yes</label>
                                    </li>
                                    <li>
                                        <input type="radio" name="medications_prescribed" id="No6" value="No" {{ !empty($patient->medications_prescribed) && $patient->medications_prescribed == 0 ? 'checked' : ''}} class="css-radio required" data-msg-required="Medications is required">
                                        <label for="No6" class="css-label">No</label>
                                    </li>
                                </ul>
                            </div>
                            <div class="btn-area">
                                <a href="{{route('trt-step2')}}" class="btn-back">Back</a>
                                <button type="submit" class="btn-continue">Continue</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
