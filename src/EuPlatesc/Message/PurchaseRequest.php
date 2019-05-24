<?php

namespace Omnipay\EuPlatesc\Message;

use Omnipay\Common\Message\AbstractRequest;


class PurchaseRequest extends AbstractRequest
{
  
    protected $liveEndpoint = 'https://secure.euplatesc.ro/tdsprocess/tranzactd.php';
    protected $testEndpoint = 'https://secure.euplatesc.ro/tdsprocess/sandbox.php';

    public function getMerchantID()
    {
        return $this->getParameter('merchantID');
    }

    public function setMerchantID($value)
    {
        return $this->setParameter('merchantID', $value);
    }

    public function getMerchantKEY()
    {
        return $this->getParameter('merchantKEY');
    }
	
	public function setMerchantKEY($value)
    {
        return $this->setParameter('merchantKEY', $value);
    }

    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }

    public function setOrderId($value)
    {
        return $this->setParameter('orderId', $value);
    }

    public function getReturnUrl()
    {
        return $this->getParameter('returnUrl');
    }

    public function setReturnUrl($value)
    {
        return $this->setParameter('returnUrl', $value);
    }

    public function getConfirmUrl()
    {
        return $this->getParameter('confirmUrl');
    }

    public function setConfirmUrl($value)
    {
        return $this->setParameter('confirmUrl', $value);
    }
	
    public function getParams()
    {
        return $this->getParameter('params');
    }

    public function setParams($value)
    {
        return $this->setParameter('params', $value);
    }

    public function getDetails()
    {
        return $this->getParameter('details');
    }

    public function setDetails($value)
    {
        return $this->setParameter('details', $value);
    }

    public function getPaymentNo()
    {
        return $this->getParameter('paymentNo');
    }

    public function setPaymentNo($value)
    {
        return $this->setParameter('paymentNo', $value);
    }

    public function getBillingAddress()
    {
        return $this->getParameter('billingAddress');
    }

    public function setBillingAddress($value)
    {
        $this->setParameter('billingAddress', $value);
    }

    public function getData()
    {
        $data=array();
		$data['amount']		= $this->getParameter('amount');
		$data['curr']		= $this->getParameter('currency');
		$data['invoice_id']	= $this->getParameter('orderId');
		$data['order_desc']	= $this->getParameter('details');
		$data['merch_id']	= $this->getMerchantID();
		$data['timestamp']	= date("YmdHis");
		$data['nonce']		= md5(time().mt_rand().microtime());
		
        $data['fp_hash']	= $this>euplatesc_mac($data,$this->getMerchantKEY());
		$data['ExtraData']   = $this->getParameter('params') ?: [];

 
		$data['fname']	= $parameters['firstName'];
		$data['lname']	= $parameters['lastName'];
		$data['email']	= $parameters['email'];
		$data['phone']	= $parameters['mobilePhone'];
		$data['add']	= $parameters['address'];
		$data['city']	= $parameters['city'];
		$data['country']= $parameters['country'];

        return $data;
    }

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data, $this->getEndpoint());
    }
	
	public function hmacmd5($key,$data) {
		$blocksize = 64;
		$hashfunc  = 'md5';
		if(strlen($key) > $blocksize){
			$key = pack('H*', $hashfunc($key));
		}
		$key  = str_pad($key, $blocksize, chr(0x00));
		$ipad = str_repeat(chr(0x36), $blocksize);
		$opad = str_repeat(chr(0x5c), $blocksize);
		$hmac = pack('H*', $hashfunc(($key ^ $opad) . pack('H*', $hashfunc(($key ^ $ipad) . $data))));
		return bin2hex($hmac);
	}

	public function euplatesc_mac($data, $key){
		$str = NULL;
		foreach($data as $d){
			if($d === NULL || strlen($d) == 0){
				$str .= '-';
			}else{
				$str .= strlen($d) . $d;
			}
		}
		$key = pack('H*', $key);
		return $this->hmacmd5($key, $str);
	}
}
