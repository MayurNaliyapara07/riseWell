@inject('baseHelper','App\Helpers\Frontend\Helper')
@extends('layouts.app')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @include('layouts.sub-header',[
            'title' => 'Survey Form',
            'directory'=>'master',
            'back' => 'patients'
        ])

        @if(count($surveyForm) > 0)
            @foreach($surveyForm as $key=>$value)
                    <?php
                    $getMedicationsConjunction = $baseHelper->getMedicationsConjunction();
                    $getCardiovascular = $baseHelper->getCardiovascular();
                    $getDiabetes = $baseHelper->getDiabetes();
                    $selectedConjunction = !empty($value->medication_conjunction) ? explode(',', $value->medication_conjunction) : '';
                    $selectedCardiovascular = !empty($value->cardiovascular) ? explode(',', $value->cardiovascular) : '';
                    $selectedDiabetes = !empty($value->diabetes) ? explode(',', $value->diabetes) : '';
                    ?>
                <div class="container-fluid">
                    <div class="card card-custom card-collapsed" data-card="true" id="kt_card_4">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Form {{$key+1}}</h3>
                            </div>
                            <div class="card-toolbar">
                                <a href="#" class="btn btn-icon btn-sm btn-primary mr-1" data-card-tool="toggle">
                                    <i class="ki ki-arrow-down icon-nm"></i>
                                </a>
                                <button onclick="copyToClipboard({{$value->patients_id}})"
                                        class="btn btn-icon btn-sm btn-success mr-1">
                                    <i class="ki ki-copy icon-nm"></i>
                                </button>

                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-striped- table-bordered">
                                    <tr class="datatable-row-detail">
                                        <td class="datatable-detail" colspan="13">
                                            <table>
                                                <tr class="datatable-row">
                                                    <td>
                                                        <span
                                                            style="width: 300px;">What's your legal first name ?</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value)?$value->first_name:''}}</span>
                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">What's your legal last name ?</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value)?$value->last_name:''}}</span>
                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">Email Address</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{ !empty($value) ? $value->email:''}}</span>
                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">Phone Number</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{ !empty($value) ? $value->phone_no:''}}</span>
                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                <span style="width: 300px;">What time of day is best to call if a doctor has any
                                                    <br>questions regarding your medical intake form?</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <b>Weekday:</b><span
                                                            style="width: 300px;"> {{ !empty($value) ? $value->weekday:''}}</span><br>
                                                        <b> Weekend:</b><span
                                                            style="width: 300px;"> {{ !empty($value) ? $value->weekend:''}}</span><br>
                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">What is your biological sex?</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        @if(!empty($value->gender == 'M'))
                                                            <span style="width: 300px;">Male</span>
                                                        @else
                                                            <span style="width: 300px;">FeMale</span>
                                                        @endif

                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">Height</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{ !empty($value) ? $value->height:''}}</span>
                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">Weight</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{ !empty($value) ? $value->weight:''}}</span>
                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">Birthday</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{ !empty($value) ? date('d-m-Y',strtotime($value->dob)):''}}</span>
                                                    </td>
                                                </tr>

                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">Have you had your vitals tested by a medical practitioner in the past 3 years?</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) && $value->vitals == '1' ? 'Yes' : 'No'}}</span>
                                                    </td>
                                                </tr>

                                                <tr class="datatable-row">
                                                    <td>
                                                        <span
                                                            style="width: 300px;">Were there any medical problems?</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) && $value->medical_problems == '1' ? 'Yes' : 'No'}}</span>
                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                        <span
                                                            style="width: 300px;">What were the medical problem(s)?</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) ? $value->medical_problem : ''}}</span>
                                                    </td>
                                                </tr>


                                                <tr class="datatable-row">
                                                    <td>
                                                <span style="width: 300px;">How is your blood pressure?
                                                </span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) ? $value->blood_pressure : ''}}</span>
                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                <span style="width: 300px;">Please select your blood pressure medication.
                                                </span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) ? $value->blood_pressure_medication : ''}}</span>
                                                    </td>
                                                </tr>

                                                <tr class="datatable-row">
                                                    <td>
                                                <span style="width: 300px;">Enter other medications below
                                                </span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) ? $value->medications : ''}}</span>
                                                    </td>
                                                </tr>

                                                <tr class="datatable-row">
                                                    <td>
                                                <span style="width: 300px;">Death can result if ED medications are used in conjunction with nitrates or other medications. Please be accurate. | use or have used:
                                                </span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        @foreach($getMedicationsConjunction as $key=>$medicationsConjunction)
                                                            <span style="width: 300px;">
                                                                @if(!empty($selectedConjunction) && in_array($medicationsConjunction['value'],$selectedConjunction))
                                                                    <i class="fas fa-dot-circle"></i> {{$medicationsConjunction['label']}} <br>
                                                                @endif
                                                            </span>
                                                        @endforeach
                                                    </td>
                                                </tr>

                                                <tr class="datatable-row">
                                                    <td>
                                                <span style="width: 300px;">Death can result if ED meds are used in conjunction with recreational drugs. Have you, or are you currently using any of the following recreational drugs?
                                                </span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) ?$value->recreational_drugs: ''}}</span>
                                                    </td>
                                                </tr>


                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">Do you take any over the counter or prescription medications?</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) && $value->medication_prescription == '1' ? 'Yes' : 'No'}}</span>
                                                    </td>
                                                </tr>

                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">Which condtion or conditions do they treat ? </span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) ? $value->treat : ''}}</span>
                                                    </td>
                                                </tr>

                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">Enter others conditions below</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) ? $value->other_conditions : ''}}</span>
                                                    </td>
                                                </tr>

                                                <tr class="datatable-row">
                                                    <td>
                                                <span style="width: 300px;">Please select your cardiovascular disease (heart) (excluding blood pressure) medication:
                                                </span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        @foreach($getCardiovascular as $key=>$cardiovascular)
                                                            <span style="width: 300px;">
                                                                @if(!empty($selectedCardiovascular) && in_array($cardiovascular['value'],$selectedCardiovascular))
                                                                    <i class="fas fa-dot-circle"></i> {{$cardiovascular['label']}} <br>
                                                                @endif
                                                            </span>
                                                        @endforeach

                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">Please select your diabetes medication:</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        @foreach($getDiabetes as $key=>$diabetes)
                                                            <span style="width: 300px;">
                                                                @if(!empty($selectedDiabetes) && in_array($diabetes['value'],$selectedDiabetes))
                                                                    <i class="fas fa-dot-circle"></i> {{$diabetes['label']}} <br>
                                                                @endif
                                                            </span>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">What is your diabetes level?</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) ? $value->diabetes_level : ''}}</span>
                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">Please select your thyroid medication:</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) ? $value->thyroid : ''}}</span>
                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                <span style="width: 300px;">Please select your cholesterol medication:
                                                </span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) ? $value->cholesterol : ''}}</span>
                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                <span style="width: 300px;">Please select your lung condition (breathing) medication:
                                                </span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) ? $value->breathing : ''}}</span>
                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">Please select your gastroesophageal reflux medication:</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) ? $value->gastroesophageal : ''}}</span>
                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">Please select your attention deficit hyperactivity disorder (ADHD) medication:</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) ? $value->hyperactivity : ''}}</span>
                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">Do you have any medication allergies?</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) && $value->allergies == "1" ? 'Yes': 'No'}}</span>
                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">Please list your medication allergies.</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) ? $value->allergies_list : ''}}</span>
                                                    </td>
                                                </tr>

                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">PIs there anything else medically relevant we should know about you?</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) ? $value->pi : ''}}</span>
                                                    </td>
                                                </tr>


                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">Have you ever suffered or been treated for Erectile Dysfunction or tried any ED medications?</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) && $value->erectile_dysfunction == "1" ? 'Yes': 'No'}}</span>
                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">Which medications have you been treated with?</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) ? $value->treated_with : ' '}}</span>
                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">Over the past 6 months, how do you rate your confidence that you could keep an erection?</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) ? $value->confidence_rate : ' '}}</span>
                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">Over the past 6 months, when you had erections with sexual stimulation, how often were your erections hard enough for penetration (entering your partner)?</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) ? $value->sexual_stimulation : ' '}}</span>
                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">Over the past 6 months, during sexual intercourse, how often were you able to maintain your erection after you had penetrated (entered) your partner?</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) ? $value->sexual_stimulation: ' '}}</span>
                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                        <span style="width: 300px;">Over the past 6 months, during sexual intercourse, how difficult was it to maintain your erection to completion of intercourse?</span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) ? $value->sexual_stimulation_1: ' '}}</span>
                                                    </td>
                                                </tr>
                                                <tr class="datatable-row">
                                                    <td>
                                                <span style="width: 300px;">Over the past 6 months, when you attempted sexual intercourse, how often was it satisfactory for you?
                                                </span>
                                                    </td>
                                                    <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value) ? $value->sexual_dificult: ' '}}</span>
                                                    </td>
                                                </tr>


                                            </table>
                                        </td>
                                    </tr>

                                </table>
                            </div>

                        </div>
                    </div>

                </div>
                <br>
            @endforeach
        @else
            <div class="container-fluid">
                <div class="card card-custom card-collapsed" data-card="true" id="kt_card_4">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-label text-center">Survey From  not found ! </span>
                        </div>
                    </div>
                </div>
            </div>

        @endif


    </div>
@endsection
@push('scripts')
    <script>
        // This card is lazy initialized using data-card="true" attribute. You can access to the card object as shown below and override its behavior
        var card = new KTCard('kt_card_4');


        function copyToClipboard(patientId) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url('get-unique-url') }}',
                 type: 'POST',
                 data: {
                     patients_id: patientId
                 },
                 success: function (response) {
                     if(response.data){
                         let url = response.data;
                         const Toast = Swal.mixin({
                             toast: true,
                             position: 'top-end',
                             showConfirmButton: false,
                             timer: 3000,
                             timerProgressBar: true,
                             didOpen: (toast) => {
                                 toast.addEventListener('mouseenter', Swal.stopTimer)
                                 toast.addEventListener('mouseleave', Swal.resumeTimer)
                             }
                         })
                         try {
                             navigator.clipboard.writeText(url);

                             Toast.fire({
                                 icon: 'success',
                                 title: 'URL copied! '
                             })
                         } catch (err) {
                             Toast.fire({
                                 icon: 'error',
                                 title: 'Failed to copy!'
                             })

                         }
                     }
                 }
             });
         }
    </script>
@endpush



