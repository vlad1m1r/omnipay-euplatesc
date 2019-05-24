<?php

namespace Omnipay\EuPlatesc;

use Omnipay\Common\AbstractGateway;
use Omnipay\EuPlatesc\Message\CompletePurchaseRequest;
use Omnipay\EuPlatesc\Message\PurchaseRequest;


class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'EuPlatesc';
    }

    public function getDefaultParameters()
    {
        return array(
            'MID' => '',
            'KEY' => '',
            'testMode' => false,
        );
    }

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

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\EuPlatesc\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\EuPlatesc\Message\CompletePurchaseRequest', $parameters);
    }
}
