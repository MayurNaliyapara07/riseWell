@extends('layouts.frontend')
@section('content')
    <!--get-started-->
    <section>
        <div class="get-started-area">
            <div class="container">
                <div class="top-logo">
                    <div class="leftside">
                        <div class="logo"><a href="#"><img src="{{asset('assets/frontend/images/dark-logo-horizontal.png')}}" alt=""></a></div>
                    </div>
                    <div class="right-title">
                        Are you ready to get <strong>100mg Generic Viagra</strong> delivered to you?
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

    <!--dont-wait-->
    <section>
        <div class="dont-wait-area">
            <div class="container">
                <div class="pd">
                    <p>Torem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu turpis molestie, dictum est a, mattis tellus. Sed dignissim, metus nec fringilla accumsan, risus sem sollicitudin lacus, ut interdum tellus elit sed risus. Maecenas eget condimentum velit, sit amet feugiat lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent auctor purus luctus enim egestas, ac scelerisque ante pulvinar. Donec ut rhoncus ex. Suspendisse ac rhoncus nisl, eu tempor urna. Curabitur vel bibendum lorem. Morbi convallis convallis diam sit amet lacinia. Aliquam in elementum tellus. Curabitur tempor quis eros tempus lacinia. Nam bibendum pellentesque quam a convallis. </p>
                    <div class="checkarea">
                        <input type="checkbox" name="" value="">
                        <label for="">Click here to consent to <a href="#">Privacy Policy</a> and <a href="#">Terms</a>.</label>
                    </div>
                </div>

                <div class="black-box">
                    <h2>Don’t Wait. RiseWell Today!</h2>
                    <a href="{{route('step1')}}" class="btn-started"> GET started now</a>
                    <h4>Are you ready to get <strong>100mg Generic Viagra</strong> delivered to you?</h4>
                    <a href="#" class="btn-link">Get link via email</a>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="started-info">
            <div class="container">
                <p>Torem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu turpis molestie, dictum est a, mattis tellus. Sed dignissim, metus nec fringilla accumsan, risus sem sollicitudin lacus, ut interdum tellus elit sed risus. Maecenas eget condimentum velit, sit amet feugiat lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent auctor purus luctus enim egestas, ac scelerisque ante pulvinar. Donec ut rhoncus ex. Suspendisse ac rhoncus nisl, eu tempor urna. Curabitur vel bibendum lorem. Morbi convallis convallis diam sit amet lacinia. Aliquam in elementum tellus. Curabitur tempor quis eros tempus lacinia. Nam bibendum pellentesque quam a convallis. </p>
            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script>
        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if(exist){
            swalError(msg);
        }
    </script>
@endpush

