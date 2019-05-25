<?php

namespace Omnipay\EuPlatesc\Message;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return $this->data['action']=="0";
    }

    public function getTransactionReference()
    {
        return isset($this->data['ep_id']) ? $this->data['ep_id'] : null;
    }
}
