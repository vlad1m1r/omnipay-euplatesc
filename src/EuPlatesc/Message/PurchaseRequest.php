<?php

namespace Omnipay\EuPlatesc\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * 2Checkout Purchase Request
 */
class PurchaseRequest extends AbstractRequest
{
    public function getMID()
    {
        return $this->getParameter('MID');
    }

    public function setMID($value)
    {
        return $this->setParameter('MID', $value);
    }

    public function getKEY()
    {
        return $this->getParameter('KEY');
    }

    public function setKEY($value)
    {
        return $this->setParameter('KEY', $value);
    }

    public function getData()
    {
        $this->validate('amount', 'returnUrl');

        $data = array();
		
		$data=array();
		$data['amount']		= $this->getAmount();
		$data['curr']		= $this->getCurrency();
		$data['invoice_id']	= $this->getTransactionId();
		$data['order_desc']	= $this->getParameter('description');
		$data['merch_id']	= $this->getMID();
		$data['timestamp']	= date("YmdHis");
		$data['nonce']		= md5(time().mt_rand().microtime());
		
        $data['fp_hash']	= $this->euplatesc_mac($data,$this->getKEY());
 
 
		if ($this->getCard()) {
            $data['fname'] = $this->getCard()->getName();
            $data['add'] = $this->getCard()->getAddress1();
            $data['city'] = $this->getCard()->getCity();
            $data['state'] = $this->getCard()->getState();
            $data['zip'] = $this->getCard()->getPostcode();
            $data['country'] = $this->getCard()->getCountry();
            $data['phone'] = $this->getCard()->getPhone();
            $data['email'] = $this->getCard()->getEmail();
        }
		$data['ExtraData[successurl]'] = $this->getReturnUrl();
		$data['ExtraData[silenturl]'] = $this->getNotifyUrl();
        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
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
