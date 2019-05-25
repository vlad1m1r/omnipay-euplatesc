<?php

namespace Omnipay\EuPlatesc\Message;

use Omnipay\Common\Exception\InvalidResponseException;


class CompletePurchaseRequest extends PurchaseRequest
{
    public function getData()
    {
		
		$zcrsp =  array (
			'amount'     => addslashes(trim($this->httpRequest->request->get('amount'))),
			'curr'       => addslashes(trim($this->httpRequest->request->get('curr'))),  
			'invoice_id' => addslashes(trim($this->httpRequest->request->get('invoice_id'))),
			'ep_id'      => addslashes(trim($this->httpRequest->request->get('ep_id'))), 
			'merch_id'   => addslashes(trim($this->httpRequest->request->get('merch_id'))),
			'action'     => addslashes(trim($this->httpRequest->request->get('action'))), 
			'message'    => addslashes(trim($this->httpRequest->request->get('message'))),
			'approval'   => addslashes(trim($this->httpRequest->request->get('approval'))),
			'timestamp'  => addslashes(trim($this->httpRequest->request->get('timestamp'))),
			'nonce'      => addslashes(trim($this->httpRequest->request->get('nonce'))),
		);
		
		$zcrsp['fp_hash'] = strtoupper($this->euplatesc_mac($zcrsp, $this->getKEY()));
		
		$fp_hash=addslashes(trim($this->httpRequest->request->get('fp_hash')));

		if($zcrsp['fp_hash']!==$fp_hash){
			throw new InvalidResponseException('Invalid key');
		}else{
			if($zcrsp['action']!=0){
				throw new InvalidResponseException($zcrsp['message']);
			}
		}

        return $this->httpRequest->request->all();
    }

    public function sendData($data)
    {

        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}
