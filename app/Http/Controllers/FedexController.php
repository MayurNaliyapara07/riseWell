<?php

namespace App\Http\Controllers;


use FedEx\ShipService;
use FedEx\ShipService\ComplexType;
use FedEx\ShipService\SimpleType;




class FedexController extends Controller
{

    protected $FEDEX_KEY;
    protected $FEDEX_PASSWORD;
    protected $FEDEX_ACCOUNT_NUMBER;
    protected $FEDEX_METER_NUMBER;

    public function __construct()
    {
        $this->FEDEX_KEY = config('constants.fedex.FEDEX_KEY');
        $this->FEDEX_PASSWORD = config('constants.fedex.FEDEX_PASSWORD');
        $this->FEDEX_ACCOUNT_NUMBER = config('constants.fedex.FEDEX_ACCOUNT_NUMBER');
        $this->FEDEX_METER_NUMBER = config('constants.fedex.FEDEX_METER_NUMBER');
    }

//    public function create()
//    {
//
//        $rateRequest = new ComplexType\RateRequest();
//
//        //authentication & client details
//        $rateRequest->WebAuthenticationDetail->UserCredential->Key = $this->FEDEX_KEY;
//        $rateRequest->WebAuthenticationDetail->UserCredential->Password = $this->FEDEX_PASSWORD;
//        $rateRequest->ClientDetail->AccountNumber = $this->FEDEX_ACCOUNT_NUMBER;
//        $rateRequest->ClientDetail->MeterNumber = $this->FEDEX_METER_NUMBER;
//
//
//        $rateRequest->TransactionDetail->CustomerTransactionId = 'testing rate service request';
//
//        //version
//        $rateRequest->Version->ServiceId = 'crs';
//        $rateRequest->Version->Major = 31;
//        $rateRequest->Version->Minor = 0;
//        $rateRequest->Version->Intermediate = 0;
//        $rateRequest->ReturnTransitAndCommit = true;
//
//        //shipper
//        $rateRequest->RequestedShipment->PreferredCurrency = 'USD';
//        $rateRequest->RequestedShipment->Shipper->Address->StreetLines = ['10 Fed Ex Pkwy'];
//        $rateRequest->RequestedShipment->Shipper->Address->City = 'Memphis';
//        $rateRequest->RequestedShipment->Shipper->Address->StateOrProvinceCode = 'TN';
//        $rateRequest->RequestedShipment->Shipper->Address->PostalCode = 38115;
//        $rateRequest->RequestedShipment->Shipper->Address->CountryCode = 'US';
//
//        //recipient
//        $rateRequest->RequestedShipment->Recipient->Address->StreetLines = ['13450 Farmcrest Ct'];
//        $rateRequest->RequestedShipment->Recipient->Address->City = 'Herndon';
//        $rateRequest->RequestedShipment->Recipient->Address->StateOrProvinceCode = 'VA';
//        $rateRequest->RequestedShipment->Recipient->Address->PostalCode = 20171;
//        $rateRequest->RequestedShipment->Recipient->Address->CountryCode = 'US';
//
//        //shipping charges payment
//        $rateRequest->RequestedShipment->ShippingChargesPayment->PaymentType = SimpleType\PaymentType::_SENDER;
//
//        //rate request types
//        $rateRequest->RequestedShipment->RateRequestTypes = [SimpleType\RateRequestType::_PREFERRED, SimpleType\RateRequestType::_LIST];
//
//        $rateRequest->RequestedShipment->PackageCount = 2;
//
//        //create package line items
//        $rateRequest->RequestedShipment->RequestedPackageLineItems = [new ComplexType\RequestedPackageLineItem(), new ComplexType\RequestedPackageLineItem()];
//
//        //package 1
//        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Value = 2;
//        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Units = SimpleType\WeightUnits::_LB;
//        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Length = 10;
//        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Width = 10;
//        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Height = 3;
//        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Units = SimpleType\LinearUnits::_IN;
//        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->GroupPackageCount = 1;
//
//        //package 2
//        $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Weight->Value = 5;
//        $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Weight->Units = SimpleType\WeightUnits::_LB;
//        $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Length = 20;
//        $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Width = 20;
//        $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Height = 10;
//        $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Units = SimpleType\LinearUnits::_IN;
//        $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->GroupPackageCount = 1;
//
//        $rateServiceRequest = new Request();
//        $rateReply = $rateServiceRequest->getGetRatesReply($rateRequest); // send true as the 2nd argument to return the SoapClient's stdClass response.
//
//        if (!empty($rateReply->RateReplyDetails)) {
//            foreach ($rateReply->RateReplyDetails as $rateReplyDetail) {
//                var_dump($rateReplyDetail->ServiceType);
//                if (!empty($rateReplyDetail->RatedShipmentDetails)) {
//                    foreach ($rateReplyDetail->RatedShipmentDetails as $ratedShipmentDetail) {
//                        var_dump($ratedShipmentDetail->ShipmentRateDetail->RateType . ": " . $ratedShipmentDetail->ShipmentRateDetail->TotalNetCharge->Amount);
//                    }
//                }
//                echo "<hr />";
//            }
//        }
//
//        echo "<pre>";
//        print_r($rateReply);exit();
//
//    }

    public function shipping(){

        $userCredential = new ComplexType\WebAuthenticationCredential();
        $userCredential->setKey($this->FEDEX_KEY)
            ->setPassword($this->FEDEX_PASSWORD);

        $webAuthenticationDetail = new ComplexType\WebAuthenticationDetail();
        $webAuthenticationDetail->setUserCredential($userCredential);

        $clientDetail = new ComplexType\ClientDetail();
        $clientDetail
            ->setAccountNumber($this->FEDEX_ACCOUNT_NUMBER)
            ->setMeterNumber($this->FEDEX_METER_NUMBER);

        $version = new ComplexType\VersionId();
        $version
            ->setMajor(28)
            ->setIntermediate(0)
            ->setMinor(0)
            ->setServiceId('ship');

        $shipperAddress = new ComplexType\Address();
        $shipperAddress
            ->setStreetLines(['Address Line 1'])
            ->setCity('Austin')
            ->setStateOrProvinceCode('TX')
            ->setPostalCode('73301')
            ->setCountryCode('US');

        $shipperContact = new ComplexType\Contact();
        $shipperContact
            ->setCompanyName('Company Name')
            ->setEMailAddress('test@example.com')
            ->setPersonName('Person Name')
            ->setPhoneNumber(('123-123-1234'));

        $shipper = new ComplexType\Party();
        $shipper
            ->setAccountNumber($this->FEDEX_ACCOUNT_NUMBER)
            ->setAddress($shipperAddress)
            ->setContact($shipperContact);

        $recipientAddress = new ComplexType\Address();
        $recipientAddress
            ->setStreetLines(['Address Line 1'])
            ->setCity('Herndon')
            ->setStateOrProvinceCode('VA')
            ->setPostalCode('20171')
            ->setCountryCode('US');

        $recipientContact = new ComplexType\Contact();
        $recipientContact
            ->setPersonName('Contact Name')
            ->setPhoneNumber('1234567890');

        $recipient = new ComplexType\Party();
        $recipient
            ->setAddress($recipientAddress)
            ->setContact($recipientContact);

        $labelSpecification = new ComplexType\LabelSpecification();
        $labelSpecification
            ->setLabelStockType(new SimpleType\LabelStockType(SimpleType\LabelStockType::_PAPER_7X4POINT75))
            ->setImageType(new SimpleType\ShippingDocumentImageType(SimpleType\ShippingDocumentImageType::_PDF))
            ->setLabelFormatType(new SimpleType\LabelFormatType(SimpleType\LabelFormatType::_COMMON2D));

        $packageLineItem1 = new ComplexType\RequestedPackageLineItem();
        $packageLineItem1
            ->setSequenceNumber(1)
            ->setItemDescription('Product description')
            ->setDimensions(new ComplexType\Dimensions(array(
                'Width' => 10,
                'Height' => 10,
                'Length' => 25,
                'Units' => SimpleType\LinearUnits::_IN
            )))
            ->setWeight(new ComplexType\Weight(array(
                'Value' => 2,
                'Units' => SimpleType\WeightUnits::_LB
            )));

        $shippingChargesPayor = new ComplexType\Payor();
        $shippingChargesPayor->setResponsibleParty($shipper);

        $shippingChargesPayment = new ComplexType\Payment();
        $shippingChargesPayment->setPaymentType(SimpleType\PaymentType::_SENDER)->setPayor($shippingChargesPayor);

        $requestedShipment = new ComplexType\RequestedShipment();
        $requestedShipment->setShipTimestamp(date('c'));
        $requestedShipment->setDropoffType(new SimpleType\DropoffType(SimpleType\DropoffType::_REGULAR_PICKUP));
        $requestedShipment->setServiceType(new SimpleType\ServiceType(SimpleType\ServiceType::_FEDEX_GROUND));
        $requestedShipment->setPackagingType(new SimpleType\PackagingType(SimpleType\PackagingType::_YOUR_PACKAGING));
        $requestedShipment->setShipper($shipper);
        $requestedShipment->setRecipient($recipient);
        $requestedShipment->setLabelSpecification($labelSpecification);
        $requestedShipment->setRateRequestTypes(array(new SimpleType\RateRequestType(SimpleType\RateRequestType::_PREFERRED)));
        $requestedShipment->setPackageCount(1);
        $requestedShipment->setRequestedPackageLineItems([$packageLineItem1]);
        $requestedShipment->setShippingChargesPayment($shippingChargesPayment);


        $processShipmentRequest = new ComplexType\ProcessShipmentRequest();
        $processShipmentRequest->setWebAuthenticationDetail($webAuthenticationDetail);
        $processShipmentRequest->setClientDetail($clientDetail);
        $processShipmentRequest->setVersion($version);
        $processShipmentRequest->setRequestedShipment($requestedShipment);

        $shipService = new ShipService\Request();
        $result = $shipService->getProcessShipmentReply($processShipmentRequest);

        echo "<pre>";
        print_r($result);exit();

    }
}
