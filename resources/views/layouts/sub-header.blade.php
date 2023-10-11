<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-2">
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <h5 class="text-dark font-weight-bold my-1 mr-5">
                    {{ !empty($title)?$title:'' }} </h5>
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a class="text-muted">
                            {{ !empty($directory)?$directory:'' }} </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="text-muted">
                            {{ !empty($title)?$title:'' }} </a>
                    </li>
                    @if(@$action)
                        <li class="breadcrumb-item">
                            <a class="text-muted">
                                {{ $action }} </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="d-flex align-items-center">
            @if(@$create)
                <a href="{{route($create)}}" class="btn btn-light-primary font-weight-bolder btn-sm">
                    <i class="flaticon-add-circular-button"></i> Add New
                </a>
            @endif
            @if(@$back)
                <a href="{{route($back)}}" class="btn  font-weight-bolder btn-sm">
                            <span class="svg-icon svg-icon-warning svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo9\dist/../src/media/svg/icons\Code\Backspace.svg--><svg
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <rect x="0" y="0" width="24" height="24"/>
            <path
                d="M8.42034438,20 L21,20 C22.1045695,20 23,19.1045695 23,18 L23,6 C23,4.8954305 22.1045695,4 21,4 L8.42034438,4 C8.15668432,4 7.90369297,4.10412727 7.71642146,4.28972363 L0.653241109,11.2897236 C0.260966303,11.6784895 0.25812177,12.3116481 0.646887666,12.7039229 C0.648995955,12.7060502 0.651113791,12.7081681 0.653241109,12.7102764 L7.71642146,19.7102764 C7.90369297,19.8958727 8.15668432,20 8.42034438,20 Z"
                fill="#000000" opacity="0.3"/>
        </g>
    </svg></span>
                    Back
                </a>
            @endif
            @if(@$model)
                <button type="button" class="btn btn-light-primary font-weight-bolder btn-sm" data-toggle="modal" data-target="#{{$model}}">
                    <i class="flaticon-add-circular-button"></i> Add New
                </button>
            @endif
        </div>
    </div>
</div>


