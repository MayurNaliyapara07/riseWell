
@extends('layouts.app')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @include('layouts.sub-header', [
            'title' => 'Chat',
            'directory'=> 'master'
       ])
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class=" container ">
                <!--begin::Chat-->
                <div class="d-flex flex-row">
                    <!--begin::Aside-->
                    <div class="flex-row-auto offcanvas-mobile w-350px w-xl-400px offcanvas-mobile-on" id="kt_chat_aside">
                        <!--begin::Card-->
                        <div class="card card-custom">
                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin:Search-->
                                <div class="input-group input-group-solid">
                                    <div class="input-group-prepend">
                        <span class="input-group-text">
                             <span class="svg-icon svg-icon-lg"><!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/General/Search.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"></rect>
        <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
        <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
    </g>
</svg><!--end::Svg Icon--></span>                        </span>
                                    </div>
                                    <input type="text" class="form-control py-4 h-auto" placeholder="Search">
                                </div>
                                <!--end:Search-->

                                <!--begin:Users-->
                                <div class="mt-7 scroll scroll-pull ps ps--active-y" style="height: 111px; overflow: hidden;">
                                    <!--begin:User-->
                                    @foreach($getPatientsNameList as $patients)
                                        <x-chat-user :patients="$patients"></x-chat-user>
                                    @endforeach
                                    <!--end:User-->

                                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 111px; right: -2px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 40px;"></div></div></div>
                                <!--end:Users-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card-->
                    </div><div class="offcanvas-mobile-overlay"></div>

                    <!--begin::Content-->
                    <div class="flex-row-fluid ml-lg-8" id="kt_chat_content">
                        <!--begin::Card-->
                        <div class="card card-custom">
                            <!--begin::Header-->

                            <div class="card-header align-items-center px-4 py-3">
                                <div class="text-left flex-grow-1">
                                    <!--begin::Aside Mobile Toggle-->
                                    <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md d-lg-none" id="kt_app_chat_toggle">
                        <span class="svg-icon svg-icon-lg"><!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Adress-book2.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"></rect>
        <path d="M18,2 L20,2 C21.6568542,2 23,3.34314575 23,5 L23,19 C23,20.6568542 21.6568542,22 20,22 L18,22 L18,2 Z" fill="#000000" opacity="0.3"></path>
        <path d="M5,2 L17,2 C18.6568542,2 20,3.34314575 20,5 L20,19 C20,20.6568542 18.6568542,22 17,22 L5,22 C4.44771525,22 4,21.5522847 4,21 L4,3 C4,2.44771525 4.44771525,2 5,2 Z M12,11 C13.1045695,11 14,10.1045695 14,9 C14,7.8954305 13.1045695,7 12,7 C10.8954305,7 10,7.8954305 10,9 C10,10.1045695 10.8954305,11 12,11 Z M7.00036205,16.4995035 C6.98863236,16.6619875 7.26484009,17 7.4041679,17 C11.463736,17 14.5228466,17 16.5815,17 C16.9988413,17 17.0053266,16.6221713 16.9988413,16.5 C16.8360465,13.4332455 14.6506758,12 11.9907452,12 C9.36772908,12 7.21569918,13.5165724 7.00036205,16.4995035 Z" fill="#000000"></path>
    </g>
</svg><!--end::Svg Icon--></span>                    </button>
                                    <!--end::Aside Mobile Toggle-->

                                    <!--begin::Dropdown Menu-->
                                    <!--end::Dropdown Menu-->
                                </div>
                                <div class="text-center flex-grow-1">
                                    <div class="text-dark-75 font-weight-bold font-size-h5">{{!empty($getPatientDetails)?$getPatientDetails->patients_name:''}}</div>
                                    <div>
                                        <span class="label label-sm label-dot label-success"></span>
                                        <span class="font-weight-bold text-muted font-size-sm">Active</span>
                                    </div>
                                </div>
                                <div class="text-right flex-grow-1">
                                    <!--begin::Dropdown Menu-->
                                    <div class="dropdown dropdown-inline">
                                        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="svg-icon svg-icon-lg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"></polygon>
        <path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
        <path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"></path>
    </g>
</svg><!--end::Svg Icon--></span>                        </button>
                                        <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-md">
                                            <!--begin::Navigation-->
                                            <ul class="navi navi-hover py-5">
                                                <li class="navi-item">
                                                    <a href="#" class="navi-link">
                                                        <span class="navi-icon"><i class="flaticon2-drop"></i></span>
                                                        <span class="navi-text">New Group</span>
                                                    </a>
                                                </li>
                                                <li class="navi-item">
                                                    <a href="#" class="navi-link">
                                                        <span class="navi-icon"><i class="flaticon2-list-3"></i></span>
                                                        <span class="navi-text">Contacts</span>
                                                    </a>
                                                </li>
                                                <li class="navi-item">
                                                    <a href="#" class="navi-link">
                                                        <span class="navi-icon"><i class="flaticon2-rocket-1"></i></span>
                                                        <span class="navi-text">Groups</span>
                                                        <span class="navi-link-badge">
                <span class="label label-light-primary label-inline font-weight-bold">new</span>
            </span>
                                                    </a>
                                                </li>
                                                <li class="navi-item">
                                                    <a href="#" class="navi-link">
                                                        <span class="navi-icon"><i class="flaticon2-bell-2"></i></span>
                                                        <span class="navi-text">Calls</span>
                                                    </a>
                                                </li>
                                                <li class="navi-item">
                                                    <a href="#" class="navi-link">
                                                        <span class="navi-icon"><i class="flaticon2-gear"></i></span>
                                                        <span class="navi-text">Settings</span>
                                                    </a>
                                                </li>

                                                <li class="navi-separator my-3"></li>

                                                <li class="navi-item">
                                                    <a href="#" class="navi-link">
                                                        <span class="navi-icon"><i class="flaticon2-magnifier-tool"></i></span>
                                                        <span class="navi-text">Help</span>
                                                    </a>
                                                </li>
                                                <li class="navi-item">
                                                    <a href="#" class="navi-link">
                                                        <span class="navi-icon"><i class="flaticon2-bell-2"></i></span>
                                                        <span class="navi-text">Privacy</span>
                                                        <span class="navi-link-badge">
                <span class="label label-light-danger label-rounded font-weight-bold">5</span>
            </span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <!--end::Navigation-->
                                        </div>
                                    </div>
                                    <!--end::Dropdown Menu-->
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->

                            <div class="card-body">
                                <!--begin::Scroll-->
                                <div class="scroll scroll-pull ps ps--active-y" data-mobile-height="350" style="height: 370px; overflow: hidden;">
                                    <!--begin::Messages-->

                                    <div id="message">
                                        @if(count($getChatList)>0)
                                            @foreach($getChatList as $msg)
                                                <div class="d-flex flex-column mb-5 align-items-end">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <span class="text-muted font-size-sm">{{\Carbon\Carbon::parse($msg->created_at)->diffForHumans(null, true)}}</span>
                                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">You</a>
                                                    </div>
                                                    <div class="symbol symbol-circle symbol-40 ml-3">
                                                        <img alt="Pic" src="{{!empty($msg->image) ? asset('/uploads/images/patients/'.$msg->image) : asset('assets/media/users/blank.png')}}">
                                                    </div>
                                                </div>
                                                <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">
                                                    {{!empty($msg->content)?$msg->content:''}}
                                                </div>
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>


                                    <!--end::Messages-->
                                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 370px; right: -2px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 129px;"></div></div></div>
                                <!--end::Scroll-->
                            </div>
                            <!--end::Body-->
                            <!--begin::Footer-->
                            <div class="card-footer align-items-center">
                                <!--begin::Compose-->
                                <div id="container"></div>
                                <textarea class="form-control border-0 p-0" id="content" rows="2" name="content" placeholder="Type a message"></textarea>
                                <input type="hidden" id="patients_id" name="patients_id" value="{{!empty($getPatientDetails)?$getPatientDetails->patients_id:''}}">
                                <input type="hidden" id="phone_no" name="phone_no" value="{{!empty($getPatientDetails)?$getPatientDetails->phone_no:''}}">
                                <input type="hidden" id="country_code" name="country_code" value="{{!empty($getPatientDetails)?$getPatientDetails->country_code:''}}">
                                <div class="d-flex align-items-center justify-content-between mt-5">
                                    <div class="mr-3">
                                        <a href="#" class="btn btn-clean btn-icon btn-md mr-1"><i class="flaticon2-photograph icon-lg"></i></a>
                                        <button class="btn btn-clean btn-icon btn-md"><i class="flaticon2-photo-camera  icon-lg"></i></button>
                                    </div>
                                    <div>
                                        <button type="button" id="send-msg" class="btn btn-primary btn-md text-uppercase font-weight-bold chat-send py-2 px-6">Send</button>
                                    </div>



                                </div>
                                <!--begin::Compose-->
                            </div>
                            <!--end::Footer-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Chat-->
            </div>
            <!--end::Container-->
        </div>
    </div>
@endsection
@push('scripts')

    <script src="{{asset('assets/js/pages/custom/chat/chat.js')}}"></script>

    <script>

        $(document).on('click','#send-msg', function (){
            var content = $('#content').val();
            var patients_id = $('#patients_id').val();
            var phone_no = $('#phone_no').val();
            var country_code = $('#country_code').val();
            $.ajax({
                url: "/send-msg",
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    content: content,
                    patients_id: patients_id,
                    phone_no: phone_no,
                    country_code:country_code,
                },
                success: function (response) {
                        $('#message').append('' +
                            '<div class="d-flex flex-column mb-5 align-items-end"> ' +
                            '<div class="d-flex align-items-center"> ' +
                            '<div> ' +
                            '<span class="text-muted font-size-sm">Just now</span> ' +
                            '<a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">You</a> ' +
                            '</div> ' +
                            '<div class="symbol symbol-circle symbol-40 ml-3"> <img alt="Pic" src={{asset('/uploads/images/patients/'.$getPatientDetails->image)}}> ' +
                            '</div> ' +
                            '</div> ' +
                            '<div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px"> ' + response.content + '</div>' +
                            '</div>')
                },
            });
            $('#content').val('').empty();
        });
    </script>
@endpush
