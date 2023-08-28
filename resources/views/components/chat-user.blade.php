
<div class="d-flex align-items-center justify-content-between mb-5" data-user-id="{{$patients->patients_id}}">
    <div class="d-flex align-items-center">
        <div class="symbol symbol-circle symbol-50 mr-3">
            <img alt="Pic" src="{{!empty($patients->image) ? asset('/uploads/images/patients/'.$patients->image) : asset('assets/media/users/blank.png')}}">
        </div>
        <div class="d-flex flex-column">
            <a href="{{url('chat',$patients->patients_id)}}" class="text-dark-75 text-hover-primary font-weight-bold font-size-lg">{{!empty($patients)?$patients->first_name."".$patients->last_name:""}}</a>
            <span class="text-muted font-weight-bold font-size-sm">{{!empty($patients)?$patients->email:""}}</span>
        </div>
    </div>

    <div class="d-flex flex-column align-items-end">
{{--        <span class="text-muted font-weight-bold font-size-sm">35 mins</span>--}}
    </div>
</div>

