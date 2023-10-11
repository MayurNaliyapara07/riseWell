@inject('baseHelper','App\Helpers\ManageSection\Helper')
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RiseWell</title>

    @stack('styles')
    <style>
        .error {
            color: #f5365c !important;
            margin: auto;

        }
    </style>
    <link href="{{asset('assets/css/intTelInput.css')}}" rel="stylesheet">
    <link href="{{asset('assets/frontend/css/bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/frontend/css/style.css?a=1203')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/frontend/css/responsive.css?a=1203')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" id="theme-styles">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>


<div id='toTop' class="hvr-pulse"><img src="{{asset('assets/frontend/images/top_arrow.png')}}" alt="top" /></div>
<header>
    <div class="secondheader">
        <div class="logo">
            <a href="{{$baseHelper->getWebsiteUrl()}}"><img src="{{asset('assets/frontend/images/light-logo-horizontal.png')}}" alt="Logo"></a>
        </div>
        <div class="right-number">
            Have Questions? <span>CALL TODAY</span>
            <a href="tel:{{$baseHelper->getFrontendTopPhoneNo()}}">+ {{$baseHelper->getFrontendTopPhoneNo()}}</a>
        </div>
    </div>
</header>

@yield('content')


<!--footer-->
<footer>
    <div class="footer-main">
        <div class="container">
            <div class="logo-box">
                <a href="{{$baseHelper->getWebsiteUrl()}}"><img src="{{$baseHelper->siteLogo()}}" alt="Logo"></a>
            </div>
            <div class="footer-menu-area">
                <div class="row">
                    <div class="col-lg-4">
                        <ul class="footer-link">
                            <li><a href="{{$baseHelper->getBlogUrl()}}">Blog</a></li>
                            <li><a href="{{$baseHelper->getAboutUsUrl()}}">About Us</a></li>
                            <li><a href="{{$baseHelper->getContactUsUrl()}}">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-8">
                        <div class="footer-info">
                            <h2>Contact</h2>
                            <ul class="link">
                                <li>Mon – Fri</li>
                                <li>Email us anytime</li>
                                <li><a href="mailto:{{$baseHelper->getSupportEmail()}}" class="email">{{$baseHelper->getSupportEmail()}}</a></li>
                            </ul>
                        </div>
                        <div class="footer-info">
                            <h2>Links</h2>
                            <ul class="link">
                                <li><a href="{{$baseHelper->getTermsAndConditionsUrl()}}">Terms & Conditions</a></li>
                                <li><a href="{{$baseHelper->getPrivacyPolicyUrl()}}">Privacy Policy</a></li>
                                <li><a href="{{$baseHelper->getRefundPolicyUrl()}}">Refund Policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright">
                {{$baseHelper->getManageSectionConfigValueByKey('copy_rights')}}
            </div>
        </div>
    </div>
</footer>

<!--Js-->
<script src="{{asset('assets/frontend/js/jquery-3.1.1.js')}}"></script>
<script src="{{asset('assets/frontend/js/popper.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/js/intlTelInput.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.5.0/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(window).scroll(function() {
        if ($(this).scrollTop()) {
            $('#toTop').fadeIn();
        } else {
            $('#toTop').fadeOut();
        }
    });

    $("#toTop").click(function () {
        $("html, body").animate({scrollTop: 0}, 1000);
    });

    $('.btn-menu').on('click', function () {
        $('.menu-right').toggleClass('active');
        $('.btn-menu').toggleClass('active');
    });


    $('.main-slider').owlCarousel({
        nav: false,
        items:1,
        autoplay:true,
        dots: false,
        animateOut: 'fadeOut',
        loop: true,
    });



    $('.inner-product-slider').owlCarousel({
        nav:true,
        navText: [
            "<i class='fas fa-arrow-left'></i>","<i class='fas fa-arrow-right'></i>"
        ],
        responsive:{
            320:{
                items:1,
                margin:10,
                stagePadding: 20,
            },
            768:{
                items:2,
                margin:20,
                stagePadding: 30,
            },
            1360:{
                margin:40,
                items:3,
                stagePadding: 100,
            },
            1600:{
                margin:40,
                items:3,
                stagePadding: 100,
            },
            1920:{
                margin:40,
                items:4,
                stagePadding: 100,
                loop:true,

            }
        }
    });


    jQuery(window).scroll(function(){
        var sticky = jQuery('.header-main-area'),
            scroll = jQuery(window).scrollTop();

        if (scroll >= 50) sticky.addClass('fixed');
        else sticky.removeClass('fixed');
    });




</script>
<script>
    $(document).on("submit", ".ajax-form", function (e) {
        e.preventDefault();
        var form = jQuery(this);
        var action = form.attr("action");
        var data = form.serialize();
        var formData = new FormData(jQuery(this)[0]);
        if (form.valid()) {
            jQuery.ajax({
                url: action,
                type: "POST",
                enctype: "multipart/form-data",
                method: "post",
                dataType: "JSON",
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                success: function (response) {
                    console.log(response, "RESPONSE");
                    if (response.success) {
                        var route = "/";
                        if (response?.redirectUrl) {
                            route = response ?.redirectUrl;
                        }
                        swalSuccessWithRedirect(response.message, route);
                    } else {
                        swalError(response.message);
                    }
                },
                error: function (response) {
                    swalError();
                },
            });
        }
    });
    function swalSuccess(message) {
        swal.fire("", message, "success");
    }
    function swalError(message = "Error") {
        swal.fire("", message, "error");
    }
    function swalSuccessWithRedirect(message, url = "/") {
        window.location.href = url;
    }
</script>
@stack('scripts')
</body>
</html>
