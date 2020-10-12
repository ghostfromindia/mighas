<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Image, Redirect;

class PaymentController extends Controller
{
    
    public function index()
    {
		$obj = new \AWLMEAPI();
		$reqMsgDTO = new \ReqMsgDTO();
		$reqMsgDTO->setOrderId("157829009927339");
		$reqMsgDTO->setMid("WL0000000027698");
		$reqMsgDTO->setTrnAmt(200); //Paisa Format
		$reqMsgDTO->setTrnCurrency("INR");
		$reqMsgDTO->setMeTransReqType("S");
		$reqMsgDTO->setEnckey("6375b97b954b37f956966977e5753ee6");
		$reqMsgDTO->setResponseUrl(url('payments/response'));
		$reqMsgDTO->setTrnRemarks('Mobile bill paid');
		//Optional Fields
		$reqMsgDTO->setAddField1('Info1');
		$reqMsgDTO->setAddField2('Info 2');
		$reqMsgDTO->setAddField3("");
		$reqMsgDTO->setAddField4("");
		$reqMsgDTO->setAddField5("");
		$reqMsgDTO->setAddField6("");
		$reqMsgDTO->setAddField7("");
		$reqMsgDTO->setAddField8("");
		//Step 3: API call to generate the Message

		$merchantRequest = "";
		$reqMsgDTO = $obj->generateTrnReqMsg($reqMsgDTO);
		if ($reqMsgDTO->getStatusDesc() == "Success"){
			$merchantRequest = $reqMsgDTO->getReqMsg();
			$merchantId = $reqMsgDTO->getMid();
			return view('client/payments/index', ['merchantRequest'=>$merchantRequest, 'merchantId'=>$merchantId]);
		} 
		else{
			return view('client/payments/errors');
		}
    }

    public function response()
    {
    	//create an Object of the above included class
		$obj = new \AWLMEAPI();
		
		/* This is the response Object */
		$resMsgDTO = new \ResMsgDTO();

		/* This is the request Object */
		$reqMsgDTO = new \ReqMsgDTO();
		
		//This is the Merchant Key that is used for decryption also
		$enc_key = '6375b97b954b37f956966977e5753ee6';
		
		/* Get the Response from the WorldLine */
		$responseMerchant = $_REQUEST['merchantResponse'];
		
		$response = $obj->parseTrnResMsg( $responseMerchant , $enc_key );
		$jsonData = json_encode($response);
		$status = $response->getStatusCode();
		if($status == 'S')
		{
			$order_id = $response->getOrderId();
			$transaction_id = $response->getPgMeTrnRefNo();
			$amount = $response->getTrnAmt();
			$transaction_date = $response->getTrnReqDate();
		}
		return view('client/payments/errors');
    }

    public function cancel($error=null)
    {
    		echo "dfsdfsdf";exit;
    }
}
