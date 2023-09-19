@inject('baseHelper','App\Helpers\Frontend\Helper')
@extends('layouts.app')
@section('content')
    <?php
    $selectedTab = session('current_tab');
    $visitNoteTab = '';
    $medicationTab = '';
    $lbsTab = '';
    $memberInfoTab = '';
    if(!empty($selectedTab) && $selectedTab == 'visit_note'){
        $visitNoteTab = 'active';
    }
    elseif ($selectedTab == 'medications'){
        $medicationTab = 'active';
    }
    elseif ($selectedTab == 'labs'){
        $lbsTab = 'active';
    }
    else{
        $memberInfoTab = 'active';
    }

    $default_country_code = $baseHelper->default_country_code();
    $default_country_phonecode = $baseHelper->default_country_phonecode();
    $phoneCode = !empty($patientDetails->country_code) ? $patientDetails->country_code : $default_country_phonecode;
    $phoneNo = isset($patientDetails->phone_no) ? "+" . $phoneCode . $patientDetails->phone_no : '';

    ?>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @include('layouts.sub-header',[
           'title' => 'Patients Profile',
           'directory'=>'master',
            'back' => 'patients'

       ])
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--Begin::Card-->
                <div class="card card-custom gutter-b">
                    <!--Begin::Body-->
                    <div class="card-body">
                        <div class="d-flex">

                            <!--begin::Pic-->
                            <div class="flex-shrink-0 mr-7">
                                <div class="symbol symbol-50 symbol-lg-120">
                                    <img src="{{ $patientDetails->getFileUrl($patientDetails->image)}}"
                                         alt="image">
                                </div>
                            </div>
                            <!--end::Pic-->
                            <!--begin: Info-->
                            <div class="flex-grow-1">
                                <!--begin::Title-->
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <!--begin::User-->
                                    <div class="mr-3">
                                        <div class="d-flex align-items-center mr-3">
                                            <!--begin::Name-->

                                            <a href="#" class="d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold mr-3">{{!empty($patientDetails->patients_name)?$patientDetails->patients_name:''}}</a>
                                            <!--end::Name-->

                                            <span
                                                class="label label-light-primary   label-inline font-weight-bolder mr-1">Member ID:{{!empty($patientDetails->member_id)?$patientDetails->member_id:''}}</span>


                                            @if(!empty($patientDetails->status) && $patientDetails->status==1)
                                                <span
                                                    class="label label-light-success label-inline font-weight-bolder mr-1">Active</span>
                                            @else
                                                <span
                                                    class="label label-light-danger label-inline font-weight-bolder mr-1">In-Active</span>
                                            @endif



                                        </div>
                                        <!--begin::Contacts-->
                                        <div class="d-flex flex-wrap my-2">
                                            <a href="#" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
															<span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-notification.svg-->
																<svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
																	<g stroke="none" stroke-width="1" fill="none"
                                                                       fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24"/>
																		<path
                                                                            d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z"
                                                                            fill="#000000"/>
																		<circle fill="#000000" opacity="0.3" cx="19.5"
                                                                                cy="17.5" r="2.5"/>
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>{{!empty($patientDetails->email)?$patientDetails->email:''}}
                                            </a>
                                            <a href="#"
                                               class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
															<span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
																<!--begin::Svg Icon | path:assets/media/svg/icons/General/Lock.svg-->
																<svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
																	<g stroke="none" stroke-width="1" fill="none"
                                                                       fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path
            d="M7.13888889,4 L7.13888889,19 L16.8611111,19 L16.8611111,4 L7.13888889,4 Z M7.83333333,1 L16.1666667,1 C17.5729473,1 18.25,1.98121694 18.25,3.5 L18.25,20.5 C18.25,22.0187831 17.5729473,23 16.1666667,23 L7.83333333,23 C6.42705272,23 5.75,22.0187831 5.75,20.5 L5.75,3.5 C5.75,1.98121694 6.42705272,1 7.83333333,1 Z"
            fill="#000000" fill-rule="nonzero"/>
        <polygon fill="#000000" opacity="0.3" points="7 4 7 19 17 19 17 4"/>
        <circle fill="#000000" cx="12" cy="21" r="1"/>
    </g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>{{!empty($patientDetails->phone_no)?$patientDetails->phone_no:''}}
                                            </a>
                                            <a href="#" class="text-muted text-hover-primary font-weight-bold">
															<span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Map/Marker2.svg-->
																<svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
																	<g stroke="none" stroke-width="1" fill="none"
                                                                       fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24"/>
																		<path
                                                                            d="M9.82829464,16.6565893 C7.02541569,15.7427556 5,13.1079084 5,10 C5,6.13400675 8.13400675,3 12,3 C15.8659932,3 19,6.13400675 19,10 C19,13.1079084 16.9745843,15.7427556 14.1717054,16.6565893 L12,21 L9.82829464,16.6565893 Z M12,12 C13.1045695,12 14,11.1045695 14,10 C14,8.8954305 13.1045695,8 12,8 C10.8954305,8 10,8.8954305 10,10 C10,11.1045695 10.8954305,12 12,12 Z"
                                                                            fill="#000000"/>
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>{{!empty($patientDetails->address)?$patientDetails->address:''}}
                                            </a>
                                        </div>
                                        <!--end::Contacts-->
                                    </div>
                                    <!--begin::User-->
                                    <!--begin::Actions-->

                                    <!--end::Actions-->
                                </div>
                                <!--end::Title-->
                                <!--begin::Content-->
                                <div class="d-flex align-items-center flex-wrap justify-content-between">
                                    <!--begin::Description-->
                                    <div class="flex-grow-1 text-muted-50 py-2 py-lg-2 mr-5">I distinguish three main
                                        text objectives could be merely to inform people.
                                        <br/>A second could be persuade people.
                                    </div>
                                    <!--end::Progress-->
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Info-->
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--End::Card-->
                <!--begin::Card-->
                <div class="card card-custom">
                    <!--Begin::Header-->
                    <div class="card-header card-header-tabs-line">
                        <div class="card-toolbar">
                            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x"
                                role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{$memberInfoTab}}" data-toggle="tab" href="#tab_1">
														<span class="nav-icon mr-2">
															<span class="svg-icon mr-3">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Chat-check.svg-->
																<svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
																	<g stroke="none" stroke-width="1" fill="none"
                                                                       fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24"/>
																		<path
                                                                            d="M4.875,20.75 C4.63541667,20.75 4.39583333,20.6541667 4.20416667,20.4625 L2.2875,18.5458333 C1.90416667,18.1625 1.90416667,17.5875 2.2875,17.2041667 C2.67083333,16.8208333 3.29375,16.8208333 3.62916667,17.2041667 L4.875,18.45 L8.0375,15.2875 C8.42083333,14.9041667 8.99583333,14.9041667 9.37916667,15.2875 C9.7625,15.6708333 9.7625,16.2458333 9.37916667,16.6291667 L5.54583333,20.4625 C5.35416667,20.6541667 5.11458333,20.75 4.875,20.75 Z"
                                                                            fill="#000000" fill-rule="nonzero"
                                                                            opacity="0.3"/>
																		<path
                                                                            d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z"
                                                                            fill="#000000"/>
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
														</span>
                                        <span class="nav-text font-weight-bold">Member Info</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{$visitNoteTab}}" data-toggle="tab" href="#tab_2">
														<span class="nav-icon mr-2">
															<span class="svg-icon mr-3">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Devices/Display1.svg-->
																<svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
																	  <g stroke="none" stroke-width="1" fill="none"
                                                                         fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"/>
        <circle fill="#000000" opacity="0.3" cx="15" cy="17" r="5"/>
        <circle fill="#000000" opacity="0.3" cx="9" cy="17" r="5"/>
        <circle fill="#000000" opacity="0.3" cx="7" cy="11" r="5"/>
        <circle fill="#000000" opacity="0.3" cx="17" cy="11" r="5"/>
        <circle fill="#000000" opacity="0.3" cx="12" cy="7" r="5"/>
    </g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
														</span>
                                        <span class="nav-text font-weight-bold">Visit</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{$medicationTab}}" data-toggle="tab" href="#tab_3">
														<span class="nav-icon mr-2">
															<span class="svg-icon mr-3">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Devices/Display1.svg-->
																<svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
																	  <g stroke="none" stroke-width="1" fill="none"
                                                                         fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"/>
        <circle fill="#000000" opacity="0.3" cx="15" cy="17" r="5"/>
        <circle fill="#000000" opacity="0.3" cx="9" cy="17" r="5"/>
        <circle fill="#000000" opacity="0.3" cx="7" cy="11" r="5"/>
        <circle fill="#000000" opacity="0.3" cx="17" cy="11" r="5"/>
        <circle fill="#000000" opacity="0.3" cx="12" cy="7" r="5"/>
    </g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
														</span>
                                        <span class="nav-text font-weight-bold">Medication</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{$lbsTab}}" data-toggle="tab" href="#tab_4">
														<span class="nav-icon mr-2">
															<span class="svg-icon mr-3">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Home/Globe.svg-->
																<svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
																	<g stroke="none" stroke-width="1" fill="none"
                                                                       fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24"/>
																		<path
                                                                            d="M13,18.9450712 L13,20 L14,20 C15.1045695,20 16,20.8954305 16,22 L8,22 C8,20.8954305 8.8954305,20 10,20 L11,20 L11,18.9448245 C9.02872877,18.7261967 7.20827378,17.866394 5.79372555,16.5182701 L4.73856106,17.6741866 C4.36621808,18.0820826 3.73370941,18.110904 3.32581341,17.7385611 C2.9179174,17.3662181 2.88909597,16.7337094 3.26143894,16.3258134 L5.04940685,14.367122 C5.46150313,13.9156769 6.17860937,13.9363085 6.56406875,14.4106998 C7.88623094,16.037907 9.86320756,17 12,17 C15.8659932,17 19,13.8659932 19,10 C19,7.73468744 17.9175842,5.65198725 16.1214335,4.34123851 C15.6753081,4.01567657 15.5775721,3.39010038 15.903134,2.94397499 C16.228696,2.49784959 16.8542722,2.4001136 17.3003976,2.72567554 C19.6071362,4.40902808 21,7.08906798 21,10 C21,14.6325537 17.4999505,18.4476269 13,18.9450712 Z"
                                                                            fill="#000000" fill-rule="nonzero"/>
																		<circle fill="#000000" opacity="0.3" cx="12"
                                                                                cy="10" r="6"/>
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
														</span>
                                        <span class="nav-text font-weight-bold">Labs</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab_5"
                                       onclick="chatHistory({{$patientDetails->patients_id}})">
														<span class="nav-icon mr-2">
															<span class="svg-icon mr-3">
																<!--begin::Svg Icon | path:assets/media/svg/icons/General/Notification2.svg-->
																<svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
																	 <g stroke="none" stroke-width="1" fill="none"
                                                                        fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <polygon fill="#000000" opacity="0.3" points="5 15 3 21.5 9.5 19.5"/>
        <path
            d="M13.5,21 C8.25329488,21 4,16.7467051 4,11.5 C4,6.25329488 8.25329488,2 13.5,2 C18.7467051,2 23,6.25329488 23,11.5 C23,16.7467051 18.7467051,21 13.5,21 Z M8.5,13 C9.32842712,13 10,12.3284271 10,11.5 C10,10.6715729 9.32842712,10 8.5,10 C7.67157288,10 7,10.6715729 7,11.5 C7,12.3284271 7.67157288,13 8.5,13 Z M13.5,13 C14.3284271,13 15,12.3284271 15,11.5 C15,10.6715729 14.3284271,10 13.5,10 C12.6715729,10 12,10.6715729 12,11.5 C12,12.3284271 12.6715729,13 13.5,13 Z M18.5,13 C19.3284271,13 20,12.3284271 20,11.5 C20,10.6715729 19.3284271,10 18.5,10 C17.6715729,10 17,10.6715729 17,11.5 C17,12.3284271 17.6715729,13 18.5,13 Z"
            fill="#000000"/>
    </g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
														</span>
                                        <span class="nav-text font-weight-bold">Chat</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab_6">
														<span class="nav-icon mr-2">
															<span class="svg-icon mr-3">
																<!--begin::Svg Icon | path:assets/media/svg/icons/General/Notification2.svg-->
																<svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
																	 <g stroke="none" stroke-width="1" fill="none"
                                                                        fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M5,6 L19,6 C19.5522847,6 20,6.44771525 20,7 L20,17 L4,17 L4,7 C4,6.44771525 4.44771525,6 5,6 Z"
              fill="#000000"/>
        <rect fill="#000000" opacity="0.3" x="1" y="18" width="22" height="1" rx="0.5"/>
    </g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
														</span>
                                        <span class="nav-text font-weight-bold">Order History</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab_7">
														<span class="nav-icon mr-2">
															<span class="svg-icon mr-3">
																<!--begin::Svg Icon | path:assets/media/svg/icons/General/Notification2.svg-->
																<svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
																	<g stroke="none" stroke-width="1" fill="none"
                                                                       fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path
            d="M4,9.67471899 L10.880262,13.6470401 C10.9543486,13.689814 11.0320333,13.7207107 11.1111111,13.740321 L11.1111111,21.4444444 L4.49070127,17.526473 C4.18655139,17.3464765 4,17.0193034 4,16.6658832 L4,9.67471899 Z M20,9.56911707 L20,16.6658832 C20,17.0193034 19.8134486,17.3464765 19.5092987,17.526473 L12.8888889,21.4444444 L12.8888889,13.6728275 C12.9050191,13.6647696 12.9210067,13.6561758 12.9368301,13.6470401 L20,9.56911707 Z"
            fill="#000000"/>
        <path
            d="M4.21611835,7.74669402 C4.30015839,7.64056877 4.40623188,7.55087574 4.5299008,7.48500698 L11.5299008,3.75665466 C11.8237589,3.60013944 12.1762411,3.60013944 12.4700992,3.75665466 L19.4700992,7.48500698 C19.5654307,7.53578262 19.6503066,7.60071528 19.7226939,7.67641889 L12.0479413,12.1074394 C11.9974761,12.1365754 11.9509488,12.1699127 11.9085461,12.2067543 C11.8661433,12.1699127 11.819616,12.1365754 11.7691509,12.1074394 L4.21611835,7.74669402 Z"
            fill="#000000" opacity="0.3"/>
    </g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
														</span>
                                        <span class="nav-text font-weight-bold">Order</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab_8">
														<span class="nav-icon mr-2">
															<span class="svg-icon mr-3">
																<!--begin::Svg Icon | path:assets/media/svg/icons/General/Notification2.svg-->
																<svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
																	<g stroke="none" stroke-width="1" fill="none"
                                                                       fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path
            d="M10.9630156,7.5 L11.0475062,7.5 C11.3043819,7.5 11.5194647,7.69464724 11.5450248,7.95024814 L12,12.5 L15.2480695,14.3560397 C15.403857,14.4450611 15.5,14.6107328 15.5,14.7901613 L15.5,15 C15.5,15.2109164 15.3290185,15.3818979 15.1181021,15.3818979 C15.0841582,15.3818979 15.0503659,15.3773725 15.0176181,15.3684413 L10.3986612,14.1087258 C10.1672824,14.0456225 10.0132986,13.8271186 10.0316926,13.5879956 L10.4644883,7.96165175 C10.4845267,7.70115317 10.7017474,7.5 10.9630156,7.5 Z"
            fill="#000000"/>
        <path
            d="M7.38979581,2.8349582 C8.65216735,2.29743306 10.0413491,2 11.5,2 C17.2989899,2 22,6.70101013 22,12.5 C22,18.2989899 17.2989899,23 11.5,23 C5.70101013,23 1,18.2989899 1,12.5 C1,11.5151324 1.13559454,10.5619345 1.38913364,9.65805651 L3.31481075,10.1982117 C3.10672013,10.940064 3,11.7119264 3,12.5 C3,17.1944204 6.80557963,21 11.5,21 C16.1944204,21 20,17.1944204 20,12.5 C20,7.80557963 16.1944204,4 11.5,4 C10.54876,4 9.62236069,4.15592757 8.74872191,4.45446326 L9.93948308,5.87355717 C10.0088058,5.95617272 10.0495583,6.05898805 10.05566,6.16666224 C10.0712834,6.4423623 9.86044965,6.67852665 9.5847496,6.69415008 L4.71777931,6.96995273 C4.66931162,6.97269931 4.62070229,6.96837279 4.57348157,6.95710938 C4.30487471,6.89303938 4.13906482,6.62335149 4.20313482,6.35474463 L5.33163823,1.62361064 C5.35654118,1.51920756 5.41437908,1.4255891 5.49660017,1.35659741 C5.7081375,1.17909652 6.0235153,1.2066885 6.2010162,1.41822583 L7.38979581,2.8349582 Z"
            fill="#000000" opacity="0.3"/>
    </g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
														</span>
                                        <span class="nav-text font-weight-bold">Schedule</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab_9"
                                       onclick="getTimeLine({{$patientDetails->patients_id}})">
														<span class="nav-icon mr-2">
															<span class="svg-icon mr-3">
																<!--begin::Svg Icon | path:assets/media/svg/icons/General/Notification2.svg-->
																<svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
																	<g stroke="none" stroke-width="1" fill="none"
                                                                       fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path
            d="M10.9630156,7.5 L11.0475062,7.5 C11.3043819,7.5 11.5194647,7.69464724 11.5450248,7.95024814 L12,12.5 L15.2480695,14.3560397 C15.403857,14.4450611 15.5,14.6107328 15.5,14.7901613 L15.5,15 C15.5,15.2109164 15.3290185,15.3818979 15.1181021,15.3818979 C15.0841582,15.3818979 15.0503659,15.3773725 15.0176181,15.3684413 L10.3986612,14.1087258 C10.1672824,14.0456225 10.0132986,13.8271186 10.0316926,13.5879956 L10.4644883,7.96165175 C10.4845267,7.70115317 10.7017474,7.5 10.9630156,7.5 Z"
            fill="#000000"/>
        <path
            d="M7.38979581,2.8349582 C8.65216735,2.29743306 10.0413491,2 11.5,2 C17.2989899,2 22,6.70101013 22,12.5 C22,18.2989899 17.2989899,23 11.5,23 C5.70101013,23 1,18.2989899 1,12.5 C1,11.5151324 1.13559454,10.5619345 1.38913364,9.65805651 L3.31481075,10.1982117 C3.10672013,10.940064 3,11.7119264 3,12.5 C3,17.1944204 6.80557963,21 11.5,21 C16.1944204,21 20,17.1944204 20,12.5 C20,7.80557963 16.1944204,4 11.5,4 C10.54876,4 9.62236069,4.15592757 8.74872191,4.45446326 L9.93948308,5.87355717 C10.0088058,5.95617272 10.0495583,6.05898805 10.05566,6.16666224 C10.0712834,6.4423623 9.86044965,6.67852665 9.5847496,6.69415008 L4.71777931,6.96995273 C4.66931162,6.97269931 4.62070229,6.96837279 4.57348157,6.95710938 C4.30487471,6.89303938 4.13906482,6.62335149 4.20313482,6.35474463 L5.33163823,1.62361064 C5.35654118,1.51920756 5.41437908,1.4255891 5.49660017,1.35659741 C5.7081375,1.17909652 6.0235153,1.2066885 6.2010162,1.41822583 L7.38979581,2.8349582 Z"
            fill="#000000" opacity="0.3"/>
    </g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
														</span>
                                        <span class="nav-text font-weight-bold">TimeLine</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab_10">
										<span class="nav-icon mr-2">
                                            <span class="svg-icon mr-3">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Devices/Display1.svg-->
																<svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
																	  <g stroke="none" stroke-width="1" fill="none"
                                                                         fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"/>
        <circle fill="#000000" opacity="0.3" cx="15" cy="17" r="5"/>
        <circle fill="#000000" opacity="0.3" cx="9" cy="17" r="5"/>
        <circle fill="#000000" opacity="0.3" cx="7" cy="11" r="5"/>
        <circle fill="#000000" opacity="0.3" cx="17" cy="11" r="5"/>
        <circle fill="#000000" opacity="0.3" cx="12" cy="7" r="5"/>
    </g>
																</svg>
                                                <!--end::Svg Icon-->
															</span>
                                        </span>
                                        <span class="nav-text font-weight-bold">Form Survey</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content pt-5">
                            <div class="tab-pane {{$memberInfoTab}}" id="tab_1" role="tabpanel">
                                <form
                                    action="{{ isset($patientDetails) ? route('patients.update',$patientDetails->patients_id):''}}"
                                    method="post" enctype="multipart/form-data" class="ajax-form">
                                    @csrf
                                    @if(isset($patientDetails))
                                        @method('PUT')
                                    @endif
                                    <!--begin::Heading-->
                                    <div class="row">
                                        <div class="col-lg-9 col-xl-6 offset-xl-3">
                                            <h3 class="font-size-h6 mb-5">Member Info:</h3>
                                        </div>
                                    </div>

                                    <input name="current_url" type="hidden" placeholder="" value="profile"/>


                                    <!--end::Heading-->
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">Image</label>
                                        <div class="col-lg-9 col-xl-9">


                                            <div class="image-input image-input-outline" id="kt_image_1">
                                                <div class="image-input-wrapper"
                                                     style="background-image: url('{{ $patientDetails->getFileUrl($patientDetails->image) }}')"></div>
                                                <label
                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                    data-action="change" data-toggle="tooltip" title=""
                                                    data-original-title="Change avatar">
                                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                                    <input type="file" name="image"
                                                           accept=".png, .jpg, .jpeg"/>
                                                    <input type="hidden" name="image"/>
                                                </label>
                                                <span
                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                    data-action="cancel" data-toggle="tooltip"
                                                    title="Cancel avatar">
															<i class="ki ki-bold-close icon-xs text-muted"></i>
														</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">Member Id<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input disabled
                                                   class="form-control form-control-lg form-control-solid required"
                                                   data-msg-required="Member Id is required"
                                                   type="text" name="member_id" placeholder="Member Id"
                                                   value="{{!empty($patientDetails->member_id)?$patientDetails->member_id:''}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">First Name<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input class="form-control form-control-lg form-control-solid" type="text"
                                                   placeholder="First Name" name="first_name"
                                                   value="{{!empty($patientDetails->first_name)?$patientDetails->first_name:''}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">Last Name<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input class="form-control form-control-lg form-control-solid" type="text"
                                                   placeholder="Last Name" name="last_name"
                                                   value="{{!empty($patientDetails->last_name)?$patientDetails->last_name:''}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">DOB<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group date">
                                                <input type="text" name="dob" id="dob"
                                                       class="form-control form-control-lg form-control-solid required"
                                                       data-msg-required="Dob is required"
                                                       autocomplete="off"
                                                       placeholder="dd-mm-yyyy"
                                                       value="{{ !empty(old('dob'))?old('dob'):(!empty($patientDetails->dob)?date('d/m/Y',strtotime($patientDetails->dob)):date('d/m/Y')) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">Profile
                                            Claimed<span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group date">
                                                <input type="text" name="profile_claimed" id="profile_claimed"
                                                       class="form-control form-control-lg form-control-solid required"
                                                       data-msg-required="Profile Claimed is required"
                                                       autocomplete="off"
                                                       placeholder="dd-mm-yyyy"
                                                       value="{{ !empty(old('profile_claimed'))?old('profile_claimed'):(!empty($patientDetails->profile_claimed)?date('d/m/Y',strtotime($patientDetails->profile_claimed)):date('d/m/Y')) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">Gender<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <select class="form-control form-control-lg form-control-solid required"
                                                    data-msg-required="Gender is required" type="text" name="gender">
                                                <option value="">Select Gender</option>
                                                <option
                                                    value="M" {{(isset($patientDetails)&& $patientDetails->gender=='M')?'selected':old('M')}}>
                                                    Male
                                                </option>
                                                <option
                                                    value="F" {{(isset($patientDetails)&& $patientDetails->gender=='F')?'selected':old('F')}}>
                                                    FeMale
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">SSN</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input class="form-control form-control-lg form-control-solid" type="text"
                                                   name="ssn" placeholder="SSN"
                                                   value="{{!empty($patientDetails->ssn)?$patientDetails->ssn:''}}"/>
                                        </div>
                                    </div>

                                    <div class="separator separator-dashed my-10"></div>
                                    <!--begin::Heading-->
                                    <div class="row">
                                        <div class="col-lg-9 col-xl-6 offset-xl-3">
                                            <h3 class="font-size-h6 mb-5">Contact Info:</h3>
                                        </div>
                                    </div>
                                    <!--end::Heading-->
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">Contact Phone<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="hidden" id="country_code" name="country_code"
                                                   value="{{ !empty($patientDetails->country_code) ? $patientDetails->country_code: $default_country_phonecode  }}">


                                            <div class="input-group input-group-lg input-group-solid">
                                                <input type="text"
                                                       class="form-control form-control-lg form-control-solid required"
                                                       name="phone_no" id="phone_no"
                                                       data-msg-required="Phone no is required" data-rule-digits="true"
                                                       data-rule-minlength="8"
                                                       value="{{!empty($patientDetails->phone_no)?$patientDetails->phone_no:''}}"
                                                       placeholder="Phone"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">Email Address<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group input-group-lg input-group-solid">
                                                <div class="input-group-prepend">
																	<span class="input-group-text">
																		<i class="la la-at"></i>
																	</span>
                                                </div>
                                                <input type="text"
                                                       class="form-control form-control-lg form-control-solid required"
                                                       name="email"
                                                       data-msg-required="Email is required" data-rule-email="true"
                                                       value="{{!empty($patientDetails->email)?$patientDetails->email:''}}"
                                                       placeholder="Email"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-9 col-xl-6 offset-xl-3">
                                            <h3 class="font-size-h6 mb-5">Address Info:</h3>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">Address<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <textarea class="form-control form-control-lg form-control-solid required"
                                                      data-msg-required="Address is required" name="address"
                                                      placeholder="Address"
                                                      type="text">{{!empty($patientDetails->address)?$patientDetails->address:''}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">City<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input class="form-control form-control-lg form-control-solid required"
                                                   data-msg-required="City is required" type="text" name="city_name"
                                                   placeholder="City"
                                                   value="{{!empty($patientDetails->city_name)?$patientDetails->city_name:''}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">State<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group input-group-lg input-group-solid">
                                                <select name="state_id" style="width: 100% !important;"
                                                        class="form-control form-control-lg form-control-solid state-select2">
                                                    @if(!empty($patientDetails))
                                                        <option
                                                            value="{{(isset($patientDetails))?$patientDetails->state_id:(old('state_id')?old('state_id'):0)}}">
                                                            {{ isset($getStatName->state_name)?$getStatName->state_name:''}}
                                                        </option>
                                                    @endif
                                                </select>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">Zip Code<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">

                                            <div class="input-group input-group-lg input-group-solid">
                                                <input type="text"
                                                       class="form-control form-control-lg form-control-solid required"
                                                       data-msg-required="Zip is required" name="zip"
                                                       placeholder="Zip Code"
                                                       value="{{!empty($patientDetails->zip)?$patientDetails->zip:''}}"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-9 col-xl-6 offset-xl-3">
                                            <h3 class="font-size-h6 mb-5">Billing Address Info:</h3>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label"> Address 1</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <textarea name="billing_address_1"
                                                      class="form-control form-control-lg form-control-solid"
                                                      placeholder="Address"
                                                      type="text">{{!empty($patientDetails->billing_address_1)?$patientDetails->billing_address_1:''}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label"> Address 2</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <textarea name="billing_address_2"
                                                      class="form-control form-control-lg form-control-solid"
                                                      placeholder="Address"
                                                      type="text">{{!empty($patientDetails->billing_address_2)?$patientDetails->billing_address_2:''}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label"> Address 3</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <textarea name="billing_address_3"
                                                      class="form-control form-control-lg form-control-solid"
                                                      placeholder="Address"
                                                      type="text">{{!empty($patientDetails->billing_address_3)?$patientDetails->billing_address_3:''}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">City</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input name="billing_city_name"
                                                   class="form-control form-control-lg form-control-solid" type="text"
                                                   placeholder="City"
                                                   value="{{!empty($patientDetails->billing_city_name)?$patientDetails->billing_city_name:''}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">State</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group input-group-lg input-group-solid">
                                                <select name="billing_state_id" style="width: 100% !important;"
                                                        class="form-control form-control-lg form-control-solid state-select2">
                                                    @if(!empty($patientDetails))
                                                        <option
                                                            value="{{(isset($patientDetails))?$patientDetails->billing_state_id:(old('billing_state_id')?old('billing_state_id'):0)}}">
                                                            {{ isset($getBillingStatName->state_name)?$getBillingStatName->state_name:''}}
                                                        </option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">Zip Code</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group input-group-lg input-group-solid">
                                                <input name="billing_zip" type="text"
                                                       class="form-control form-control-lg form-control-solid"
                                                       placeholder="Zip Code"
                                                       value="{{!empty($patientDetails->billing_zip)?$patientDetails->billing_zip:''}}"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-9 col-xl-6 offset-xl-3">
                                            <h3 class="font-size-h6 mb-5">Shipping Address Info:</h3>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label"> Address 1</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <textarea name="shipping_address_1"
                                                      class="form-control form-control-lg form-control-solid"
                                                      placeholder="Address"
                                                      type="text">{{!empty($patientDetails->shipping_address_1)?$patientDetails->shipping_address_1:''}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label"> Address 2</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <textarea name="shipping_address_2"
                                                      class="form-control form-control-lg form-control-solid"
                                                      placeholder="Address"
                                                      type="text">{{!empty($patientDetails->shipping_address_2)?$patientDetails->shipping_address_2:''}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label"> Address 3</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <textarea name="shipping_address_3"
                                                      class="form-control form-control-lg form-control-solid"
                                                      placeholder="Address"
                                                      type="text">{{!empty($patientDetails->shipping_address_3)?$patientDetails->shipping_address_3:''}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">City</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input name="shipping_city_name"
                                                   class="form-control form-control-lg form-control-solid" type="text"
                                                   placeholder="City"
                                                   value="{{!empty($patientDetails->shipping_city_name)?$patientDetails->shipping_city_name:''}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">State</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group input-group-lg input-group-solid">
                                                <select name="shipping_state_id" style="width: 100% !important;"
                                                        class="form-control form-control-lg form-control-solid state-select2">
                                                    @if(!empty($patientDetails))
                                                        <option
                                                            value="{{(isset($patientDetails))?$patientDetails->shipping_state_id:(old('shipping_state_id')?old('shipping_state_id'):0)}}">
                                                            {{ isset($getBillingStatName->state_name)?$getBillingStatName->state_name:''}}
                                                        </option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">Zip Code</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group input-group-lg input-group-solid">
                                                <input name="shipping_zip" type="text"
                                                       class="form-control form-control-lg form-control-solid"
                                                       placeholder="Zip Code"
                                                       value="{{!empty($patientDetails->shipping_zip)?$patientDetails->shipping_zip:''}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">Height</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input class="form-control form-control-lg form-control-solid"
                                                   placeholder="Height" type="text"
                                                   value="{{!empty($patientDetails->height)?$patientDetails->height:''}}"
                                                   name="height"/>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">Weight</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input class="form-control form-control-lg form-control-solid"
                                                   placeholder="Weight" type="text"
                                                   value="{{!empty($patientDetails->weight)?$patientDetails->weight:''}}"
                                                   name="weight"/>
                                        </div>
                                    </div>
                                    {{--                                    <div class="form-group row">--}}
                                    {{--                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">Time Zone</label>--}}
                                    {{--                                        <div class="col-lg-9 col-xl-6">--}}
                                    {{--                                            <select class="form-control form-control-lg form-control-solid" type="text"--}}
                                    {{--                                                    name="time_zone">--}}
                                    {{--                                                <option value="">Select Time Zone</option>--}}
                                    {{--                                                @foreach($getTimeZone as $timezone)--}}
                                    {{--                                                    <option--}}
                                    {{--                                                        value="{{$timezone['value']}}" {{ isset($patientDetails) && $patientDetails->time_zone == $timezone['value'] ? 'selected' : ''}}>{{$timezone['label']}}</option>--}}
                                    {{--                                                @endforeach--}}

                                    {{--                                            </select>--}}

                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">Last 4 of credit card
                                            & Type</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group input-group-lg input-group-solid">
                                                <input type="text"
                                                       class="form-control form-control-lg form-control-solid"
                                                       value=""/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-6">
                                            </div>
                                            <div class="col-6">
                                                <button type="submit" id="form_submit" class="btn btn-primary mr-2">
                                                    Submit
                                                </button>
                                                <button type="reset" class="btn btn-danger">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane {{$visitNoteTab}}" id="tab_2" role="tabpanel">
                                <form action="{{route('visit-note')}}" method="post" enctype="multipart/form-data"
                                      class="ajax-form">
                                    @csrf

                                    <div class="row">
                                        <div class="col-lg-9 col-xl-6 offset-xl-3">
                                            <h3 class="font-size-h6 mb-5">Visit:</h3>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <input type="hidden" name="patients_id"
                                               value="{{!empty($patientDetails)?$patientDetails->patients_id:''}}">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">ICD10 Code</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input id="kt_tagify_1"
                                                   class="form-control form-control-lg form-control-solid tagify"
                                                   type="text" value="" name="icd_code"/>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">Visit Note</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <textarea class="form-control form-control-lg form-control-solid"
                                                      placeholder="Visit Note" type="text" name="visit_note"></textarea>

                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-6">
                                            </div>
                                            <div class="col-6">
                                                <button type="submit" id="form_submit" class="btn btn-primary mr-2">
                                                    Submit
                                                </button>
                                                <button type="reset" class="btn btn-danger">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="separator separator-dashed my-2"></div>
                                @if(!empty($visitNote))
                                    <div class="container-fluid">
                                        <div class="card card-custom">
                                            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                                                <div class="card-title">
                                                    <h3 class="card-label">
                                                        Visit History
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table
                                                        class="table table-striped- table-bordered table-hover table-checkable"
                                                        id="kt_datatable" style="margin-top: 13px !important">
                                                        <thead>
                                                        <tr class="text-uppercase">
                                                            <th style="min-width: 150px">ICD10 Code</th>
                                                            <th style="min-width: 150px">Visit Note</th>
                                                            <th style="min-width: 150px">Created At</th>
                                                            <th style="min-width: 150px">Created By</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($visitNote as $value)
                                                            <tr>
                                                                <td>
                                                                    <span
                                                                        class="text-dark-75 font-weight-bolder d-block font-size-lg">{{!empty($value->icd_code)?$value->icd_code:''}}</span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="text-dark-75 font-weight-bolder d-block font-size-lg">{{!empty($value->visit_note)?$value->visit_note:''}}</span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ date('d/m/Y g:i A',strtotime($value->created_at))}}</span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="text-dark-75 font-weight-bolder d-block font-size-lg">{{$baseHelper->createdBy($value->created_by)}}</span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane {{$medicationTab}}" id="tab_3" role="tabpanel">
                                <div class="row">
                                    <label class="col-xl-3"></label>
                                    <div class="col-lg-9 col-xl-6">
                                        <h3 class="font-size-h6 mb-5">Medication:</h3>
                                    </div>
                                </div>
                                <form action="{{route('save-medication')}}" method="post" enctype="multipart/form-data"
                                      class="ajax-form">
                                    @csrf
                                    <input type="hidden" name="patients_id"
                                           value="{{!empty($patientDetails)?$patientDetails->patients_id:''}}">
                                    <div id="kt_repeater_1">
                                        <div class="row d-flex justify-content-center" id="kt_repeater_1">
                                            <div data-repeater-list="medication_details" class="col-lg-10">
                                                <div data-repeater-item class="form-group row align-items-center">
                                                    <div class="col-md-3">
                                                        <label>Medication Name:</label>
                                                        <input type="text" class="form-control" name="medication_name"
                                                               placeholder="Medication Name"/>
                                                        <div class="d-md-none mb-2"></div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Description:</label>
                                                        <input type="text" class="form-control" name="description"
                                                               placeholder="Description"/>
                                                        <div class="d-md-none mb-2"></div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Dosage:</label>
                                                        <input type="text" class="form-control" name="dosage"
                                                               placeholder="Dosage"/>
                                                        <div class="d-md-none mb-2"></div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label>Qty:</label>
                                                        <input type="text" class="form-control" name="qty"
                                                               placeholder="Qty"/>
                                                        <div class="d-md-none mb-2"></div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <a href="javascript:;" data-repeater-delete=""
                                                           class="btn btn-sm font-weight-bolder btn-light-danger">
                                                            <i class="la la-trash-o"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-2 col-form-label text-right"></label>
                                            <div class="col-lg-4">
                                                <a href="javascript:;" data-repeater-create=""
                                                   class="btn btn-sm font-weight-bolder btn-light-primary">
                                                    <i class="la la-plus"></i>Add
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-6">
                                            </div>
                                            <div class="col-6">
                                                <button type="submit" id="form_submit" class="btn btn-primary mr-2">
                                                    Submit
                                                </button>
                                                <button type="reset" class="btn btn-danger">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="separator separator-dashed my-2"></div>
                                @if(!empty($medicalHistory))
                                    <div class="container-fluid">
                                        <div class="card card-custom">
                                            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                                                <div class="card-title">
                                                    <h3 class="card-label">
                                                        Medication History
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table
                                                        class="table table-striped- table-bordered table-hover table-checkable"
                                                        id="kt_datatable" style="margin-top: 13px !important">
                                                        <thead>
                                                        <tr class="text-uppercase">
                                                            <th style="min-width: 150px">Medication Name</th>
                                                            <th style="min-width: 150px">Description</th>
                                                            <th style="min-width: 150px">Dosage</th>
                                                            <th style="min-width: 150px">Qty</th>
                                                            <th style="min-width: 150px">Created At</th>
                                                            <th style="min-width: 150px">Created By</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($medicalHistory as $value)
                                                            <tr>
                                                                <td>
                                                                    <span
                                                                        class="text-dark-75 font-weight-bolder d-block font-size-lg">{{!empty($value->medication_name)?$value->medication_name:''}}</span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="text-dark-75 font-weight-bolder d-block font-size-lg">{{!empty($value->description)?$value->description:''}}</span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="text-dark-75 font-weight-bolder d-block font-size-lg">{{!empty($value->dosage)?$value->dosage:''}}</span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="text-dark-75 font-weight-bolder d-block font-size-lg">{{!empty($value->qty)?$value->qty:''}}</span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ date('d/m/Y g:i A',strtotime($value->created_at))}}</span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="text-dark-75 font-weight-bolder d-block font-size-lg">{{$baseHelper->createdBy($value->created_by)}}</span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane {{$lbsTab}}" id="tab_4" role="tabpanel">
                                <div class="row">
                                    <label class="col-xl-3"></label>
                                    <div class="col-lg-9 col-xl-6">
                                        <h3 class="font-size-h6 mb-5">Labs:</h3>
                                    </div>
                                </div>
                                <form action="{{route('save-lab-report')}}" method="post" enctype="multipart/form-data"
                                      class="ajax-form">
                                    @csrf
                                    <input type="hidden" name="patients_id"
                                           value="{{!empty($patientDetails)?$patientDetails->patients_id:''}}">
                                    <div id="lab_repeater">
                                        <div class="row d-flex justify-content-center" id="lab_repeater">
                                            <div data-repeater-list="lab_detail" class="col-lg-10">
                                                <div data-repeater-item class="form-group row align-items-center">
                                                    <div class="col-md-4">
                                                        <label>Category:</label>
                                                        <select type="text" class="form-control category-select2"
                                                                name="category_id" style="width: 100%!important;">
                                                            <option value="">Select</option>
                                                        </select>
                                                        <div class="d-md-none mb-2"></div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Value:</label>
                                                        <input type="text" class="form-control" name="value"
                                                               placeholder="Value"/>
                                                        <div class="d-md-none mb-2"></div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Score:</label>
                                                        <input type="text" class="form-control" name="score"
                                                               placeholder="Score"/>
                                                        <div class="d-md-none mb-2"></div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <a href="javascript:;" data-repeater-delete=""
                                                           class="btn btn-sm font-weight-bolder btn-light-danger">
                                                            <i class="la la-trash-o"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-2 col-form-label text-right"></label>
                                            <div class="col-lg-4">
                                                <a href="javascript:;" data-repeater-create=""
                                                   class="btn btn-sm font-weight-bolder btn-light-primary">
                                                    <i class="la la-plus"></i>Add
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-6">
                                            </div>
                                            <div class="col-6">
                                                <button type="submit" id="form_submit" class="btn btn-primary mr-2">
                                                    Submit
                                                </button>
                                                <button type="reset" class="btn btn-danger">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="separator separator-dashed my-2"></div>

                                @if(!empty($getLabReport))
                                    <div class="container-fluid">
                                        <div class="card card-custom">
                                            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                                                <div class="card-title">
                                                    <h3 class="card-label">
                                                        Lab History :
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table
                                                        class="table table-striped- table-bordered table-hover table-checkable"
                                                        id="kt_datatable" style="margin-top: 13px !important">
                                                        <thead>
                                                        <tr class="text-uppercase">
                                                            <th style="min-width: 150px">Category Name</th>
                                                            <th style="min-width: 150px">Value</th>
                                                            <th style="min-width: 150px">Score</th>
                                                            <th style="min-width: 150px">Created At</th>
                                                            <th style="min-width: 150px">Created By</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($getLabReport as $value)
                                                            <tr>
                                                                <td>
                                                                    <span
                                                                        class="text-dark-75 font-weight-bolder d-block font-size-lg">{{!empty($value->category_name)?$value->category_name:''}}</span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="text-dark-75 font-weight-bolder d-block font-size-lg">{{!empty($value->value)?$value->value:''}}</span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="text-dark-75 font-weight-bolder d-block font-size-lg">{{!empty($value->score)?$value->score:''}}</span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ date('d/m/Y g:i A',strtotime($value->created_at))}}</span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="text-dark-75 font-weight-bolder d-block font-size-lg">{{$baseHelper->createdBy($value->created_by)}}</span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif


                            </div>
                            <div class="tab-pane" id="tab_5" role="tabpanel">
                                <div class="row">
                                    <label class="col-xl-2"></label>
                                    <div class="col-lg-10 col-xl-8">
                                        <h3 class="font-size-h6 mb-5">Chat History:</h3>
                                        <div data-scroll="true" data-height="500">
                                            <div class="timeline timeline-3">
                                                <div class="timeline-items" id="chatHistory">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_6" role="tabpanel">
                                <div class="row">
                                    @if(!empty($getOrderHistory))
                                        <div class="container-fluid">
                                            <div class="card card-custom">
                                                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                                                    <div class="card-title">
                                                        <h3 class="card-label">
                                                            Order History :
                                                        </h3>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table
                                                            class="table table-striped- table-bordered table-hover table-checkable"
                                                            id="kt_datatable" style="margin-top: 13px !important">
                                                            <thead>
                                                            <tr class="text-uppercase">
                                                                <th style="min-width: 150px">Order Id</th>
                                                                <th style="min-width: 150px">Order Date</th>
                                                                <th style="min-width: 150px">Payment Status</th>
                                                                <th style="min-width: 150px">Order Status</th>
                                                                <th style="min-width: 150px">Action</th>

                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($getOrderHistory as $value)

                                                                <tr>
                                                                    <td>
                                                                        <span
                                                                            class="text-dark-75 font-weight-bolder d-block font-size-lg">{{!empty($value)?$value->order_id:""}}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="text-dark-75 font-weight-bolder d-block font-size-lg">{{!empty($value)?$baseHelper->dateFormat($value->created_at,'formate-3'):''}}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="text-dark-75 font-weight-bolder d-block font-size-lg">{{!empty($value->payment_status)?$value->payment_status:''}}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="text-dark-75 font-weight-bolder d-block font-size-lg">{{!empty($value->order_status)?$value->order_status:''}}</span>
                                                                    </td>

                                                                    <td>
                                                                        <a href="{{route('order.show', $value->order_id)}}"
                                                                           class="btn btn-primary"><i
                                                                                class="flaticon-eye"></i></a>
                                                                    </td>

                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <div class="tab-pane" id="tab_7" role="tabpanel">
                                <div class="row">
                                    <label class="col-xl-3"></label>
                                    <div class="col-lg-9 col-xl-6">
                                        <h3 class="font-size-h6 mb-5">Order:</h3>
                                    </div>
                                </div>
                                <form action="{{route('save-order')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="patients_id"
                                           value="{{!empty($patientDetails)?$patientDetails->patients_id:''}}">
                                    <input type="hidden" name="selected_order_type" value="" id="selected_order_type">

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right col-form-label">Order Type<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <select class="form-control" id="order_type" required name="order_type"
                                                    data-msg-required="Order Type is required"
                                                    style="width: 100%!important;">
                                                <option value="">Select Order Type</option>
                                                <option value="OneTime">OneTime</option>
                                                <option value="Subscription">Subscription</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div id="order_repeater">
                                        <div class="row d-flex justify-content-center" id="kt_repeater_1">
                                            <div data-repeater-list="order_details" class="col-lg-10">
                                                <div data-repeater-item class="form-group row align-items-center">
                                                    <div class="col-md-5">
                                                        <label>Product:</label>
                                                        <select type="text" class="form-control product-select2"
                                                                name="product_id" style="width: 100%!important;">
                                                            <option value="">Select</option>
                                                        </select>
                                                        <div class="d-md-none mb-2"></div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Qty:</label>
                                                        <input type="text" class="form-control" name="qty"
                                                               placeholder="Qty"/>
                                                        <div class="d-md-none mb-2"></div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <a href="javascript:;" data-repeater-delete=""
                                                           class="btn btn-sm font-weight-bolder btn-light-danger">
                                                            <i class="la la-trash-o"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-2 col-form-label text-right"></label>
                                            <div class="col-lg-4">
                                                <a href="javascript:;" data-repeater-create=""
                                                   class="btn btn-sm font-weight-bolder btn-light-primary">
                                                    <i class="la la-plus"></i>Add
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-6">
                                            </div>
                                            <div class="col-6">
                                                <button type="submit" id="form_submit" class="btn btn-primary mr-2">
                                                    Submit
                                                </button>
                                                <button type="reset" class="btn btn-danger">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>


                            </div>
                            <div class="tab-pane" id="tab_8" role="tabpanel">
                                <div class="row">
                                    @if(!empty($getSchedule))
                                        <div class="container-fluid">
                                            <div class="card card-custom">
                                                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                                                    <div class="card-title">
                                                        <h3 class="card-label">
                                                            Schedule History :
                                                        </h3>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table
                                                            class="table table-striped- table-bordered table-hover table-checkable"
                                                            id="kt_datatable" style="margin-top: 13px !important">
                                                            <thead>
                                                            <tr class="text-uppercase">
                                                                <th style="min-width: 150px">Date</th>
                                                                <th style="min-width: 150px">Event Name</th>
                                                                <th style="min-width: 150px">Provider Name</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($getSchedule as $value)

                                                                <tr>
                                                                    <td>
                                                                        <span
                                                                            class="text-dark-75 font-weight-bolder d-block font-size-lg">{{!empty($value->date)?date('d/m/Y', strtotime($value->date))." ". $value->time_slot:''}}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="text-dark-75 font-weight-bolder d-block font-size-lg">{{!empty($value->getAssignProgramName->getEvents)?$value->getAssignProgramName->getEvents->event_name:''}}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="text-dark-75 font-weight-bolder d-block font-size-lg">{{!empty($value->getProviderName)?$value->getProviderName->first_name." ".$value->getProviderName->last_name:''}}</span>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <div class="tab-pane" id="tab_9" role="tabpanel">
                                <div class="row">
                                    <label class="col-xl-2"></label>
                                    <div class="col-lg-10 col-xl-8">
                                        <h3 class="font-size-h6 mb-5">TimeLine:</h3>
                                        <div data-scroll="true" data-height="500">
                                            <div class="timeline timeline-3">
                                                <div class="timeline-items" id="timeline">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_10" role="tabpanel">

                                @if(count($surveyForm) > 0)
                                    @foreach($surveyForm as $key=>$value)
                                            <?php
                                            $surveyFormType = !empty($value->survey_form_type) ? $value->survey_form_type : '';
                                            $getMedicationsConjunction = $baseHelper->getMedicationsConjunction();
                                            $productDetails = \Illuminate\Support\Facades\DB::table('product')->select('product_name', 'product_id')->where('product_id', $value->product_id)->first();
                                            $getCardiovascular = $baseHelper->getCardiovascular();
                                            $getDiabetes = $baseHelper->getDiabetes();
                                            $selectedConjunction = !empty($value->medication_conjunction) ? explode(',', $value->medication_conjunction) : '';
                                            $selectedCardiovascular = !empty($value->cardiovascular) ? explode(',', $value->cardiovascular) : '';
                                            $selectedDiabetes = !empty($value->diabetes) ? explode(',', $value->diabetes) : '';
                                            ?>


                                        <div class="container-fluid">
                                            <div class="card card-custom card-collapsed" data-card="true"
                                                 id="kt_card_4">
                                                <div class="card-header">
                                                    <div class="card-title">
                                                        <h3 class="card-label text-capitalize">{{$surveyFormType}} Form
                                                            Survey {{$key+1}}   {{!empty($value->created_at) ? "(". date('d-M-Y', strtotime($value->created_at)). ")" : null }}</h3>
                                                    </div>
                                                    <div class="card-toolbar">
                                                        <a href="#" class="btn btn-icon btn-sm btn-primary mr-1"
                                                           data-card-tool="toggle">
                                                            <i class="ki ki-arrow-down icon-nm"></i>
                                                        </a>
                                                        <button
                                                            onclick="copyToClipboard({{!empty($value->ed_flow_id)?$value->ed_flow_id:$value->trt_flow_id}},'{{$value->survey_form_type}}')"
                                                            class="btn btn-icon btn-sm btn-success mr-1">
                                                            <i class="ki ki-copy icon-nm"></i>
                                                        </button>

                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    @if($surveyFormType == 'ed')
                                                        <div class="table-responsive">
                                                            <table class="table table-striped- table-bordered">
                                                                <tr class="datatable-row-detail">
                                                                    <td class="datatable-detail" colspan="13">
                                                                        <table>
                                                                            <tr class="datatable-row">
                                                                                <td>
                                                                                <span
                                                                                    style="width: 300px;">Product Name</span>
                                                                                </td>
                                                                                <td class="datatable-cell">
                                                                            <span
                                                                                style="width: 300px;">{{!empty($productDetails)?$productDetails->product_name:''}}</span>
                                                                                </td>
                                                                            </tr>
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
                                                                                        <span
                                                                                            style="width: 300px;">Male</span>
                                                                                    @else
                                                                                        <span style="width: 300px;">FeMale</span>
                                                                                    @endif

                                                                                </td>
                                                                            </tr>
                                                                            <tr class="datatable-row">
                                                                                <td>
                                                                                    <span
                                                                                        style="width: 300px;">Height</span>
                                                                                </td>
                                                                                <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{ !empty($value) ? $value->height:''}}</span>
                                                                                </td>
                                                                            </tr>
                                                                            <tr class="datatable-row">
                                                                                <td>
                                                                                    <span
                                                                                        style="width: 300px;">Weight</span>
                                                                                </td>
                                                                                <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{ !empty($value) ? $value->weight:''}}</span>
                                                                                </td>
                                                                            </tr>
                                                                            <tr class="datatable-row">
                                                                                <td>
                                                                                    <span
                                                                                        style="width: 300px;">Birthday</span>
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
                                                                                                <i class="fas fa-dot-circle"></i> {{$medicationsConjunction['label']}}
                                                                                                <br>
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
                                                                                                <i class="fas fa-dot-circle"></i> {{$cardiovascular['label']}}
                                                                                                <br>
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
                                                                                                <i class="fas fa-dot-circle"></i> {{$diabetes['label']}}
                                                                                                <br>
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

                                                    @elseif($surveyFormType == 'trt')
                                                        <table class="table table-striped- table-bordered">
                                                            <tr class="datatable-row-detail">
                                                                <td class="datatable-detail" colspan="13">
                                                                    <table>
                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span
                                                                                    style="width: 300px;">Product Name</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                                            <span
                                                                                style="width: 300px;">{{!empty($productDetails)?$productDetails->product_name:''}}</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">What's your legal first name ?</span>
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
                                                                                <span
                                                                                    style="width: 300px;">Phone Number</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{ !empty($value) ? $value->phone_no:''}}</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span
                                                                                    style="width: 300px;">Birthday</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{ !empty($value->dob) ? date('d-m-Y',strtotime($value->dob)):null}}</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">APT / Suite #</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->apt) ? $value->apt : ''}}</span>
                                                                            </td>
                                                                        </tr>
{{--                                                                        <tr class="datatable-row">--}}
{{--                                                                            <td>--}}
{{--                                                                                <span style="width: 300px;">What is your current primary health goal?</span>--}}
{{--                                                                            </td>--}}
{{--                                                                            <td class="datatable-cell">--}}
{{--                                                        <span--}}
{{--                                                            style="width: 300px;">{{!empty($value->current_health_goal) ? $value->current_health_goal : ''}}</span>--}}
{{--                                                                            </td>--}}
{{--                                                                        </tr>--}}

{{--                                                                        <tr class="datatable-row">--}}
{{--                                                                            <td>--}}
{{--                                                                                <span style="width: 300px;">My treatment progress towards my health goal(s) is:</span>--}}
{{--                                                                            </td>--}}
{{--                                                                            <td class="datatable-cell">--}}
{{--                                                        <span--}}
{{--                                                            style="width: 300px;">{{!empty($value->toward_health_goal) ? $value->toward_health_goal : ''}}</span>--}}
{{--                                                                            </td>--}}
{{--                                                                        </tr>--}}
{{--                                                                        <tr class="datatable-row">--}}
{{--                                                                            <td>--}}
{{--                                                                                <span style="width: 300px;">What is your target weight goal?</span>--}}
{{--                                                                            </td>--}}
{{--                                                                            <td class="datatable-cell">--}}
{{--                                                        <span--}}
{{--                                                            style="width: 300px;">{{!empty($value->weight_goal) ? $value->weight_goal : ''}}</span>--}}
{{--                                                                            </td>--}}
{{--                                                                        </tr>--}}
{{--                                                                        <tr class="datatable-row">--}}
{{--                                                                            <td>--}}
{{--                                                                                <span style="width: 300px;">What is your current weight in lbs?</span>--}}
{{--                                                                            </td>--}}
{{--                                                                            <td class="datatable-cell">--}}
{{--                                                        <span--}}
{{--                                                            style="width: 300px;">{{!empty($value->weight_lbs) ? $value->weight_lbs : ''}}</span>--}}
{{--                                                                            </td>--}}
{{--                                                                        </tr>--}}
                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span
                                                                                    style="width: 300px;">Energy</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->energy) ? $value->energy : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Sleep</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->sleep) ? $value->sleep : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span
                                                                                    style="width: 300px;">Libido</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->libido) ? $value->libido : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Memory & Focus:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->memory) ? $value->memory : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Endurance & Strength:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->strength) ? $value->strength : ''}}</span>
                                                                            </td>
                                                                        </tr>


                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Do you want to have children in the future?</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->future_children) && $value->future_children == '1' ? 'Yes' : 'No'}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Do you have any children under the age of 5 years living in the home?</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->living_children) && $value->living_children == '1' ? 'Yes' : 'No'}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">We offer testosterone in the form of injection, cream, and gel: are you interested in changing your treatment method?</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->testosterone) && $value->testosterone == '1' ? 'Yes' : 'No'}}</span>
                                                                            </td>
                                                                        </tr>


                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">We offer testosterone in the form of injection, cream, and gel: are you interested in changing your treatment method?</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->cream_and_gel) && $value->cream_and_gel == '1' ? 'Yes' : 'No'}}</span>
                                                                            </td>
                                                                        </tr>


                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Do you have any new allergies that we should know about?</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->allergies) && $value->allergies == '1' ? 'Yes' : 'No'}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Do you have any new prescription drugs, over-the-counter medicine, herbal or vitamin supplements that we should know about?</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->herbal_or_vitamin) && $value->herbal_or_vitamin == '1' ? 'Yes' : 'No'}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Are you taking your medications as prescribed?</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->medications_prescribed) && $value->medications_prescribed == '1' ? 'Yes' : 'No'}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span
                                                                                    style="width: 300px;">Cold Chills:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->cold_chills) ? $value->cold_chills  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Cold Hands and Feet:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->cold_hand_and_feet) ? $value->cold_hand_and_feet  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Decreased Sweating:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->decreased_sweating) ? $value->decreased_sweating  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Thinning Skin:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->thinning_skin) ? $value->thinning_skin  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Excessive Body Hair:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->excessive_body_hair) ? $value->excessive_body_hair  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Nails Brittle Or Breaking:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->nail_brittle) ? $value->nail_brittle  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Dry and Brittle Hair:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->dry_brittle) ? $value->dry_brittle  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Hair Loss On Scalp:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->hair_loss) ? $value->hair_loss  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span
                                                                                    style="width: 300px;">Dry Skin:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->dry_skin) ? $value->dry_skin  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Thinning Pubic Hair:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->thinning_public_hair) ? $value->thinning_public_hair  : ''}}</span>
                                                                            </td>
                                                                        </tr>


                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span
                                                                                    style="width: 300px;">Low Libido:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->low_libido) ? $value->low_libido  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Memory Lapses:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->memory_lapsed) ? $value->memory_lapsed  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Difficulty Concentrating:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->difficulty_concentrating) ? $value->difficulty_concentrating  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span
                                                                                    style="width: 300px;">Depression:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->deperssion) ? $value->deperssion  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span
                                                                                    style="width: 300px;">Stress:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->stress) ? $value->stress  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span
                                                                                    style="width: 300px;">Anxiety:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->anxiety) ? $value->anxiety  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Sleep Disturbances:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->sleep_disturbances) ? $value->sleep_disturbances  : ''}}</span>
                                                                            </td>
                                                                        </tr>


                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Aches And Pains:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->aches_and_pains) ? $value->aches_and_pains  : ''}}</span>
                                                                            </td>
                                                                        </tr>


                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span
                                                                                    style="width: 300px;">Headaches:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->headaches) ? $value->headaches  : ''}}</span>
                                                                            </td>
                                                                        </tr>


                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Tired Or Exhausted:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->tired) ? $value->tired  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span
                                                                                    style="width: 300px;">Hoarseness:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->hoarseness) ? $value->hoarseness  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Slowed Reflexes:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->slowed_reflexes) ? $value->slowed_reflexes  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Constipation:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->constipation) ? $value->constipation  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Heart Palpitations:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->hear_palpitation) ? $value->hear_palpitation  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Fast Heart Rate:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->fast_heart_rate) ? $value->fast_heart_rate  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Sugar Cravings:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->sugar_cravings) ? $value->sugar_cravings  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span
                                                                                    style="width: 300px;">Weight Gain:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->weight_gain) ? $value->weight_gain  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Weight Loss Difficulty:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->weight_loss_difficulty) ? $value->weight_loss_difficulty  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Decreased Muscle Mass:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->decreased_muscle_mass) ? $value->decreased_muscle_mass  : ''}}</span>
                                                                            </td>
                                                                        </tr>


                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span
                                                                                    style="width: 300px;">Hot Flashes:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->hot_flashes) ? $value->hot_flashes  : ''}}</span>
                                                                            </td>
                                                                        </tr>


                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Excessive Sweating:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->excessive_sweating) ? $value->excessive_sweating  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Excessive Facial Hair:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->excessive_facial_hair) ? $value->excessive_facial_hair  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Increased Acne:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->increased_acne) ? $value->increased_acne  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span
                                                                                    style="width: 300px;">Oily Skin:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->oily_skin) ? $value->oily_skin  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Irritability:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->irritability) ? $value->irritability  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Mood Changes:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->mood_changes) ? $value->mood_changes  : ''}}</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Incontinence:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->incontinence) ? $value->incontinence  : ''}}</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Puffy Eyes Or Swollen Face:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->puffy_eyes) ? $value->puffy_eyes  : ''}}</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Low Blood Pressure:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->low_blood_pressure) ? $value->low_blood_pressure  : ''}}</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Slow Heart Rate:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->slow_heart_rate) ? $value->slow_heart_rate  : ''}}</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span
                                                                                    style="width: 300px;">Weight Loss:</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->weight_loss) ? $value->weight_loss  : ''}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Use the same shipping & billing address as the previous order?</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->same_shipping_as_billing) &&  $value->same_shipping_as_billing == '1' ? 'Yes' : 'No'}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Use the same credit card on file?</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->same_as_credit_card) &&  $value->same_as_credit_card == '1' ? 'Yes' : 'No'}}</span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Any additional information you'd like to share?</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->additional_information) ?  $value->additional_information : ''}}</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="datatable-row">
                                                                            <td>
                                                                                <span style="width: 300px;">Based on your experience, would you recommend Male Excel to someone that may benefit from hormone replacement therapy?</span>
                                                                            </td>
                                                                            <td class="datatable-cell">
                                                        <span
                                                            style="width: 300px;">{{!empty($value->experience) ?  $value->experience : ''}}</span>
                                                                            </td>
                                                                        </tr>


                                                                    </table>
                                                                </td>
                                                            </tr>

                                                        </table>
                                                    @endif
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
                                                    <span
                                                        class="card-label text-center">Survey From  not found ! </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endif

                            </div>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
    </div>
@endsection
@push('styles')
    <link href="{{asset('assets/css/intTelInput.css')}}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{asset('assets/js/pages/crud/forms/widgets/tagify.js')}}"></script>
    <script src="{{asset('assets/js/pages/crud/file-upload/image-input.js')}}"></script>
    <script src="{{asset('assets/js/pages/crud/datatables/basic/scrollable.js')}}"></script>
    <script src="{{asset('assets/js/intlTelInput.js')}}"></script>
    <script>
        $('#dob').datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            format: 'dd/mm/yyyy',
            orientation: "bottom left",
            templates: arrows = {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            },
            endDate: "today",
        });
        $('#profile_claimed').datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            format: 'dd/mm/yyyy',
            orientation: "bottom left",
            templates: arrows = {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            },
            endDate: "today",
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
        $('#kt_repeater_1').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
        $('#order_repeater').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
                $(".product-select2").select2({
                    ajax: {
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{ url('product-list')}}",
                        type: "post",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                searchTerm: params.term,
                                orderType: $('#selected_order_type').val(),
                            };
                        }, processResults: function (response) {
                            return {results: response};
                        }, cache: true
                    }
                });

            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
        $('#lab_repeater').repeater({
            initEmpty: false,
            defaultValues: {
                'text-input': 'foo'
            },
            show: function () {
                $(this).slideDown();
                $(".category-select2").select2({
                    ajax: {
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{ url('lab-category-list')}}",
                        type: "post",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                searchTerm: params.term,
                                orderType: $('#selected_order_type').val(),
                            };
                        }, processResults: function (response) {
                            return {results: response};
                        }, cache: true
                    }
                });
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });

        $('#order_type').on('change', (event) => {
            $('#selected_order_type').val(event.target.value);
        });
        $(".product-select2").select2({
            ajax: {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ url('product-list')}}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        orderType: $('#selected_order_type').val(),
                    };
                }, processResults: function (response) {
                    return {results: response};
                }, cache: true
            }
        });

        $(".category-select2").select2({
            ajax: {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ url('lab-category-list')}}",
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

        function getTimeLine(patientsId) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url('get-timeline') }}',
                type: 'POST',

                data: {
                    patients_id: patientsId
                },
                success: function (data) {
                    $('#timeline').empty();
                    $.each(data[0], function (key, value) {
                        $('#timeline').append('' +
                            '<div class=timeline-item> <div class=timeline-media>' +
                            '<i class="flaticon2-notification fl text-primary"></i> ' +
                            '</div> <div class=timeline-content> ' +
                            '<div class="d-flex align-items-center justify-content-between mb-3"> ' +
                            '<div class=mr-2> ' +
                            '<a href=# class="text-dark-75 text-hover-primary font-weight-bold"></a> ' +
                            '<span class="text-muted ml-2">' + value.created_at + '</span>' +
                            '<span class="label label-light-primary font-weight-bolder label-inline ml-2">' + value.type + '</span>' +
                            ' </div> </div> <p class=p-0>' + value.notes + '</p> </div> </div>');

                    });
                }
            });
        }

        function chatHistory(patientsId) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url('get-chat-history') }}',
                type: 'POST',
                data: {
                    patients_id: patientsId
                },
                success: function (data) {
                    $('#chatHistory').empty();
                    $.each(data[0], function (key, value) {
                        $('#chatHistory').append('<div class="timeline-item"> ' +
                            '<div class="timeline-media"> ' +
                            '<img alt="Pic" src="{{asset('assets/media/users/300_25.jpg')}}"/> ' +
                            '</div>' +
                            '<div class="timeline-content"> ' +
                            '<div class="d-flex align-items-center justify-content-between mb-3"> ' +
                            '<div class="mr-2"> ' +
                            '<span class="text-muted ml-2">' + value.created_at + '</span> ' +
                            '</div> ' +
                            '</div>' +
                            ' <p class="p-0">' + value.content + '</p> ' +
                            '</div>' +
                            '</div>');
                    });
                }
            });
        }

    </script>
    <script>
        var isPhoneNoValid = false;
        var input = document.querySelector("#phone_no");
        const iti = window.intlTelInput(input, {
            allowExtensions: true,
            formatOnDisplay: true,
            allowFormat: true,
            autoHideDialCode: true,
            placeholderNumberType: "MOBILE",
            preventInvalidNumbers: true,
            separateDialCode: true,
            initialCountry: "{{$default_country_code}}",
        });
        input.addEventListener('countrychange', () => {
            $('#country_code').val(iti.getSelectedCountryData().dialCode)
        });
        @if(isset($phoneNo))
        iti.setNumber('{{$phoneNo}}');
        @endif
    </script>
    <script>
        var card = new KTCard('kt_card_4');

        function copyToClipboard(flowId, survey_form_type) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url('get-unique-url') }}',
                type: 'POST',
                data: {
                    flow_id: flowId,
                    survey_form_type: survey_form_type
                },
                success: function (response) {
                    if (response.data) {
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


