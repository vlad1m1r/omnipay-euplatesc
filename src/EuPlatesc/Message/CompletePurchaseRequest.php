<?php

namespace Omnipay\EuPlatesc\Message;

use stdClass;

class CompletePurchaseRequest extends PurchaseRequest
{

    private $responseError;

    public function getMerchantKEY()
    {
        return $this->getParameter('MerchantKEY');
    }
	
    public function setMerchantKEY($value)
    {
        return $this->setParameter('MerchantKEY', $value);
    }

   
    public function getData()
    {
		/*
        if (! $this->getPrivateKey()) {
            throw new MissingKeyException("Missing private key path parameter");
        }

        $data = [];
        $this->responseError = new stdClass();

        $this->responseError->code    = 0;
        $this->responseError->type    = AbstractRequest::CONFIRM_ERROR_TYPE_NONE;
        $this->responseError->message = '';

        if ($this->getIpnEnvKey() && $this->getIpnData()) {
            try {
                $data = AbstractRequest::factoryFromEncrypted(
                    $this->getIpnEnvKey(),
                    $this->getIpnData(),
                    $this->getPrivateKey()
                );

                $this->responseError->message = $data->objPmNotify->getCrc();

                $data = json_decode(json_encode($data), true);

                // extract the transaction status from the IPN message
                if (isset($data['objPmNotify']['action'])) {
                    $this->action = $data['objPmNotify']['action'];
                }

                if (! in_array(
                    $this->action,
                    ['confirmed_pending', 'paid_pending', 'paid', 'confirmed', 'canceled', 'credit']
                )) {
                    $this->responseError->type    = AbstractRequest::CONFIRM_ERROR_TYPE_PERMANENT;
                    $this->responseError->code    = AbstractRequest::ERROR_CONFIRM_INVALID_ACTION;
                    $this->responseError->message = 'mobilpay_refference_action paramaters is invalid';
                }
            } catch (Exception $e) {
                $this->responseError->type    = AbstractRequest::CONFIRM_ERROR_TYPE_TEMPORARY;
                $this->responseError->code    = $e->getCode();
                $this->responseError->message = $e->getMessage();
            }
        } else {
            $this->responseError->type    = AbstractRequest::CONFIRM_ERROR_TYPE_PERMANENT;
            $this->responseError->code    = AbstractRequest::ERROR_CONFIRM_INVALID_POST_PARAMETERS;
            $this->responseError->message = 'mobilpay.ro posted invalid parameters';
        }

        return $data;*/
    }

    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data, $this->responseError);
    }
}
