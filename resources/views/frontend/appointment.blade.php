@extends('layouts.frontend')
@section('content')
<section>
    <div class="book-section">
        <div class="container">

            <h1>Appointment</h1>
            <div class="form-block">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <label for="">Schedule Name</label>
                            <input type="text" class="form-control" placeholder="Please enter your schedule name"
                                   name="" value="">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <label for="">Date</label>
                            <input type="date" class="form-control" placeholder="" name="" value="">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <label for="">Time Slots</label>
                        <ul class="radio-button">
                            <li>
                                <input type="radio" name="slots" id="radio1" class="css-radio">
                                <label for="radio1" class="css-radiobtn">10:00 - 10:15</label>
                            </li>
                            <li>
                                <input type="radio" name="slots" id="radio2" class="css-radio">
                                <label for="radio2" class="css-radiobtn">10:15 - 10:30</label>
                            </li>
                            <li>
                                <input type="radio" name="slots" id="radio3" class="css-radio">
                                <label for="radio3" class="css-radiobtn">10:30 - 10:45</label>
                            </li>
                            <li>
                                <input type="radio" name="slots" id="radio4" class="css-radio">
                                <label for="radio4" class="css-radiobtn">10:45 - 11:00</label>
                            </li>
                            <li>
                                <input type="radio" name="slots" id="radio5" class="css-radio">
                                <label for="radio5" class="css-radiobtn">11:00 - 11:15</label>
                            </li>
                            <li>
                                <input type="radio" name="slots" id="radio6" class="css-radio">
                                <label for="radio6" class="css-radiobtn">11:15 - 11:30</label>
                            </li>
                            <li>
                                <input type="radio" name="slots" id="radio7" class="css-radio">
                                <label for="radio7" class="css-radiobtn">11:30 - 11:45</label>
                            </li>
                            <li>
                                <input type="radio" name="slots" id="radio8" class="css-radio">
                                <label for="radio8" class="css-radiobtn">11:45 - 12:00</label>
                            </li>
                            <li>
                                <input type="radio" name="slots" id="radio9" class="css-radio">
                                <label for="radio9" class="css-radiobtn">12:00 - 12:15</label>
                            </li>
                            <li>
                                <input type="radio" name="slots" id="radio10" class="css-radio">
                                <label for="radio10" class="css-radiobtn">12:15 - 12:30</label>
                            </li>
                            <li>
                                <input type="radio" name="slots" id="radio11" class="css-radio">
                                <label for="radio11" class="css-radiobtn">12:30 - 12:45</label>
                            </li>
                            <li>
                                <input type="radio" name="slots" id="radio12" class="css-radio">
                                <label for="radio12" class="css-radiobtn">12:45 - 13:00</label>
                            </li>

                        </ul>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea name="name" class="form-control" rows="5" cols="80"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label for="">Patients Name</label>
                            <input type="text" class="form-control" placeholder="Please enter your patients name"
                                   name="" value="">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <a href="#" class="btn-book">Book Now</a>
                    </div>
                </div>


            </div>
        </div>
    </div>
</section>
@endsection
