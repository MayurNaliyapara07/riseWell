<div class="d-flex flex-column mb-5 align-items-end">
    <div class="d-flex align-items-center">
        <div>
            <span class="text-muted font-size-sm">{{\Carbon\Carbon::parse($msg->created_at)->diffForHumans(null, true)}}</span>
            <a href="#"
               class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">You</a>
        </div>
        <div class="symbol symbol-circle symbol-40 ml-3">
            <img alt="Pic"
                 src="{{asset('/uploads/images/patients/'.$msg->image)}}">
        </div>
    </div>
    <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">
        {{!empty($msg->content)?$msg->content:''}}
    </div>
</div>
