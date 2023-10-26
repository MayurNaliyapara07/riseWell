<?php

namespace App\Http\Controllers;

use App\Helpers\BaseHelper;
use App\Http\Controllers\Common\BaseController;
use App\Models\Order;
use App\Models\Patients;
use App\Models\Product;
use App\Models\User;
use App\Notifications\OrderPlaced;
use Carbon\Carbon;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Exception;

class HomeController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        session()->forget('patient_data');
        $data['total_provider'] = User::where('user_type', '=', 'Provider')->count();
        $data['total_patients'] = Patients::count();
        $data['total_product'] = Product::count();
        $data['total_order'] = Order::count();
        return view('home')->with(compact('data'));
    }

    public function verify()
    {
        return view('auth.verify');
    }

}
