<div class="weekly-content" data-day="1">
    <div class="d-flex w-100 align-items-center position-relative border-bottom">
        <div class="d-flex flex-md-row flex-column w-100 weekly-row my-3">
            <div class="col-2 form-check form-check-custom form-check-solid mb-0 checkbox-content d-flex align-items-center">
                <label class="checkbox checkbox-lg"
                       id="chkShortWeekDay_MON">
                    <input type="checkbox" value="1"
                           name="checked_week_days[]">
                    <span></span>
                    &nbsp; &nbsp;Mon
                </label>
            </div>
            <div class="session-times">
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
                        <a type="button" onclick="deleteBtn();">
                            <i class="fa fa-trash ml-5 ms-5 fs-3 text-danger"
                               aria-hidden="true"></i>
                        </a>
                    </div>
                    <span class="error-msg text-danger"></span>
                </div>

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
                    <input type="checkbox" value="2"
                           name="checked_week_days[]">
                    <span></span>
                    &nbsp; &nbsp;Tue
                </label>
            </div>
            <div class="session-times">
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
                        <a type="button" onclick="deleteBtn();">
                            <i class="fa fa-trash ml-5 ms-5 fs-3 text-danger"
                               aria-hidden="true"></i>
                        </a>
                    </div>
                    <span class="error-msg text-danger"></span>
                </div>

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
                    <input type="checkbox" value="3"
                           name="checked_week_days[]">
                    <span></span>
                    &nbsp; &nbsp;Wed
                </label>
            </div>
            <div class="session-times">
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
                        <a type="button" onclick="deleteBtn();">
                            <i class="fa fa-trash ml-5 ms-5 fs-3 text-danger"
                               aria-hidden="true"></i>
                        </a>
                    </div>
                    <span class="error-msg text-danger"></span>
                </div>

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
                    <input type="checkbox" value="4"
                           name="checked_week_days[]">
                    <span></span>
                    &nbsp; &nbsp;Thu
                </label>
            </div>
            <div class="session-times">
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
                        <a type="button" onclick="deleteBtn();">
                            <i class="fa fa-trash ml-5 ms-5 fs-3 text-danger"
                               aria-hidden="true"></i>
                        </a>
                    </div>
                    <span class="error-msg text-danger"></span>
                </div>

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
                    <input type="checkbox" value="5"
                           name="checked_week_days[]">
                    <span></span>
                    &nbsp; &nbsp;Fri
                </label>
            </div>
            <div class="session-times">
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
                        <a type="button" onclick="deleteBtn();">
                            <i class="fa fa-trash ml-5 ms-5 fs-3 text-danger"
                               aria-hidden="true"></i>
                        </a>
                    </div>
                    <span class="error-msg text-danger"></span>
                </div>

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
                    <input type="checkbox" value="6"
                           name="checked_week_days[]">
                    <span></span>
                    &nbsp; &nbsp;Sat
                </label>
            </div>
            <div class="session-times">
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
                        <a type="button" onclick="deleteBtn();">
                            <i class="fa fa-trash ml-5 ms-5 fs-3 text-danger"
                               aria-hidden="true"></i>
                        </a>
                    </div>
                    <span class="error-msg text-danger"></span>
                </div>

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
                    <input type="checkbox" value="7"
                           name="checked_week_days[]">
                    <span></span>
                    &nbsp; &nbsp;Sun
                </label>
            </div>
            <div class="session-times">
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
                        <a type="button" onclick="deleteBtn();">
                            <i class="fa fa-trash ml-5 ms-5 fs-3 text-danger"
                               aria-hidden="true"></i>
                        </a>
                    </div>
                    <span class="error-msg text-danger"></span>
                </div>

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