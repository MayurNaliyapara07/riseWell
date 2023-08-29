@inject('baseHelper','App\Helpers\ManageSection\Helper')
@extends('layouts.frontend')
@section('content')
    <form action="{{route('step1')}}" enctype="multipart/form-data">
        <section>
            <div class="get-started-area">
                <div class="container">
                    <div class="top-logo">
                        <div class="leftside">
                            <div class="logo">
                                <a href="#">
                                    <img src="{{$baseHelper->siteDarkLogo()}}" alt="Logo">
                                </a>
                            </div>
                        </div>
                        <div class="right-title">
                            {!! $baseHelper->getManageSectionConfigValueByKey('title_one') !!}
                        </div>
                    </div>
                    <div class="icon-list">
                        <div class="icon-block">
                            <div class="icon">
                                <img src="{{asset('assets/frontend/images/icon-1.png')}}" alt="">
                            </div>
                            <h4>HIPAA COMPLIANCE</h4>
                        </div>
                        <div class="icon-block">
                            <div class="icon">
                                <img src="{{asset('assets/frontend/images/icon-2.png')}}" alt="">
                            </div>
                            <h4>PCI LEVEL 1 COMPLIANCE</h4>
                        </div>

                        <div class="icon-block">
                            <div class="icon">
                                <img src="{{asset('assets/frontend/images/icon-3.png')}}" alt="">
                            </div>
                            <h4>LEGITSCRIPT CEFRIFIED</h4>
                        </div>

                        <div class="icon-block">
                            <div class="icon">
                                <img src="{{asset('assets/frontend/images/icon-4.png')}}" alt="">
                            </div>
                            <h4>DATA NEVER SOLD OR SHARED</h4>
                        </div>

                        <div class="icon-block">
                            <div class="icon">
                                <img src="{{asset('assets/frontend/images/icon-5.png')}}" alt="">
                            </div>
                            <h4>100% CONFIDEntial Online visit</h4>
                        </div>

                        <div class="icon-block">
                            <div class="icon">
                                <img src="{{asset('assets/frontend/images/icon-6.png')}}" alt="">
                            </div>
                            <h4>Less than 10 min to complete</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="dont-wait-area">
                <div class="container">
                    <div class="pd">
                        <p> {!! $baseHelper->getManageSectionConfigValueByKey('title_two') !!}</p>
                        <div class="checkarea">
                            <input type="checkbox" required  name="" value="">
                            <label for="">Click here to consent to
                                <a href="#">Privacy Policy</a> and
                                <a href="#">Terms</a>.
                            </label>
                        </div>
                    </div>

                    <div class="black-box">
                        <h2>Don’t Wait. RiseWell Today!</h2>
                        <button type="submit" class="btn-started"> GET started now</button>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="started-info">
                <div class="container">
                    <p> {!! $baseHelper->getManageSectionConfigValueByKey('title_three') !!}</p>
                </div>
            </div>
        </section>
    </form>
@endsection
@push('scripts')
    <script>
        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if (exist) {
            swalError(msg);
        }
    </script>
@endpush

