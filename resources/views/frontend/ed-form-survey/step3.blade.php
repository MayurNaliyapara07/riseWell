@inject('baseHelper','App\Helpers\Frontend\Helper')
@extends('layouts.frontend')
@section('content')
    <?php
    $getTreatWith = $baseHelper->getTreatWith();
    $getConfidenceRate = $baseHelper->getConfidenceRate();
    $getSexualStimulation = $baseHelper->getSexualStimulation();
    $getSexualDificult = $baseHelper->getSexualDificult();
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
                        <li class="active">
                            <div class="circle"></div>
                            Step 3<span>Sexual Health</span></li>
                        <li>
                            <div class="circle"></div>
                            Step 4<span>Checkout</span></li>
                    </ul>
                </div>
                <div class="right-form-area">
                    <h1>Sexual Health</h1>
                    <div class="form-block">
                        <form id="ed_flow" action="{{route('save-step-three')}}" enctype="multipart/form-data" class="ajax-form">
                            @csrf
                            <div class="gap-60">
                                <div class="checkbox-area">
                                    <h4>Have you ever suffered or been treated for Erectile Dysfunction or tried any ED
                                        medications?</h4>
                                    <h4>
                                        <span>(This includes medications prescribed or purchased over the counter)</span>
                                    </h4>
                                    <ul class="flex-check">
                                        <li>
                                            <input type="radio" name="erectile_dysfunction" {{ !empty($patient) && $patient->erectile_dysfunction == 1 ? 'checked' : ''}}
                                                   id="erectile_dysfunction_yes" class="css-radio">
                                            <label for="erectile_dysfunction_yes" class="css-label">Yes</label>
                                        </li>
                                        <li>
                                            <input type="radio" name="erectile_dysfunction" {{ !empty($patient) && $patient->erectile_dysfunction == 0 ? 'checked' : ''}}
                                                   id="erectile_dysfunction_yes_no" class="css-radio">
                                            <label for="erectile_dysfunction_yes_no" class="css-label">No</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>Which medications have you been treated with?</h4>
                                    <ul class="flex-check">
                                        @if($getTreatWith)
                                            @foreach($getTreatWith as $treatedWith)
                                                <li>
                                                    <input type="radio" name="treated_with"
                                                           value="{{$treatedWith['value']}}"
                                                           {{ !empty($patient) && $patient->treated_with == $treatedWith['value'] ? 'checked' : ''}}
                                                           id="{{$treatedWith['key']}}" class="css-radio">
                                                    <label for="{{$treatedWith['key']}}"
                                                           class="css-label">{{$treatedWith['label']}}</label>
                                                </li>
                                            @endforeach
                                        @endif

                                    </ul>
                                </div>
                            </div>
                            <div class="gap-40">
                                <div class="checkbox-area">
                                    <h4>Over the past 6 months, how do you rate your confidence that you could keep an
                                        erection? </h4>
                                    <ul class="flex-check">
                                        @if($getConfidenceRate)
                                            @foreach($getConfidenceRate as $confidence)
                                                <li>
                                                    <input type="radio" name="confidence_rate"
                                                           value="{{$confidence['value']}}" id="{{$confidence['key']}}"
                                                           {{ !empty($patient) && $patient->confidence_rate == $confidence['value'] ? 'checked' : ''}}
                                                           class="css-radio">
                                                    <label for="{{$confidence['key']}}"
                                                           class="css-label">{{$confidence['label']}}</label>
                                                </li>
                                            @endforeach
                                        @endif

                                    </ul>
                                </div>
                            </div>
                            <div class="gap-60">
                                <div class="checkbox-area">
                                    <h4>Over the past 6 months, when you had erections with sexual stimulation, how
                                        often were your erections hard enough for penetration (entering your
                                        partner)?</h4>
                                    <ul class="flex-check">
                                        @if($getSexualStimulation)
                                            @foreach($getSexualStimulation as $sexualStimulation)
                                                <li>
                                                    <input type="radio" name="sexual_stimulation"
                                                           value="{{$sexualStimulation['value']}}"
                                                           {{ !empty($patient) && $patient->sexual_stimulation == $sexualStimulation['value'] ? 'checked' : ''}}
                                                           id="{{$sexualStimulation['key']}}" class="css-radio">
                                                    <label for="{{$sexualStimulation['key']}}"
                                                           class="css-label">{{$sexualStimulation['label']}}</label>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="gap-60">
                                <div class="checkbox-area">
                                    <h4>Over the past 6 months, during sexual intercourse, how often were you able to
                                        maintain your erection after you had penetrated (entered) your partner?</h4>
                                    <ul class="flex-check">
                                        @if($getSexualStimulation)
                                            @foreach($getSexualStimulation as $sexualStimulation)
                                                <li>
                                                    <input type="radio" name="sexual_stimulation_1"
                                                           value="{{$sexualStimulation['value']}}"
                                                           {{ !empty($patient) && $patient->sexual_stimulation_1 == $sexualStimulation['value'] ? 'checked' : ''}}
                                                           id="sexual_stimulation_1_{{$sexualStimulation['key']}}"
                                                           class="css-radio">
                                                    <label for="sexual_stimulation_1_{{$sexualStimulation['key']}}"
                                                           class="css-label">{{$sexualStimulation['label']}}</label>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="gap-60">
                                <div class="checkbox-area">
                                    <h4>Over the past 6 months, during sexual intercourse, how difficult was it to
                                        maintain your erection to completion of intercourse?</h4>
                                    <ul class="flex-check-five">
                                        @if($getSexualDificult)
                                            @foreach($getSexualDificult as $sexualDificult)
                                                <li>
                                                    <input type="radio" name="sexual_dificult"
                                                           value="{{$sexualDificult['value']}}"
                                                           {{ !empty($patient) && $patient->sexual_dificult == $sexualDificult['value'] ? 'checked' : ''}}
                                                           id="{{$sexualDificult['key']}}" class="css-radio">
                                                    <label for="{{$sexualDificult['key']}}"
                                                           class="css-label">{{$sexualDificult['label']}}</label>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="gap-60">
                                <div class="checkbox-area">
                                    <h4>Over the past 6 months, when you attempted sexual intercourse, how often was it
                                        satisfactory for you?
                                    </h4>
                                    <ul class="flex-check">
                                        @if($getSexualStimulation)
                                            @foreach($getSexualStimulation as $sexualStimulation)
                                                <li>
                                                    <input type="radio" name="sexual_stimulation_2"
                                                           value="{{$sexualStimulation['value']}}"
                                                           {{ !empty($patient) && $patient->sexual_stimulation_2 == $sexualStimulation['value'] ? 'checked' : ''}}
                                                           id="sexual_stimulation_2_{{$sexualStimulation['key']}}"
                                                           class="css-radio">
                                                    <label for="sexual_stimulation_2_{{$sexualStimulation['key']}}"
                                                           class="css-label">{{$sexualStimulation['label']}}</label>
                                                </li>
                                            @endforeach
                                        @endif

                                    </ul>
                                </div>
                            </div>
                            <a href="{{route('step2')}}" class="btn-back">Back</a>
                            <button type="submit" class="btn-continue">Continue</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
