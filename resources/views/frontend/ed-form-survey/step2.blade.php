@inject('baseHelper','App\Helpers\Frontend\Helper')
@extends('layouts.frontend')
@section('content')
    <?php
    $getBloodPressure = $baseHelper->getBloodPressure();
    $getBloodPressureMedication = $baseHelper->getBloodPressureMedication();
    $getMedicationsConjunction = $baseHelper->getMedicationsConjunction();
    $getRecreationalDrugs = $baseHelper->getRecreationalDrugs();
    $getTreat = $baseHelper->getTreat();
    $getCardiovascular = $baseHelper->getCardiovascular();
    $getDiabetes = $baseHelper->getDiabetes();
    $getDiabetesLevel = $baseHelper->getDiabetesLevel();
    $getThyroid = $baseHelper->getThyroid();
    $getCholesterol = $baseHelper->getCholesterol();
    $getBreathing = $baseHelper->getBreathing();
    $getGastroesophageal = $baseHelper->getGastroesophageal();
    $getHyperactivity = $baseHelper->getHyperactivity();

    $selectedConjunction = !empty($patient->medication_conjunction) ? explode(',', $patient->medication_conjunction) : '';
    $selectedRecreationalDrugs = !empty($patient->recreational_drugs) ? explode(',', $patient->recreational_drugs) : '';
    ?>
    <section>
        <div class="form-area-section">
            <div class="container">
                <div class="step-list">
                    <ul class="step">
                        <li class="active">
                            <div class="circle"></div>
                            Step 1<span>Basic Questions</span></li>
                        <li class="active">
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
                    <h1>Medical History</h1>
                    <form id="ed_flow" action="{{route('save-ed-step-two')}}" method="post" enctype="multipart/form-data" class="ajax-form">
                        @csrf
                        <div class="form-block">

                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>Have you had your vitals tested by a medical practitioner in the past 3
                                        years?</h4>
                                    <h4><span>This includes weight, blood pressure, and heart rate.</span></h4>
                                    <ul class="flex-check">
                                        <li>
                                            <input type="radio" name="vitals" value="1" id="vitals_yes"  {{ !empty($patient) && $patient->vitals == 1 ? 'checked' : ''}}
                                                   class="css-radio required" data-msg-required="Vitas Tested is required">
                                            <label for="vitals_yes" class="css-label">Yes</label>
                                        </li>
                                        <li>
                                            <input type="radio" name="vitals" value="0" id="vitals_no" {{ !empty($patient) && $patient->vitals == 0 ? 'checked' : ''}}
                                                   class="css-radio required" data-msg-required="Vitas Tested is required">
                                            <label for="vitals_no" class="css-label">No</label>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>Were there any medical problems?</h4>
                                    <ul class="flex-check">
                                        <li>
                                            <input type="radio" name="medical_problems" value="1" {{ !empty($patient) && $patient->medical_problems == 1 ? 'checked' : ''}}
                                                   id="medical_problems_yes"
                                                   data-msg-required="Medication Problems is required"
                                                   class="css-radio required">
                                            <label for="medical_problems_yes" class="css-label">Yes</label>
                                        </li>
                                        <li>
                                            <input type="radio" name="medical_problems" value="0" {{ !empty($patient) && $patient->medical_problems == 0 ? 'checked' : ''}}
                                                   id="medical_problems_no"
                                                   data-msg-required="Medical Problems is required"
                                                   class="css-radio required">
                                            <label for="medical_problems_no" class="css-label">No</label>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>What were the medical problem(s)?</h4>
                                    <div class="form-group">
                                        <input type="text" class="form-control required" placeholder="Type Here"
                                               data-msg-required="Medical Problem(s) is required"
                                               name="medical_problem" value="{{!empty($patient) ? $patient->medical_problem : old('medical_problem')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>How is your blood pressure?</h4>

                                    <ul class="flex-check">
                                        @if($getBloodPressure)
                                            @foreach($getBloodPressure as $key=>$bloodPressure)
                                                <li>
                                                    <input type="radio" name="blood_pressure"
                                                           data-msg-required="Blood Pressure is required"
                                                           value="{{$bloodPressure['value']}}"
                                                           {{ !empty($patient) && $patient->blood_pressure == $bloodPressure['value'] ? 'checked' : ''}}
                                                           id="blood_pressure_{{$key}}"
                                                           class="css-radio required">
                                                    <label for="blood_pressure_{{$key}}"
                                                           class="css-label">{{$bloodPressure['label']}}</label>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>

                            </div>
                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>Please select your blood pressure medication.</h4>

                                    <ul class="flex-check">

                                        @if($getBloodPressureMedication)
                                            @foreach($getBloodPressureMedication as $key=>$bloodPressureMedication)
                                                <li>
                                                    <input type="radio" name="blood_pressure_medication"
                                                           data-msg-required="Blood Pressure Medication is required"
                                                           value="{{$bloodPressureMedication['value']}}"
                                                           {{ !empty($patient) && $patient->blood_pressure_medication == $bloodPressureMedication['value'] ? 'checked' : ''}}
                                                           id="blood_pressure_medication_{{$key}}" class="css-radio required">
                                                    <label for="blood_pressure_medication_{{$key}}"
                                                           class="css-label">{{$bloodPressureMedication['label']}}</label>
                                                </li>
                                            @endforeach
                                        @endif

                                    </ul>
                                </div>

                            </div>
                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>Enter other medications below</h4>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Type Here"
                                               name="medications"
                                               value="{{!empty($patient) ? $patient->medications : old('medications')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>Death can result if ED medications are used in conjunction with nitrates or
                                        other
                                        medications. Please be accurate. | use or have used:</h4>
                                    <ul class="half-flex-check">

                                        @if($getMedicationsConjunction)
                                            @foreach($getMedicationsConjunction as $medicationsConjunction)
                                                <li>
                                                    <input type="checkbox" name="medication_conjunction[]"
                                                           data-msg-required="Nitrates Medication is required"
                                                           value="{{$medicationsConjunction['value']}}"
                                                           {{  !empty($selectedConjunction) && in_array($medicationsConjunction['value'],$selectedConjunction) ?  'checked':'' }}
                                                           id="{{$medicationsConjunction['key']}}" class="css-checkbox required">
                                                    <label for="{{$medicationsConjunction['key']}}"
                                                           class="css-label">{{$medicationsConjunction['label']}}</label>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="gap-40">

                                <div class="checkbox-area">
                                    <h4>
                                        Death can result if ED meds are used in conjunction with recreational drugs.
                                        Have
                                        you, or are
                                        you currently using any of the following recreational drugs?</h4>


                                    <ul class="half-flex-check">
                                        @if($getRecreationalDrugs)
                                            @foreach($getRecreationalDrugs as $drugs)
                                                <li>
                                                    <input type="checkbox" name="recreational_drugs[]"
                                                           data-msg-required="Recreational Medication is required"
                                                           value="{{$drugs['value']}}"
                                                           {{ !empty($selectedRecreationalDrugs) && in_array($drugs['value'],$selectedRecreationalDrugs) ?  'checked':'' }}
                                                           id="recreational_drugs_{{$drugs['key']}}"
                                                           class="css-checkbox required">
                                                    <label for="recreational_drugs_{{$drugs['key']}}"
                                                           class="css-label">{{$drugs['label']}}</label>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>Do you take any over the counter or prescription medications?</h4>
                                    <h4><span>(Please note that your answers will be checked against prescription and insurance databases. For your safety,
                                        failure to disclose current prescriptions and/or medical conditions will result in disapproval.)</span>
                                    </h4>
                                    <ul class="flex-check">
                                        <li>
                                            <input type="radio" name="medication_prescription" value="1"  {{ !empty($patient) && $patient->medication_prescription == 1 ? 'checked' : ''}}
                                                   id="medication_prescription_yes" class="css-radio required"
                                                   data-msg-required="Prescription Medications is required"
                                            >
                                            <label for="medication_prescription_yes" class="css-label">Yes</label>
                                        </li>
                                        <li>
                                            <input type="radio" name="medication_prescription" value="0" {{ !empty($patient) && $patient->medication_prescription == 0 ? 'checked' : ''}}
                                                   id="medication_prescription_no" class="css-radio required"
                                                   data-msg-required="Prescription Medications is required"
                                            >
                                            <label for="medication_prescription_no" class="css-label">No</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>
                                        Which condtion or conditions do they treat??</h4>
                                    <ul class="flex-check">
                                        @if($getTreat)
                                            @foreach($getTreat as $treat)
                                                <li>
                                                    <input type="radio" name="treat"
                                                           value="{{$treat['value']}}"
                                                           {{ !empty($patient) && $patient->treat == $treat['value'] ? 'checked' : ''}}
                                                           id="treat_{{$treat['key']}}" class="css-radio required"
                                                           data-msg-required="Treat Conditions is required"
                                                    >
                                                    <label for="treat_{{$treat['key']}}"
                                                           class="css-label">{{$treat['label']}}</label>
                                                </li>

                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>Enter others conditions below</h4>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Type Here"
                                               name="other_conditions" value="{{!empty($patient) ? $patient->other_conditions : old('other_conditions')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>Please select your cardiovascular disease (heart) (excluding blood pressure)
                                        medication:</h4>
                                    <ul class="flex-check">
                                        @if($getCardiovascular)
                                            @foreach($getCardiovascular as $cardiovascular)
                                                <li>
                                                    <input type="radio" name="cardiovascular"
                                                           value="{{$cardiovascular['value']}}"
                                                           {{ !empty($patient) && $patient->cardiovascular == $cardiovascular['value'] ? 'checked' : ''}}
                                                           id="cardiovascular_{{$cardiovascular['key']}}"
                                                           class="css-radio required"
                                                           data-msg-required="Cardiovascular Disease is required"
                                                    >
                                                    <label for="cardiovascular_{{$cardiovascular['key']}}"
                                                           class="css-label">{{$cardiovascular['label']}}</label>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>Please select your diabetes medication:</h4>
                                    <ul class="flex-check">
                                        @if($getDiabetes)
                                            @foreach($getDiabetes as $diabetes)
                                                <li>
                                                    <input type="radio" name="diabetes" value="{{$diabetes['value']}}"
                                                           id="{{$diabetes['key']}}"
                                                           {{ !empty($patient) && $patient->diabetes == $diabetes['value'] ? 'checked' : ''}}
                                                           class="css-radio required"
                                                           data-msg-required="Diabetes Medication is required"
                                                    >
                                                    <label for="{{$diabetes['key']}}"
                                                           class="css-label">{{$diabetes['label']}}</label>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>What is your diabetes level?</h4>
                                    <ul class="flex-check">
                                        @if($getDiabetesLevel)
                                            @foreach($getDiabetesLevel as $diabetesLevel)
                                                <li>
                                                    <input type="radio" name="diabetes_level"
                                                           value="{{$diabetesLevel['value']}}"
                                                           {{ !empty($patient) && $patient->diabetes_level == $diabetesLevel['value'] ? 'checked' : ''}}
                                                           id="{{$diabetesLevel['key']}}" class="css-radio required"
                                                           data-msg-required="Diabetes Level is required"
                                                    >
                                                    <label for="{{$diabetesLevel['key']}}"
                                                           class="css-label">{{$diabetesLevel['label']}}</label>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>Please select your thyroid medication:</h4>
                                    <ul class="flex-check">
                                        @if($getThyroid)
                                            @foreach($getThyroid as $thyroid)
                                                <li>
                                                    <input type="radio" name="thyroid"
                                                           value="{{$thyroid['value']}}"
                                                           {{ !empty($patient) && $patient->thyroid == $thyroid['value'] ? 'checked' : ''}}
                                                           id="{{$thyroid['key']}}" class="css-radio required"
                                                           data-msg-required="Thyroid Medication is required"
                                                    >
                                                    <label for="{{$thyroid['key']}}"
                                                           class="css-label">{{$thyroid['label']}}</label>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>Please select your cholesterol medication:</h4>
                                    <ul class="flex-check">
                                        @if($getCholesterol)
                                            @foreach($getCholesterol as $cholesterol)
                                                <li>
                                                    <input type="radio" name="cholesterol"
                                                           value="{{$cholesterol['value']}}"
                                                           {{ !empty($patient) && $patient->cholesterol == $cholesterol['value'] ? 'checked' : ''}}
                                                           id="{{$cholesterol['key']}}" class="css-radio required"
                                                           data-msg-required="Cholesterol Medication is required"
                                                    >
                                                    <label for="{{$cholesterol['key']}}"
                                                           class="css-label">{{$cholesterol['label']}}</label>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>Please select your lung condition (breathing) medication:</h4>
                                    <ul class="flex-check">
                                        @if($getBreathing)
                                            @foreach($getBreathing as $breathing)
                                                <li>
                                                    <input type="radio" name="breathing" value="{{$breathing['value']}}"
                                                           {{ !empty($patient) && $patient->breathing == $breathing['value'] ? 'checked' : ''}}
                                                           id="{{$breathing['key']}}" class="css-radio required"
                                                           data-msg-required="Breathing Medication is required">
                                                    <label for="{{$breathing['key']}}"
                                                           class="css-label">{{$breathing['label']}}</label>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>
                                        Please select your gastroesophageal reflux medication:</h4>
                                    <ul class="flex-check">
                                        @if($getGastroesophageal)
                                            @foreach($getGastroesophageal as $gastroesophageal)
                                                <li>
                                                    <input type="radio" name="gastroesophageal"
                                                           value="{{$gastroesophageal['value']}}"
                                                           {{ !empty($patient) && $patient->gastroesophageal == $gastroesophageal['value'] ? 'checked' : ''}}
                                                           id="{{$gastroesophageal['key']}}" class="css-radio required"
                                                           data-msg-required="Gastroesophageal Reflux Medication is required"
                                                    >
                                                    <label for="{{$gastroesophageal['key']}}"
                                                           class="css-label">{{$gastroesophageal['label']}}</label>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>
                                        Please select your attention deficit hyperactivity disorder (ADHD)
                                        medication:</h4>
                                    <ul class="flex-check">
                                        @if($getHyperactivity)
                                            @foreach($getHyperactivity as $hyperactivity)
                                                <li>
                                                    <input type="radio" name="hyperactivity"
                                                           value="{{$hyperactivity['value']}}"
                                                           {{ !empty($patient) && $patient->hyperactivity == $hyperactivity['value'] ? 'checked' : ''}}
                                                           id="{{$hyperactivity['key']}}" class="css-radio required"
                                                           data-msg-required="ADHD Medication is required"
                                                    >
                                                    <label for="{{$hyperactivity['key']}}"
                                                           class="css-label">{{$hyperactivity['label']}}</label>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>

                                </div>
                            </div>
                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>

                                        Do you have any medication allergies?</h4>
                                    <ul class="flex-check">
                                        <li>
                                            <input type="radio" name="allergies" value="1" id="allergies_yes"  {{ !empty($patient) && $patient->allergies == 1 ? 'checked' : ''}}
                                                   class="css-radio required" data-msg-required="Medication Allergies is required"
                                            >
                                            <label for="allergies_yes" class="css-label">Yes</label>
                                        </li>
                                        <li>
                                            <input type="radio" name="allergies" value="0" id="allergies_no" {{ !empty($patient) && $patient->allergies == 0 ? 'checked' : ''}}
                                            class="css-radio required" data-msg-required="Medication Allergies is required">
                                            <label for="allergies_no" class="css-label">No</label>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>Please list your medication allergies.</h4>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Type Here"
                                               name="allergies_list"
                                               value="{{!empty($patient)?$patient->allergies_list:old('allergies_list')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>PIs there anything else medically relevant we should know about you?</h4>
                                    <h4><span>(Enter “No” if there is nothing)</span></h4>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Type Here" name="pi"
                                               value="{{!empty($patient)?$patient->pi:old('pi')}}">
                                    </div>
                                </div>
                            </div>
                            <a href="{{route('step1')}}" class="btn-back">Back</a>
                            <button type="submit" class="btn-continue">Continue</button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </section>
@endsection
