<?php

namespace Omnipay\EuPlatesc;

use Omnipay\Common\AbstractGateway;
use Omnipay\EuPlatesc\Message\PurchaseRequest;
use Omnipay\EuPlatesc\Message\CompletePurchaseRequest;

class Gateway extends AbstractGateway
{
   
    public function getName()
    {
        return 'EuPlatesc';
    }

    public function getDefaultParameters()
    {
        return [
            'merchantID' => null,
            'merchantKEY'  => null,
            'testMode'   => false,
        ];
    }

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

    public function setCurrency($value)
    {
        return $this->setParameter('currency', $value);
    }

    public function setReturnUrl($value)
    {
        return $this->setParameter('returnUrl', $value);
    }

    public function setConfirmUrl($value)
    {
        return $this->setParameter('confirmUrl', $value);
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

    public function setBillingAddress(array $parameters = [])
    {
        $this->setParameter('billingAddress', $parameters);
    }

    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\EuPlatesc\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\EuPlatesc\Message\CompletePurchaseRequest', $parameters);
    }
}
