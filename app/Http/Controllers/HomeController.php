<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Common\BaseController;
use App\Models\Order;
use App\Models\Patients;
use App\Models\Product;
use App\Models\User;
use App\Notifications\OrderPlaced;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

    public function emailTemplate()
    {

        $order = Order::first();
        return view('master.email.order-placed')->with(compact('order'));
    }

    public function payment()
    {
        $data = [
            'accountNumber' => 740561073,
            'labelResponseOptions' => "LABEL",
            "requestedShipment" => [
                "labelSpecification" => [
                    "imageType" => "PDF",
                    "labelStockType" => "PAPER_85X11_TOP_HALF_LABEL",
                    "labelFormatType" => "COMMON2D",
                    "labelOrder" => "SHIPPING_LABEL_FIRST",
                    "customerSpecifiedDetail" => [
                        "maskedData" => [
                            [
                                "value" => "<Error=> Too many levels of nesting to fake this schema>"
                            ],
                            [
                                "value" => "<Error=> Too many levels of nesting to fake this schema>"
                            ]
                        ],
                        "regulatoryLabels" => [
                            [
                                "value" => "<Error=> Too many levels of nesting to fake this schema>"
                            ],
                            [
                                "value" => "<Error=> Too many levels of nesting to fake this schema>"
                            ]
                        ],
                        "additionalLabels" => [
                            [
                                "value" => "<Error=> Too many levels of nesting to fake this schema>"
                            ],
                            [
                                "value" => "<Error=> Too many levels of nesting to fake this schema>"
                            ]
                        ],
                        "docTabContent" => [
                            "value" => "<Error=> Too many levels of nesting to fake this schema>"
                        ],
                    ],
                    "printedLabelOrigin" => [
                        "address" => [
                            "streetLines" => [
                                "10 FedEx Parkway",
                                "Suite 302"
                            ],
                            "city" => "Beverly Hills",
                            "stateOrProvinceCode" => "CA",
                            "postalCode" => "38127",
                            "countryCode" => "US",
                            "residential" => false
                        ],
                        "contact" => [
                            "personName" => "person name",
                            "emailAddress" => "email address",
                            "parsedPersonName" => [
                                "firstName" => "first name",
                                "lastName" => "last name",
                                "middleName" => "middle name",
                                "suffix" => "suffix"
                            ],
                            "phoneNumber" => "phone number",
                            "phoneExtension" => "phone extension",
                            "companyName" => "company name",
                            "faxNumber" => "fax number",
                        ]
                    ],
                    "labelRotation" => "UPSIDE_DOWN",
                    "labelPrintingOrientation" => "TOP_EDGE_OF_TEXT_FIRST",
                    "returnedDispositionDetail" => true
                ],
                "packagingType" => "YOUR_PACKAGING",
                "pickupType" => "USE_SCHEDULED_PICKUP",
                "recipients" => [
                    [
                        "address" => [
                            "streetLines" => [
                                "10 FedEx Parkway",
                                "Suite 302"
                            ],
                            "city" => "Beverly Hills",
                            "stateOrProvinceCode" => "CA",
                            "postalCode" => "90210",
                            "countryCode" => "US",
                            "residential" => false
                        ],
                        "contact" => [
                            "personName" => "John Taylor",
                            "emailAddress" => "sample@company.com",
                            "phoneExtension" => "000",
                            "phoneNumber" => "XXXX345671",
                            "companyName" => "FedEx"
                        ],
                        "tins" => [
                            [
                                "number" => "123567",
                                "tinType" => "FEDERAL",
                                "usage" => "usage",
                                "effectiveDate" => "2000-01-23T04=>56=>07.000+00=>00",
                                "expirationDate" => "2000-01-23T04=>56=>07.000+00=>00"
                            ]
                        ],
                        "deliveryInstructions" => "Delivery Instructions"
                    ],
                ],
                [
                    "address" => [
                        "streetLines" => ["10 FedEx Parkway",
                            "Suite 302"],
                        "city" => "Beverly Hills",
                        "stateOrProvinceCode" => "CA",
                        "postalCode" => "90210",
                        "countryCode" => "US",
                        "residential" => false
                    ],
                    "contact" => [
                        "personName" => "John Taylor",
                        "emailAddress" => "sample@company.com",
                        "phoneExtension" => "000",
                        "phoneNumber" => "XXXX345671",
                        "companyName" => "FedEx"
                    ],
                    "tins" => [
                        [
                            "number" => "123567",
                            "tinType" => "FEDERAL",
                            "usage" => "usage",
                            "effectiveDate" => "2000-01-23T04=>56=>07.000+00=>00",
                            "expirationDate" => "2000-01-23T04=>56=>07.000+00=>00"
                        ]
                    ],
                    "deliveryInstructions" => "Delivery Instructions"
                ]],
        ];
        $fedex = Http::post('https=>//apis-sandbox.fedex.com/ship/v1/shipments');

    }

}
