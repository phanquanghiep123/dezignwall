<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Checkout extends CI_Controller
{
    private $base_url=null;
    private $PayPalMode             = 'sandbox'; // sandbox or live
    private $PayPalApiUsername      = 'ngovanduc_paypal2_api1.yahoo.com'; //PayPal API Username
    private $PayPalApiPassword      = 'MC656ZQC95GJ365D'; //Paypal API password
    private $PayPalApiSignature     = 'ASppbrpxkg4msumN4X0PsmLfKl6TAb8Tgu58WIQzp0Aeb0JoiQO7Zrix'; //Paypal API Signature
    
    private $PayPalApiUsername2     = 'dezignwall_api1.gmail.com'; //PayPal API Username
    private $PayPalApiPassword2     = 'SG2M7T3KA7MTPSBT'; //Paypal API password
    private $PayPalApiSignature2    = 'AqaCj8FG8nrQXZVi8HE-IWSasYYjAtSXLn33FVw6Y9YQtaC-5gV-v-Ki'; //Paypal API Signature
    
    private $PayPalCurrencyCode     = 'USD'; //Paypal Currency Code
    private $PayPalReturnURL        = null; //Point to process.php page
    private $PayPalCancelURL        = null; //Cancel URL if user clicks cancel
    private $TotalTaxAmount         = 0;  //Sum of tax for all items in this order. 
    private $HandalingCost          = 0;  //Handling cost for this order.
    private $InsuranceCost          = 0;  //shipping insurance cost for this order.
    private $ShippinDiscount        = 0; //Shipping discount for this order. Specify this as negative number.
    private $ShippinCost            = 0; //Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.

    private $user_id = null;
    private $user_info = null;
    private $is_login = false;
    private $data=null;

    public function __construct()
    {
        parent::__construct();
        
        // Check login
        $this->load->library('session');
        $this->load->helper('url');
        if (!$this->session->userdata('user_info')) {
            redirect("/");
        }
        else{
            $this->is_login = true;
            $this->data['is_login']=true;
            $this->user_info = $this->session->userdata('user_info');
            $this->user_id = $this->user_info["id"];
        }
        $this->base_url=base_url();
        $this->PayPalReturnURL=$this->base_url.'checkout/success';
        $this->PayPalCancelURL=$this->base_url."profile/upgrade";
    }
    
    /* Payment via credit card */
    public function credit() 
    {
    	$id = $this->input->post("package_id");
    	if (!(isset($id) && $id != null && is_numeric($id))) {
        	redirect('/profile/upgrade');
        }
        $record = $this->Common_model->get_record('packages',array(
            'id' => $id,
        ));
        if (!(isset($record) && count($record) > 0)) {
            redirect('/profile/upgrade');
        }
        
        // Set request-specific fields.
		$paymentType = urlencode('Sale'); // 'Authorization' or 'Sale'
		$firstName = urlencode($this->input->post('first_name'));
		$lastName = urlencode($this->input->post('last_name'));
		$creditCardType = urlencode($this->input->post('card_type'));
		$creditCardNumber = urlencode($this->input->post('card_number'));
		$expDateMonth = $this->input->post('month');
		// Month must be padded with leading zero
		$padDateMonth = urlencode(str_pad($expDateMonth, 2, '0', STR_PAD_LEFT));
		
		$expDateYear = urlencode($this->input->post('year'));
		$cvv2Number = urlencode($this->input->post('security_code'));
		$address1 = urlencode($this->input->post('address1'));
		$address2 = urlencode($this->input->post('address2'));
		$city = urlencode($this->input->post('city'));
		$state = urlencode($this->input->post('state'));
		$zip = urlencode($this->input->post('zipcode'));
		$country = urlencode($this->input->post('country')); // US or other valid country code
		
		$amount = urlencode($record['price']);
		$currencyID = urlencode('USD'); // or other currency ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')
		 
		// Add request-specific fields to the request string.
		$nvpStr =	"&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber".
					"&EXPDATE=$padDateMonth$expDateYear&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName".
					"&STREET=$address1&CITY=$city&STATE=$state&ZIP=$zip&COUNTRYCODE=$country&CURRENCYCODE=$currencyID";
		 
		// Execute the API operation; see the PPHttpPost2 function above.
		$httpParsedResponseAr = $this->PPHttpPost2('DoDirectPayment', $nvpStr, $this->PayPalApiUsername2, $this->PayPalApiPassword2, $this->PayPalApiSignature2, $this->PayPalMode);
        
        if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
			// exit('Direct Payment Completed Successfully: '.print_r($httpParsedResponseAr, true));
			// Remove session after payment
			$this->session->unset_userdata('info_credit');
			
			// Save into credit card table
			$this->Common_model->add('member_payment',array(
                'first_name' => $firstName,
                'last_name' => $lastName,
                'credit_card' => 'xxxxxxxxxxxx' . substr($creditCardNumber, strlen($creditCardNumber) - 4),
                'address1' => $address1,
                'address2' => $address2,
                'city' => $city,
                'state' => $state,
                'zipcode' => $zip,
                'country' => $country,
                'expire_month' => $padDateMonth,
                'expire_year' => $expDateYear,
                'price' => $amount,
                'qty_month' => $record['max_files'],
                'created_at' => date('Y-m-d H:i:s'),
                'type_payment' => 'credit',
                'member_id' => $this->user_id,
                'package_id' => $id,
                'package_summary' => $this->user_id
            ));
			
			// Update to database
			$arr = array(
                'upgrade_date_start' => date('Y-m-d'),
                'upgrade_date_end'   => date('Y-m-d', strtotime('+' . $record['max_files'] . ' month'))
            );
            $record = $this->Common_model->get_record('member_upgrade',array(
            	'member_id' => $this->user_id
            ));
            if (isset($record) && count($record) > 0) {
            	$this->Common_model->update('member_upgrade', $arr, array(
                    'member_id' => $this->user_id
                ));
            } else {
            	$arr['member_id'] = $this->user_id;
            	$this->Common_model->add('member_upgrade', $arr);
            }
          	//update database
            $order_slug = substr(md5($this->getGuid()),0,19);
            $id_insert_ht = $this->Common_model->add('history',array(
                'order' => $order_slug,
                'member_id' => $this->user_id,
                'packages_id' => $id,
                'date_create' =>date('Y-m-d H:i:s')
            ));
            if ($id_insert_ht) {
                $id_member = $this->user_id;
                $this->Common_model->update("members",array("type_member" => 1),array("id" => $id_member));
                $this->session->unset_userdata('user_info');
                $record_user    = $this->Common_model->get_record("members",array("id" => $id_member));
                $record_company = $this->Common_model->get_record("company",array("member_id" => $id_member));
                $new_session = array(
                    'email'             => $record_user["email"],
                    'id'                => $record_user["id"],
                    'full_name'         => @$record_user["first_name"] . ' ' . @$record_user["last_name"],
                    'company_name'      => @$record_company["company_name"],
                    'business_type'     => @$record_company["business_type"],
                    'type_member'       => @$record_user["type_member"],
                    'avatar'            => @$record_user["avatar"]
                );
                $this->session->set_userdata('user_info', $new_session);
            } 
			
			// Set flash message
			$this->session->set_flashdata('message', 'Thank you for your purchase!');
			redirect('/profile/plan/' . $id);
		} else  {
			// exit('DoDirectPayment failed: ' . print_r($httpParsedResponseAr, true));
			$this->session->set_userdata('info_credit', array("status" => "fail", "fields" => $_POST));
			redirect('/profile/plan/' . $id);
		}
    }

    public function error()
    {
        $message = array('type' => 'alert-danger', 'title' =>'Your request could not be processed at this time', 'content' => 'Paypal is currently unavailable, so you will not be able to pay with PayPal at this time');
        $this->data['message'] = $message;
    	$this->load->view('block/header',$this->data);
        $this->load->view('include/messenger-page',$this->data);
    	$this->load->view('block/footer',$this->data);
    }

    public function thankyou()
    {
        $message = array('type' => 'alert-success', 'title' =>'Payment Successfull', 'content' => 'Thank you for your purchase!');
        $this->data['message'] = $message;
        $this->load->view('block/header',$this->data);
        $this->load->view('include/messenger-page',$this->data);
        $this->load->view('block/footer',$this->data);
    }

    public function success()
    {
        if (isset($_GET["token"]) && isset($_GET["PayerID"])) {
            $token = $_GET["token"];
            $payer_id = $_GET["PayerID"];

            $id=$this->session->userdata('packages');

	        if(! (isset($id) && $id!=null && is_numeric($id)) ){
                redirect('/profile/upgrade');
            }
            $record=$this->Common_model->get_record('packages',array(
                'id'=>$id,
            ));
            
            if(!(isset($record) && count($record)>0 )){
                redirect('/profile/upgrade');
            }
            $this->session->unset_userdata('packages');

            $TotalPrice=floatval($record['price']);
            $paypal_data = '&L_PAYMENTREQUEST_0_NAME0='.urlencode(@$record['name'].' Month plan');
            $paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER0='.urlencode(@$record['id']);
            $paypal_data .= '&L_PAYMENTREQUEST_0_AMT0='.urlencode(@$record['price']);
            $paypal_data .= '&L_PAYMENTREQUEST_0_QTY0='. urlencode(1);

            $GrandTotal = ($TotalPrice + $this->TotalTaxAmount + $this->HandalingCost + $this->InsuranceCost + $this->ShippinCost + $this->ShippinDiscount);
            $paypalmode = ($this->PayPalMode=='sandbox') ? '.sandbox' : '';
            $padata ='&METHOD=SetExpressCheckout'.
                '&RETURNURL='.urlencode($this->PayPalReturnURL ).
                '&CANCELURL='.urlencode($this->PayPalCancelURL).
                '&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
                $paypal_data.
                '&NOSHIPPING=0'. //set 1 to hide buyer's shipping address, in-case products that does not require shipping
                '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($TotalPrice).
                '&PAYMENTREQUEST_0_TAXAMT='.urlencode($this->TotalTaxAmount).
                '&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($this->ShippinCost).
                '&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($this->HandalingCost).
                '&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($this->ShippinDiscount).
                '&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($this->InsuranceCost).
                '&PAYMENTREQUEST_0_AMT='.urlencode($GrandTotal).
                '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($this->PayPalCurrencyCode).
                '&LOCALECODE=GB'. //PayPal pages to match the language on your website.
                '&CARTBORDERCOLOR=FFFFFF'. //border color of cart
                '&ALLOWNOTE=1';
                //Check if everything went ok..
            $httpParsedResponseAr = $this->PPHttpPost('DoExpressCheckoutPayment', $padata, $this->PayPalApiUsername, $this->PayPalApiPassword, $this->PayPalApiSignature, $this->PayPalMode);
            if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {

                $padata =   '&TOKEN='.urlencode($token);
                $httpParsedResponseAr = $this->PPHttpPost('GetExpressCheckoutDetails', $padata, $this->PayPalApiUsername, $this->PayPalApiPassword, $this->PayPalApiSignature, $this->PayPalMode);
                if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
                {
                    $arr=array(
                        'upgrade_date_start'=>date('Y-m-d'),
                        'upgrade_date_end'  =>date('Y-m-d',strtotime('+'.$record['max_files'].' month'))
                    );
                    $record=$this->Common_model->get_record('member_upgrade',array(
                    	'member_id' => $this->user_id
                    ));
                    if(isset($record) && count($record)>0){
                    	$this->Common_model->update('member_upgrade',$arr,array(
	                        'member_id' => $this->user_id
	                    ));
                    }
                    else{
                    	$arr['member_id']=$this->user_id;
                    	$this->Common_model->add('member_upgrade',$arr);
                    }
                  	//update database
                    $order_slug=substr(md5($this->getGuid()),0,19);
                    $id_insert_ht = $this->Common_model->add('history',array(
                        'order'=>$order_slug,
                        'member_id' => $this->user_id,
                        'packages_id' => $id,
                        'date_create' =>date('Y-m-d H:i:s')
                    ));
                    if($id_insert_ht){
                        $id_member_upday = $this->user_id;
                        $this->Common_model->update("members",array("type_member" => 1),array("id" => $id_member_upday));
                        $this->session->unset_userdata('user_info');
                        $record_user    = $this->Common_model->get_record("members",array("id"=> $id_member_upday));
                        $record_company = $this->Common_model->get_record("company",array("member_id"=> $id_member_upday));
                        $new_session = array(
                            'email'             => $record_user["email"],
                            'id'                => $record_user["id"],
                            'full_name'         => @$record_user["first_name"] . ' ' . @$record_user["last_name"],
                            'company_name'      => @$record_company["company_name"],
                            'business_type'     => @$record_company["business_type"],
                            'type_member'       => @$record_user["type_member"],
                            'avatar'            => @$record_user["avatar"]
                        );
                        $this->session->set_userdata('user_info',$new_session);
                    } 
			        $message = array('type' => 'alert-success', 'title' =>'Payment Successfull', 'content' => 'Thank you for your purchase!');
			        $this->data['message'] = $message;
			        $this->load->view('block/header',$this->data);
			        $this->load->view('include/messenger-page',$this->data);
			        $this->load->view('block/footer',$this->data);
                } else  {
                	$this->session->set_flashdata('message', 'Get Transaction Details failed');
                	redirect('/checkout/error');
                }
            
            }
		}
        else{
            redirect('/profile/upgrade');
        }
    }

    public function process($id) 
    {
        if(! (isset($id) && $id!=null && is_numeric($id)) ){
            redirect('/profile/upgrade');
        }
        $record=$this->Common_model->get_record('packages',array(
            'id'=>$id,
        ));
        
        if(!(isset($record) && count($record)>0 )){
            redirect('/profile/upgrade');
        }

        $this->session->set_userdata('packages',$id);

        $TotalPrice=floatval($record['price']);
    	$paypal_data = '&L_PAYMENTREQUEST_0_NAME0='.urlencode(@$record['name'].' Month plan');
        $paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER0='.urlencode(@$record['id']);
        $paypal_data .= '&L_PAYMENTREQUEST_0_AMT0='.urlencode(@$record['price']);		
		$paypal_data .= '&L_PAYMENTREQUEST_0_QTY0='. urlencode(1);

        $GrandTotal = ($TotalPrice + $this->TotalTaxAmount + $this->HandalingCost + $this->InsuranceCost + $this->ShippinCost + $this->ShippinDiscount);
        $paypalmode = ($this->PayPalMode=='sandbox') ? '.sandbox' : '';

        $padata ='&METHOD=SetExpressCheckout'.
                '&RETURNURL='.urlencode($this->PayPalReturnURL ).
                '&CANCELURL='.urlencode($this->PayPalCancelURL).
                '&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
                $paypal_data.
                '&NOSHIPPING=0'. //set 1 to hide buyer's shipping address, in-case products that does not require shipping
                '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($TotalPrice).
                '&PAYMENTREQUEST_0_TAXAMT='.urlencode($this->TotalTaxAmount).
                '&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($this->ShippinCost).
                '&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($this->HandalingCost).
                '&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($this->ShippinDiscount).
                '&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($this->InsuranceCost).
                '&PAYMENTREQUEST_0_AMT='.urlencode($GrandTotal).
                '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($this->PayPalCurrencyCode).
                '&LOCALECODE=GB'. //PayPal pages to match the language on your website.
                '&LOGOIMG='.base_url('/skins/images/logo1.png'). //site logo
                '&CARTBORDERCOLOR=FFFFFF'. //border color of cart
                '&ALLOWNOTE=1';

        $httpParsedResponseAr = $this->PPHttpPost('SetExpressCheckout', $padata,$this->PayPalApiUsername,$this->PayPalApiPassword, $this->PayPalApiSignature,$this->PayPalMode);
        if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){
            $paypalurl ='https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
            header('Location: '.$paypalurl);
        }else{
            //Show error message
            redirect('/profile/upgrade');
        }
	}

    private function getGuid()
    {
        list($micro_time, $time) = explode(' ', microtime());
        $id = round((rand(0, 217677) + $micro_time) * 10000);
        $id = base_convert($id, 10, 36);
        return $id;
    }
    
    private function PPHttpPost2($methodName_, $nvpStr_, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $environment) 
    {
	 	$API_UserName = urlencode($PayPalApiUsername);
        $API_Password = urlencode($PayPalApiPassword);
        $API_Signature = urlencode($PayPalApiSignature);
		
		$API_Endpoint = "https://api-3t.paypal.com/nvp";
		if("sandbox" === $environment || "beta-sandbox" === $environment) {
			$API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
		}
		$version = urlencode('51.0');
	 
		// Set the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
	 
		// Turn off the server and peer verification (TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
	 
		// Set the API operation, version, and API signature in the request.
		$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
	 
		// Set the request as a POST FIELD for curl.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
	 
		// Get response from the server.
		$httpResponse = curl_exec($ch);
	 
		if(!$httpResponse) {
			//exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
			return null;
		}
	 
		// Extract the response details.
		$httpResponseAr = explode("&", $httpResponse);
	 
		$httpParsedResponseAr = array();
		foreach ($httpResponseAr as $i => $value) {
			$tmpAr = explode("=", $value);
			if(sizeof($tmpAr) > 1) {
				$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
			}
		}
	 
		if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
			// exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
			return null;
		}
	 
		return $httpParsedResponseAr;
	}

    private function PPHttpPost($methodName_, $nvpStr_, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode) 
    {
        // Set up your API credentials, PayPal end point, and API version.
        $API_UserName = urlencode($PayPalApiUsername);
        $API_Password = urlencode($PayPalApiPassword);
        $API_Signature = urlencode($PayPalApiSignature);
        
        $paypalmode = ($PayPalMode=='sandbox') ? '.sandbox' : '';

        $API_Endpoint = "https://api-3t".$paypalmode.".paypal.com/nvp";
        $version = urlencode('109.0');
    
        // Set the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
    
        // Turn off the server and peer verification (TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
    
        // Set the API operation, version, and API signature in the request.
        $nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
    
        // Set the request as a POST FIELD for curl.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
    
        // Get response from the server.
        $httpResponse = curl_exec($ch);
    
        if(!$httpResponse) {
            exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
        }
    
        // Extract the response details.
        $httpResponseAr = explode("&", $httpResponse);
    
        $httpParsedResponseAr = array();
        foreach ($httpResponseAr as $i => $value) {
            $tmpAr = explode("=", $value);
            if(sizeof($tmpAr) > 1) {
                $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
            }
        }
    
        if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
            exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
        }
    
        return $httpParsedResponseAr;
    }
}

/* End of file payment.php */
/* Location: ./application/controllers/checkout.php */