<?php

namespace App\Http\Controllers\Common;

use App\Helpers\BaseHelper;
use App\Http\Controllers\Controller;
use App\Models\BaseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CommonController extends Controller
{

    protected $_base_model;
    protected $_base_helper;

    public function __construct()
    {
        $this->_base_model = new BaseModel();
        $this->_base_helper = new BaseHelper();
    }

    public function getProduct(){
        $searchTerm = request()->input('searchTerm');
        $orderType = request()->input('orderType');
        $productQuery = DB::table('product')->select(DB::raw('product.stripe_plan as id'),
            DB::raw('product.product_name as text'))
            ->whereRaw("(product_name like '%$searchTerm%')")
            ->where('type','=',$orderType)
            ->where('status','=','1')
            ->orderBy('product_name', 'ASC')
            ->limit(10)->get()->toArray();

        return response()->json($productQuery);
    }

    public function getLabCategory(){
        $searchTerm = request()->input('searchTerm');
        $categoryQuery = DB::table('category')->select(DB::raw('category.category_id as id'),
            DB::raw('category.category_name as text'))
            ->whereRaw("(category_name like '%$searchTerm%')")
            ->orderBy('category_name', 'ASC')
            ->limit(10)->get()->toArray();

        return response()->json($categoryQuery);
    }


    public function getCategory(){
        $searchTerm = request()->input('searchTerm');
        $categoryQuery = DB::table('frontend_category')->select(DB::raw('frontend_category.f_category_id as id'),
            DB::raw('frontend_category.category_name as text'))
            ->whereRaw("(category_name like '%$searchTerm%')")
            ->orderBy('category_name', 'ASC')
            ->limit(10)->get()->toArray();

        return response()->json($categoryQuery);
    }

    public function getCountry()
    {
        $searchTerm = request()->input('searchTerm');
        $countryQuery = DB::table('country')->select(DB::raw('country.country_id as id'),
            DB::raw('country.country_name as text'))
            ->whereRaw("(country_name like '%$searchTerm%')")
            ->orderBy('country_name', 'ASC')
            ->limit(10)->get()->toArray();

        return response()->json($countryQuery);
    }

    public function getCountryCode(){
        $searchTerm = request()->input('searchTerm');
        $countryQuery = DB::table('country')->select(DB::raw('country.code as id'),
            DB::raw('country.country_name as text'))
            ->whereRaw("(country_name like '%$searchTerm%')")
            ->orderBy('country_name', 'ASC')
            ->limit(10)->get()->toArray();

        return response()->json($countryQuery);
    }

    public function getState()
    {
        $searchTerm = request()->input('searchTerm');
        $stateQuery = DB::table('state')->select(DB::raw('state.state_id as id'),
            DB::raw('state.state_name as text'))
            ->whereRaw("(state_name like '%$searchTerm%')")
            ->where('country_id', '=',231)
            ->orderBy('state_name', 'ASC')
            ->limit(10)->get()->toArray();

        return response()->json($stateQuery);
    }

    public function getEvent(){
        $searchTerm = request()->input('searchTerm');
        $eventQuery = DB::table('event')->select(DB::raw('event.event_id as id'),
            DB::raw('event.event_name as text'))
            ->whereRaw("(event_name like '%$searchTerm%')")
            ->orderBy('event_name', 'ASC')
            ->limit(10)->get()->toArray();
        return response()->json($eventQuery);
    }

    public function getAssignProgram()
    {
        $searchTerm = request()->input('searchTerm');
        $assignProgramQuery = DB::table('assign_program')
            ->select(DB::raw('assign_program.assign_program_id as id'), DB::raw("event.event_name as text"))
            ->join('event','event.event_id','=','assign_program.event_id')
            ->whereRaw("(event.event_name like '%$searchTerm%')")
            ->where('assign_program.status',true)
            ->orderBy('assign_program.user_id', 'ASC')
            ->limit(10)->get()->toArray();

        return response()->json($assignProgramQuery);
    }

    public function getProvider()
    {
        $searchTerm = request()->input('searchTerm');
        $patientStateId = empty(request()->input('patient_state_id')) ? 0 : request()->input('patient_state_id');
        $stateQuery = DB::table('users')->select(DB::raw('users.id as id'),
            DB::raw("CONCAT(users.first_name,' ',users.last_name) as text"))
            ->join('state_of_lic','state_of_lic.user_id','=','users.id')
            ->whereRaw("(first_name like '%$searchTerm%')")
            ->where('state_of_lic.state_id',$patientStateId)
            ->where('users.user_type','Provider')
            ->orderBy('users.first_name', 'ASC')
            ->limit(10)->get()->toArray();
        return response()->json($stateQuery);
    }

    public function getSessionTime(Request $request){
        $day = $request->day_id;
        $rowId = mt_rand(1000000000,9999999999);
        $workingHours = $this->_base_model->makeOpeningHoursOptions();
        if (!empty($day)){
            $html = '<div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot" id="create_'.$rowId.'">
                <div class="d-flex align-items-center mb-3 add-slot">
                <div class="col-md-6">
                <select class="form-control" name="startTimes['.$day.'][]">
                <option value=""></option>';
            foreach ($workingHours as $key=>$value) {$html.='<option value="'.$value.'">'.$value.'</option>';}
            $html.='</select></div><span class="small-border me-3">-</span>
                <div class="col-md-6">
                <select class="form-control" name="endTimes['.$day.'][]">
                <option value=""></option>';
            foreach ($workingHours as $key=>$value) {$html.='<option value="'.$value.'">'.$value.'</option>';}
            $html.='</select></div>
                <a type="button" onclick="deleteBtn('.$rowId.');">
                <i class="fa fa-trash ml-5 ms-5 fs-3 text-danger" aria-hidden="true"></i>
                </a>
                </div>
                <span class="error-msg text-danger"></span>
                </div>';
            return response()->json(['data'=>$html,'day_id'=>$request->day_id],200);
        }
    }





}

