@inject('baseHelper','App\Helpers\Frontend\Helper')
@extends('layouts.frontend')
@section('content')
    <?php
    $getSymptom = $baseHelper->getSymptomAssessment();
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
                    <li><a class="nav-link" id="step2-tab" data-toggle="tab" href="#step2" role="tab"
                           aria-controls="step2" aria-selected="false">
                            <div class="circle">2</div>
                            Symptom Status</a></li>
                    <li><a class="nav-link" id="step3-tab" data-toggle="tab" href="#step3" role="tab"
                           aria-controls="step3" aria-selected="false">
                            <div class="circle">3</div>
                            Lifestyle & Treatment</a></li>
                    <li><a class="nav-link active" id="step4-tab" data-toggle="tab" href="#step4" role="tab"
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
                    <div class="tab-pane fade show active" id="step4" role="tabpanel" aria-labelledby="step4-tab">
                        <h1>Symptom Assessment</h1>
                        <form action="{{route('save-trt-step-four-refill')}}" method="post"
                              enctype="multipart/form-data"
                              class="ajax-form">
                            @csrf
                            <div class="check-area">
                                <h3>Cold Chills</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->cold_chills) ? $patient->cold_chills : 'None'}}</span></p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="cold_chills" id="cold_chills_{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="cold_chills_{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Cold Hands and Feet</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->cold_hand_and_feet) ? $patient->cold_hand_and_feet : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="cold_hand_and_feet"
                                                       id="cold_hand_and_feet{{$key}}" value="{{$value['value']}}"
                                                       class="css-radioinput">
                                                <label for="cold_hand_and_feet{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Decreased Sweating </h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->decreased_sweating) ? $patient->decreased_sweating : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="decreased_sweating"
                                                       id="decreased_sweating{{$key}}" value="{{$value['value']}}"
                                                       class="css-radioinput">
                                                <label for="decreased_sweating{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Thinnking Skin</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->thinning_skin) ? $patient->thinning_skin : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="thinning_skin" id="thinning_skin{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="thinning_skin{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Excessive Body Hair</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->excessive_body_hair) ? $patient->excessive_body_hair : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="excessive_body_hair"
                                                       id="excessive_body_hair{{$key}}" value="{{$value['value']}}"
                                                       class="css-radioinput">
                                                <label for="excessive_body_hair{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Nail Brittle Or Breaking</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->nail_brittle) ? $patient->nail_brittle : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="nail_brittle" id="nail_brittle{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="nail_brittle{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Dry and Brittle Hair</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->dry_brittle) ? $patient->dry_brittle : 'None'}}</span></p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="dry_brittle" id="dry_brittle{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="dry_brittle{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Hair Loss On Scalp</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->hair_loss) ? $patient->hair_loss : 'None'}}</span></p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="hair_loss" id="hair_loss{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="hair_loss{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Dry Skin</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->dry_skin) ? $patient->dry_skin : 'None'}}</span></p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="dry_skin" id="dry_skin{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="dry_skin{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Thinning Public Hair</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->thinning_public_hair) ? $patient->thinning_public_hair : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="thinning_public_hair"
                                                       id="thinning_public_hair{{$key}}" value="{{$value['value']}}"
                                                       class="css-radioinput">
                                                <label for="thinning_public_hair{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Low Libido</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->low_libido) ? $patient->low_libido : 'None'}}</span></p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="low_libido" id="low_libido{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="low_libido{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Memory Lapses</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->memory_lapsed) ? $patient->memory_lapsed : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="memory_lapsed" id="memory_lapsed{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="memory_lapsed{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Difficulty Concentrating</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->difficulty_concentrating) ? $patient->difficulty_concentrating : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="difficulty_concentrating"
                                                       id="difficulty_concentrating{{$key}}" value="{{$value['value']}}"
                                                       class="css-radioinput">
                                                <label for="difficulty_concentrating{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Depression</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->deperssion) ? $patient->deperssion : 'None'}}</span></p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="deperssion" id="deperssion{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="deperssion{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Strees</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->stress) ? $patient->stress : 'None'}}</span></p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="stress" id="stress{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="stress{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Anxiety</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->anxiety) ? $patient->anxiety : 'None'}}</span></p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="anxiety" id="anxiety{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="anxiety{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Sleep Disturbances</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->sleep_disturbances) ? $patient->sleep_disturbances : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="sleep_disturbances"
                                                       id="sleep_disturbances{{$key}}" value="{{$value['value']}}"
                                                       class="css-radioinput">
                                                <label for="sleep_disturbances{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Aches and Pains</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->aches_and_pains) ? $patient->aches_and_pains : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="aches_and_pains" id="aches_and_pains{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="aches_and_pains{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Headaches</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->headaches) ? $patient->headaches : 'None'}}</span></p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="headaches" id="headaches{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="headaches{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Tired Or Exhausted</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->tired) ? $patient->tired : 'None'}}</span></p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="tired" id="tired{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="tired{{$key}}" class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Hoarseness</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->hoarseness) ? $patient->hoarseness : 'None'}}</span></p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="hoarseness" id="hoarseness{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="hoarseness{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Slowed Reflexes</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->slowed_reflexes) ? $patient->slowed_reflexes : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="slowed_reflexes" id="slowed_reflexes{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="slowed_reflexes{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Constipation</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->constipation) ? $patient->constipation : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="constipation" id="constipation{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="constipation{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Heart Palpitations</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->hear_palpitation) ? $patient->hear_palpitation : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="hear_palpitation"
                                                       id="hear_palpitation{{$key}}" value="{{$value['value']}}"
                                                       class="css-radioinput">
                                                <label for="hear_palpitation{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Fast Heart Rate</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->fast_heart_rate) ? $patient->fast_heart_rate : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="fast_heart_rate" id="fast_heart_rate{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="fast_heart_rate{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Sugar Cravings</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->sugar_cravings) ? $patient->sugar_cravings : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="sugar_cravings" id="sugar_cravings{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="sugar_cravings{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Weight Gain</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->weight_gain) ? $patient->weight_gain : 'None'}}</span></p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="weight_gain" id="weight_gain{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="weight_gain{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Weight Loss Difficulty</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->weight_loss_difficulty) ? $patient->weight_loss_difficulty : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="weight_loss_difficulty"
                                                       id="weight_loss_difficulty{{$key}}" value="{{$value['value']}}"
                                                       class="css-radioinput">
                                                <label for="weight_loss_difficulty{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Decreased Muscle Mass</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->decreased_muscle_mass) ? $patient->decreased_muscle_mass : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="decreased_muscle_mass"
                                                       id="decreased_muscle_mass{{$key}}" value="{{$value['value']}}"
                                                       class="css-radioinput">
                                                <label for="decreased_muscle_mass{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Hot Flashes</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->hot_flashes) ? $patient->hot_flashes : 'None'}}</span></p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="hot_flashes" id="hot_flashes{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="hot_flashes{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Excessive Sweating</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->excessive_sweating) ? $patient->excessive_sweating : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="excessive_sweating"
                                                       id="excessive_sweating{{$key}}" value="{{$value['value']}}"
                                                       class="css-radioinput">
                                                <label for="excessive_sweating{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Excessive Facial Hair</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->excessive_facial_hair) ? $patient->excessive_facial_hair : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="excessive_facial_hair"
                                                       id="excessive_facial_hair{{$key}}" value="{{$value['value']}}"
                                                       class="css-radioinput">
                                                <label for="excessive_facial_hair{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Increased Acne</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->increased_acne) ? $patient->increased_acne : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="increased_acne" id="increased_acne{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="increased_acne{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Oily Skin</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->oily_skin) ? $patient->oily_skin : 'None'}}</span></p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="oily_skin" id="oily_skin{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="oily_skin{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Irritability</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->irritability) ? $patient->irritability : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="irritability" id="irritability{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="irritability{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Mood Changes</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->mood_changes) ? $patient->mood_changes : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="mood_changes" id="mood_changes{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="mood_changes{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Incontinence</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->incontinence) ? $patient->incontinence : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="incontinence" id="incontinence{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="incontinence{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Puffy Eyes Or Swollen Face</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->puffy_eyes) ? $patient->puffy_eyes : 'None'}}</span></p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="puffy_eyes" id="puffy_eyes{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="puffy_eyes{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Low Blood Pressure</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->low_blood_pressure) ? $patient->low_blood_pressure : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="low_blood_pressure"
                                                       id="low_blood_pressure{{$key}}" value="{{$value['value']}}"
                                                       class="css-radioinput">
                                                <label for="low_blood_pressure{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Slow Heart Rate</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->slow_heart_rate) ? $patient->slow_heart_rate : 'None'}}</span>
                                </p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="slow_heart_rate" id="slow_heart_rate{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="slow_heart_rate{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="check-area">
                                <h3>Weight Loss</h3>
                                <p>You Previously Selected :
                                    <span>{{!empty($patient->weight_loss) ? $patient->weight_loss : 'None'}}</span></p>
                                <ul class="flex-check">
                                    @if(!empty($getSymptom))
                                        @foreach($getSymptom as $key=>$value)
                                            <li>
                                                <input type="radio" name="weight_loss" id="weight_loss{{$key}}"
                                                       value="{{$value['value']}}" class="css-radioinput">
                                                <label for="weight_loss{{$key}}"
                                                       class="css-label">{{$value['label']}}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="btn-area">
                                <a href="{{route('trt-step3')}}" class="btn-back">Back</a>
                                <button type="submit" class="btn-continue">Continue</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
