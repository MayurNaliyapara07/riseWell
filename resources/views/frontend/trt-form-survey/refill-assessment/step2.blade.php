@inject('baseHelper','App\Helpers\Frontend\Helper')
@extends('layouts.frontend')
@section('content')
    <?php
    $getPrimaryHealthGoal = $baseHelper->getPrimaryHealthGoal();
    $getEnergy = $baseHelper->getEnergy();

    ?>
        <!--get-started-->
    <section>
        <div class="trt-section">
            <div class="container">
                <ul class="nav trt-tab" id="myTab" role="tablist">
                    <li><a class="nav-link " id="step1-tab" data-toggle="tab" href="#step1" role="tab"
                           aria-controls="step1" aria-selected="true">
                            <div class="circle">1</div>
                            Personal Information</a></li>
                    <li><a class="nav-link active" id="step2-tab" data-toggle="tab" href="#step2" role="tab"
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
                    <li><a class="nav-link" id="step6-tab" data-toggle="tab" href="#step6" role="tab"
                           aria-controls="step6" aria-selected="false">
                            <div class="circle">6</div>
                            Follow Up</a></li>

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="step2" role="tabpanel" aria-labelledby="step2-tab">
                        <h1>Symptom Status</h1>
                        <form action="{{route('save-trt-step-two-refill')}}" method="post" enctype="multipart/form-data"
                              class="ajax-form">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Energy</label>
                                        <select name="energy" class="form-control required" id=""
                                                data-msg-required="Energy is required">
                                            <option value="">Please select energy</option>
                                            @if(!empty($getEnergy))
                                                @foreach($getEnergy as $value)
                                                    <option value="{{$value['value']}}"  {{ !empty($patient->energy) && $patient->energy == $value['value'] ? 'selected' : ''}}>{{$value['label']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Sleep</label>
                                        <select name="sleep" class="form-control" id="">
                                            <option value="">Please select sleep</option>
                                            @if(!empty($getEnergy))
                                                @foreach($getEnergy as $value)
                                                    <option value="{{$value['value']}}" {{ !empty($patient->sleep) && $patient->sleep == $value['value'] ? 'selected' : ''}}>{{$value['label']}}</option>
                                                @endforeach
                                            @endif

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Libido</label>
                                        <select name="libido" class="form-control" id="">
                                            <option value="">Please select libido</option>
                                            @if(!empty($getEnergy))
                                                @foreach($getEnergy as $value)
                                                    <option value="{{$value['value']}}" {{ !empty($patient->libido) && $patient->libido == $value['value'] ? 'selected' : ''}}>{{$value['label']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Memory & Focus</label>
                                        <select name="memory" class="form-control" id="">
                                            <option value="">Please select memory & focus</option>
                                            @if(!empty($getEnergy))
                                                @foreach($getEnergy as $value)
                                                    <option value="{{$value['value']}}" {{ !empty($patient->memory) && $patient->memory == $value['value'] ? 'selected' : ''}}>{{$value['label']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Endurance & Strength</label>
                                        <select name="strength" class="form-control" id="">
                                            <option value="">Please select endurance & strength</option>
                                            @if(!empty($getEnergy))
                                                @foreach($getEnergy as $value)
                                                    <option value="{{$value['value']}}" {{ !empty($patient->strength) && $patient->strength == $value['value'] ? 'selected' : ''}}>{{$value['label']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-area">
                                <a href="{{route('trt-step1')}}" class="btn-back">Back</a>
                                <button type="submit" class="btn-continue">Continue</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
