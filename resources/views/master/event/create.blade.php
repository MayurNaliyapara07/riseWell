@extends('layouts.app')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @include('layouts.sub-header', [
             'title' => 'Event',
             'directory'=> 'master',
             'action'=>'Create',
             'back' => 'event'
        ])
        <div class="container">
            <div class="row">
                <div class="col-lg-12">


                    <div class="card card-custom gutter-b example example-compact">

                        <!--begin::Form-->
                        <form action="{{(isset($event))?route('event.update',$event->event_id):route('event.store')}}"
                              method="post" enctype="multipart/form-data" class="ajax-form">
                            @csrf
                            @if(isset($event))
                                @method('PUT')
                            @endif
                            <div class="card-body">


                                <div class="card-body">


                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Event Name<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <input type="text" name="event_name" autocomplete="off"
                                                   class="form-control required"
                                                   placeholder="Event Name" data-msg-required="Event Name is required"
                                                   value="{{isset($event)?$event->event_name:old('event_name')}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Location<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <select name="location_type" class="form-control required" id="location"
                                                    data-msg-required="Location is required">
                                                <option value="">Select Location</option>
                                                @foreach($locationType as $location)
                                                    <option value="{{$location['value']}}" {{ isset($event) && $event->location_type == $location['value'] ? 'selected' : ''}}>
                                                        {{$location['label']}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row " id="showLocation">

                                        <label class="col-lg-3 col-form-label">Address<span class="text-danger"></span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <textarea name="location" class="form-control summernote"
                                                      rows="5">{{!empty($event)&&$event->location?$event->location:old('location')}}</textarea>
                                        </div>

                                    </div>
                                    <div class="form-group row " id="showPhoneNo">
                                        <label class="col-lg-3 col-form-label ">Phone No<span
                                                class="text-danger"></span></label>
                                        <div class="col-lg-6">
                                            <input type="text" name="phone_no" autocomplete="off"
                                                   class="form-control"
                                                   placeholder="Phone No"
                                                   value="{{isset($event)?$event->phone_no:old('phone_no')}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Description/Instructions <span
                                                class="text-danger"></span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <textarea name="description" class="form-control "
                                                      rows="3">{{!empty($event)&&$event->description?$event->description:old('description')}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Color<span
                                                class="text-danger"></span></label>
                                        <div class="col-9 col-form-label">
                                            <div class="radio-inline">
                                                <label class="radio radio-lg radio-danger">
                                                    <input type="radio" name="color" checked="checked"
                                                           value="red" {{ !empty($event) && $event->color=="red" ? "checked" : "" }}/>
                                                    <span></span>
                                                    Red
                                                </label>
                                                <label class="radio radio-lg radio-info">
                                                    <input type="radio" name="color"
                                                           value="violet" {{ !empty($event) && $event->color=="violet" ? "checked" : "" }}/>
                                                    <span></span>
                                                    Violet
                                                </label>
                                                <label class="radio radio-lg radio-primary ">
                                                    <input type="radio" name="color"
                                                           value="blue" {{ !empty($event) && $event->color=="blue" ? "checked" : "" }}/>
                                                    <span></span>
                                                    Blue
                                                </label>
                                                <label class="radio radio-lg radio-success ">
                                                    <input type="radio" name="color"
                                                           value="green" {{ !empty($event) &&  $event->color=="green" ? "checked" : "" }}/>
                                                    <span></span>
                                                    Green
                                                </label>
                                                <label class="radio radio-lg radio-dark ">
                                                    <input type="radio" name="color"
                                                           value="black" {{ !empty($event) && $event->color=="black" ? "checked" : "" }}/>
                                                    <span></span>
                                                    Black
                                                </label>
                                                <label class="radio radio-lg radio-warning ">
                                                    <input type="radio" name="color"
                                                           value="yellow" {{ !empty($event) && $event->color=="yellow" ? "checked" : "" }}/>
                                                    <span></span>
                                                    Yellow
                                                </label>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Date Range<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-2">
                                            <input type="text" name="day" autocomplete="off"
                                                   class="form-control"
                                                   placeholder="Day"
                                                   value="60">
                                        </div>
                                        <div class="col-lg-2">
                                            <select name="day_type" class="form-control">
                                                <option value="calender-days" {{(isset($event)&& $event->day_type=='calender-days')?'selected':old('calender-days')}}>
                                                    Calendar Days
                                                </option>
                                                <option value="week-days" {{(isset($event)&& $event->day_type=='week-days')?'selected':old('week-days')}}>
                                                    Week Days
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Duration<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <select name="duration" class="form-control required" id="duration">
                                                <option value="">Select Duration</option>
                                                @foreach($duration as $dur)
                                                    <option value="{{$dur['value']}}" {{ isset($event) && $event->duration == $dur['value'] ? 'selected' : ''}}>{{$dur['label']}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="showCustomDuration">
                                        <label class="col-lg-3 col-form-label "><span
                                                class="text-danger"></span></label>
                                        <div class="col-lg-2">
                                            <input type="text" name="custom_duration" autocomplete="off"
                                                   class="form-control"
                                                   placeholder="Duration"
                                                   value="{{isset($event)?$event->custom_duration:old('custom_duration')}}">
                                        </div>
                                        <div class="col-lg-2">
                                            <select name="custom_duration_type" class="form-control">
                                                <option value="">Select..</option>
                                                <option value="min" {{(isset($event)&& $event->custom_duration_type=='min')?'selected':old('min')}}>
                                                    Min
                                                </option>
                                                <option value="hrs" {{(isset($event)&& $event->custom_duration_type=='hrs')?'selected':old('hrs')}}>
                                                    Hrs
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <?php
                                    $eventId = !empty($event)?$event->event_id:'';
                                    $day1 = \Illuminate\Support\Facades\DB::table('event_available_times')->where('event_id', $eventId)->where('day', 1)->get();
                                    $day2 = \Illuminate\Support\Facades\DB::table('event_available_times')->where('event_id', $eventId)->where('day', 2)->get();
                                    $day3 = \Illuminate\Support\Facades\DB::table('event_available_times')->where('event_id', $eventId)->where('day', 3)->get();
                                    $day4 = \Illuminate\Support\Facades\DB::table('event_available_times')->where('event_id', $eventId)->where('day', 4)->get();
                                    $day5 = \Illuminate\Support\Facades\DB::table('event_available_times')->where('event_id', $eventId)->where('day', 5)->get();
                                    $day6 = \Illuminate\Support\Facades\DB::table('event_available_times')->where('event_id', $eventId)->where('day', 6)->get();
                                    $day7 = \Illuminate\Support\Facades\DB::table('event_available_times')->where('event_id', $eventId)->where('day', 7)->get();

                                    ?>


                                    <div class="weekly-content" data-day="1">
                                        <div class="d-flex w-100 align-items-center position-relative border-bottom">
                                            <div class="d-flex flex-md-row flex-column w-100 weekly-row my-3">
                                                <div class="col-2 form-check form-check-custom form-check-solid mb-0 checkbox-content d-flex align-items-center">
                                                    <label class="checkbox checkbox-lg"
                                                           id="chkShortWeekDay_MON">
                                                        <input type="checkbox" value="1"
                                                               name="checked_week_days[]" {{count($day1) > 0?'checked':''}}>
                                                        <span></span>
                                                        &nbsp; &nbsp;Mon
                                                    </label>
                                                </div>
                                                <div class="session-times">
                                                    @forelse($day1 as $val)
                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot" id="{{$val->event_available_times_id}}">
                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="startTimes[1][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}" {{$value == $val->start_time ? 'selected':''}}>{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <span class="small-border me-3">-</span>
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="endTimes[1][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}" {{$value == $val->end_time ? 'selected':''}}>{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <a type="button" onclick="deleteBtn({{$val->event_available_times_id}});">
                                                                    <i class="fa fa-trash ml-5 ms-5 fs-3 text-danger"
                                                                       aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                            <span class="error-msg text-danger"></span>
                                                        </div>
                                                    @empty
                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot">
                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="startTimes[1][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <span class="small-border me-3">-</span>
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="endTimes[1][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <span class="error-msg text-danger"></span>
                                                        </div>
                                                    @endforelse
                                                </div>
                                            </div>

                                            <div class="weekly-icon position-absolute end-0 d-flex">
                                                <button type="button" title="plus"
                                                        class="btn px-2 text-gray-600 fs-2 add-session-time">
                                                    <i class="fa fa-plus ms-5 fs-3 text-dark"
                                                       aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="weekly-content" data-day="2">
                                        <div class="d-flex w-100 align-items-center position-relative border-bottom">
                                            <div class="d-flex flex-md-row flex-column w-100 weekly-row my-3">
                                                <div class="col-2 form-check form-check-custom form-check-solid mb-0 checkbox-content d-flex align-items-center">
                                                    <label class="checkbox checkbox-lg"
                                                           id="chkShortWeekDay_TUE">
                                                        <input type="checkbox" value="2" {{count($day2) > 0?'checked':''}}
                                                        name="checked_week_days[]">
                                                        <span></span>
                                                        &nbsp; &nbsp;Tue
                                                    </label>
                                                </div>
                                                <div class="session-times">

                                                    @forelse($day2 as $val)
                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot" id="{{$val->event_available_times_id}}">
                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="startTimes[2][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}" {{$value == $val->start_time ? 'selected':''}}>{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <span class="small-border me-3">-</span>
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="endTimes[2][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}" {{$value == $val->end_time ? 'selected':''}}>{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <a type="button" onclick="deleteBtn({{$val->event_available_times_id}});">
                                                                    <i class="fa fa-trash ml-5 ms-5 fs-3 text-danger"
                                                                       aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                            <span class="error-msg text-danger"></span>
                                                        </div>
                                                    @empty
                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot">
                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="startTimes[2][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <span class="small-border me-3">-</span>
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="endTimes[2][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                            </div>
                                                            <span class="error-msg text-danger"></span>
                                                        </div>
                                                    @endforelse
                                                </div>
                                            </div>

                                            <div class="weekly-icon position-absolute end-0 d-flex">
                                                <button type="button" title="plus"
                                                        class="btn px-2 text-gray-600 fs-2 add-session-time">
                                                    <i class="fa fa-plus ms-5 fs-3 text-dark"
                                                       aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="weekly-content" data-day="3">
                                        <div class="d-flex w-100 align-items-center position-relative border-bottom">
                                            <div class="d-flex flex-md-row flex-column w-100 weekly-row my-3">
                                                <div class="col-2 form-check form-check-custom form-check-solid mb-0 checkbox-content d-flex align-items-center">
                                                    <label class="checkbox checkbox-lg"
                                                           id="chkShortWeekDay_WED">
                                                        <input type="checkbox" value="3" {{count($day3) > 0 ?'checked':''}}
                                                        name="checked_week_days[]">
                                                        <span></span>
                                                        &nbsp; &nbsp;Wed
                                                    </label>
                                                </div>
                                                <div class="session-times">

                                                    @forelse($day3 as $val)

                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot">
                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="startTimes[3][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}" {{$value == $val->start_time ? 'selected':''}}>{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <span class="small-border me-3">-</span>
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="endTimes[3][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}" {{$value == $val->end_time ? 'selected':''}}>{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <a type="button" onclick="deleteBtn();">
                                                                    <i class="fa fa-trash ml-5 ms-5 fs-3 text-danger"
                                                                       aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                            <span class="error-msg text-danger"></span>
                                                        </div>

                                                    @empty

                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot">
                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="startTimes[3][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <span class="small-border me-3">-</span>
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="endTimes[3][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                            </div>
                                                            <span class="error-msg text-danger"></span>
                                                        </div>

                                                    @endforelse

                                                </div>
                                            </div>

                                            <div class="weekly-icon position-absolute end-0 d-flex">
                                                <button type="button" title="plus"
                                                        class="btn px-2 text-gray-600 fs-2 add-session-time">
                                                    <i class="fa fa-plus ms-5 fs-3 text-dark"
                                                       aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="weekly-content" data-day="4">
                                        <div class="d-flex w-100 align-items-center position-relative border-bottom">
                                            <div class="d-flex flex-md-row flex-column w-100 weekly-row my-3">
                                                <div class="col-2 form-check form-check-custom form-check-solid mb-0 checkbox-content d-flex align-items-center">
                                                    <label class="checkbox checkbox-lg"
                                                           id="chkShortWeekDay_THU">
                                                        <input type="checkbox" value="4" {{count($day4) > 0?'checked':''}}
                                                        name="checked_week_days[]">
                                                        <span></span>
                                                        &nbsp; &nbsp;Thu
                                                    </label>
                                                </div>
                                                <div class="session-times">

                                                    @forelse($day4 as $val)
                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot">
                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="startTimes[4][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}" {{$value == $val->start_time ? 'selected':''}}>{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <span class="small-border me-3">-</span>
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="endTimes[4][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}" {{$value == $val->end_time ? 'selected':''}}>{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <a type="button" onclick="deleteBtn();">
                                                                    <i class="fa fa-trash ml-5 ms-5 fs-3 text-danger"
                                                                       aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                            <span class="error-msg text-danger"></span>
                                                        </div>
                                                    @empty
                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot">
                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="startTimes[4][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <span class="small-border me-3">-</span>
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="endTimes[4][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                            </div>
                                                            <span class="error-msg text-danger"></span>
                                                        </div>
                                                    @endforelse
                                                </div>
                                            </div>

                                            <div class="weekly-icon position-absolute end-0 d-flex">
                                                <button type="button" title="plus"
                                                        class="btn px-2 text-gray-600 fs-2 add-session-time">
                                                    <i class="fa fa-plus ms-5 fs-3 text-dark"
                                                       aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="weekly-content" data-day="5">
                                        <div class="d-flex w-100 align-items-center position-relative border-bottom">
                                            <div class="d-flex flex-md-row flex-column w-100 weekly-row my-3">
                                                <div class="col-2 form-check form-check-custom form-check-solid mb-0 checkbox-content d-flex align-items-center">
                                                    <label class="checkbox checkbox-lg"
                                                           id="chkShortWeekDay_FRI">
                                                        <input type="checkbox" value="5"  {{count($day5) > 0?'checked':''}}
                                                        name="checked_week_days[]">
                                                        <span></span>
                                                        &nbsp; &nbsp;Fri
                                                    </label>
                                                </div>
                                                <div class="session-times">

                                                    @forelse($day5 as $val)
                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot">
                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="startTimes[5][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}" {{$value == $val->start_time ? 'selected':''}}>{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <span class="small-border me-3">-</span>
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="endTimes[5][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}" {{$value == $val->end_time ? 'selected':''}}>{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <a type="button" onclick="deleteBtn();">
                                                                    <i class="fa fa-trash ml-5 ms-5 fs-3 text-danger"
                                                                       aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                            <span class="error-msg text-danger"></span>
                                                        </div>
                                                    @empty
                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot">
                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="startTimes[5][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <span class="small-border me-3">-</span>
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="endTimes[5][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                            </div>
                                                            <span class="error-msg text-danger"></span>
                                                        </div>
                                                    @endforelse

                                                </div>
                                            </div>

                                            <div class="weekly-icon position-absolute end-0 d-flex">
                                                <button type="button" title="plus"
                                                        class="btn px-2 text-gray-600 fs-2 add-session-time">
                                                    <i class="fa fa-plus ms-5 fs-3 text-dark"
                                                       aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="weekly-content" data-day="6">
                                        <div class="d-flex w-100 align-items-center position-relative border-bottom">
                                            <div class="d-flex flex-md-row flex-column w-100 weekly-row my-3">
                                                <div class="col-2 form-check form-check-custom form-check-solid mb-0 checkbox-content d-flex align-items-center">
                                                    <label class="checkbox checkbox-lg"
                                                           id="chkShortWeekDay_SAT">
                                                        <input type="checkbox" value="6" {{count($day6) > 0 ?'checked':''}}
                                                        name="checked_week_days[]">
                                                        <span></span>
                                                        &nbsp; &nbsp;Sat
                                                    </label>
                                                </div>
                                                <div class="session-times">
                                                    @forelse($day6 as $val)
                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot">
                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="startTimes[6][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}" {{$value == $val->start_time ? 'selected':''}}>{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <span class="small-border me-3">-</span>
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="endTimes[6][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}" {{$value == $val->end_time ? 'selected':''}}>{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <a type="button" onclick="deleteBtn();">
                                                                    <i class="fa fa-trash ml-5 ms-5 fs-3 text-danger"
                                                                       aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                            <span class="error-msg text-danger"></span>
                                                        </div>
                                                    @empty
                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot">
                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="startTimes[6][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <span class="small-border me-3">-</span>
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="endTimes[6][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                            </div>
                                                            <span class="error-msg text-danger"></span>
                                                        </div>
                                                    @endforelse
                                                </div>
                                            </div>

                                            <div class="weekly-icon position-absolute end-0 d-flex">
                                                <button type="button" title="plus"
                                                        class="btn px-2 text-gray-600 fs-2 add-session-time">
                                                    <i class="fa fa-plus ms-5 fs-3 text-dark"
                                                       aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="weekly-content" data-day="7">
                                        <div class="d-flex w-100 align-items-center position-relative border-bottom">
                                            <div class="d-flex flex-md-row flex-column w-100 weekly-row my-3">
                                                <div class="col-2 form-check form-check-custom form-check-solid mb-0 checkbox-content d-flex align-items-center">
                                                    <label class="checkbox checkbox-lg"
                                                           id="chkShortWeekDay_SUN">
                                                        <input type="checkbox" value="7" {{count($day7) > 0 ?'checked':''}}
                                                        name="checked_week_days[]">
                                                        <span></span>
                                                        &nbsp; &nbsp;Sun
                                                    </label>
                                                </div>
                                                <div class="session-times">

                                                    @forelse($day7 as $val)
                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot">
                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="startTimes[7][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}" {{$value == $val->start_time ? 'selected':''}}>{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <span class="small-border me-3">-</span>
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="endTimes[7][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}" {{$value == $val->end_time ? 'selected':''}}>{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <a type="button" onclick="deleteBtn();">
                                                                    <i class="fa fa-trash ml-5 ms-5 fs-3 text-danger"
                                                                       aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                            <span class="error-msg text-danger"></span>
                                                        </div>
                                                    @empty
                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot">
                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="startTimes[7][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <span class="small-border me-3">-</span>
                                                                <div class="col-md-6">
                                                                    <select class="form-control"
                                                                            name="endTimes[7][]">
                                                                        <option value=""></option>
                                                                        @foreach($workingHours as $value)
                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                            </div>
                                                            <span class="error-msg text-danger"></span>
                                                        </div>
                                                    @endforelse

                                                </div>
                                            </div>

                                            <div class="weekly-icon position-absolute end-0 d-flex">
                                                <button type="button" title="plus"
                                                        class="btn px-2 text-gray-600 fs-2 add-session-time">
                                                    <i class="fa fa-plus ms-5 fs-3 text-dark"
                                                       aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>


                                </div>

                                <div class="card-footer">
                                    <div class="row">
                                        <button id="form_submit" class="btn btn-primary mr-2"><i
                                                class="fas fa-save"></i>Save
                                        </button>
                                        <button type="reset" class="btn btn-danger"><i
                                                class="fas fa-times"></i>Reset
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
@push('styles')
    <style>
        .align-items-center {
            align-items: center !important;
        }

        .w-100 {
            width: 100% !important;
        }

        .border-bottom {
            border-bottom: 1px solid #dee2e6 !important;
        }

        .position-relative {
            position: relative !important;
        }

        .d-flex {
            display: flex !important;
        }

        @media (min-width: 768px) {
            .flex-md-row {
                flex-direction: row !important;
            }
        }

        .my-3 {
            margin-top: 0.75rem !important;
            margin-bottom: 0.75rem !important;
        }

        .flex-column {
            flex-direction: column !important;
        }

        .d-flex {
            display: flex !important;
        }

        .end-0 {
            right: 0 !important;
        }

        .position-absolute {
            position: absolute !important;
        }

        .d-flex {
            display: flex !important;
        }

        .fs-2 {
            font-size: 1.25rem !important;
        }

        .px-2 {
            padding-right: 0.5rem !important;
            padding-left: 0.5rem !important;
        }
    </style>
@endpush
@push('scripts')
    <script src="{{asset('assets/js/pages/crud/file-upload/image-input.js')}}"></script>
    <script src="{{asset('assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}"></script>
    <script>
        $('.summernote').summernote({
            height: 150
        });
        $('#stateSelect2').select2({
            placeholder: "Select a state"
        });
        $('#billingStateSelect2').select2({
            placeholder: "Select a state"
        });
        $('#shippingStateSelect2').select2({
            placeholder: "Select a state"
        });
        $('#dob').datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            format: 'dd/mm/yyyy',
            orientation: "bottom left",
            templates: arrows = {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
        });
        $('#profile_claimed').datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            format: 'dd/mm/yyyy',
            orientation: "bottom left",
            templates: arrows = {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
        });
        $('#showLocation').hide();
        $('#showPhoneNo').hide();
        $('#location').on('change', function () {
            var selectLocation = this.value;
            if (selectLocation == 'In-Metting') {
                $('#showLocation').show();
                $('#showPhoneNo').hide();
            } else if (selectLocation == 'Call') {
                $('#showLocation').hide();
                $('#showPhoneNo').show();
            } else {
                $('#showLocation').hide();
                $('#showPhoneNo').hide();
                $('#duration select option[value="Custom"]').prop('selected', true);
            }
        });
        $('#showCustomDuration').hide();
        $('#duration').on('change', function () {
            var selectDuration = this.value;
            if (selectDuration == 'Custom') {
                $('#showCustomDuration').show();
            } else {
                $('#showCustomDuration').hide();
            }
        });

    </script>
    <script>

        @php
            if(!empty($event->location_type) && $event->location_type == 'In-Metting') {
        @endphp
        $("#showLocation").show();
        @php } @endphp
        @php
            if(!empty($event->location_type)&&$event->location_type == 'Call')
            {
        @endphp
        $("#showPhoneNo").show();
        @php
            }
        @endphp

        @php
            if(!empty($event->duration) && $event->duration == 'Custom') {
        @endphp
        $("#showCustomDuration").show();
        @php } @endphp

    </script>
    <script>
        function deleteBtn(clickId) {
            $.ajax({
                url: "/delete-working-hours",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    id: clickId,
                },
                success: function (response) {
                    if(response.status == true){
                        $('#'+response.id).hide();
                    } else{
                        $('#create_'+clickId).hide();
                    }
                }
            });
        }

    </script>

@endpush
