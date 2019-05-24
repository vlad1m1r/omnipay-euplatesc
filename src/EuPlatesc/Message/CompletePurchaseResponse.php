<?php

namespace Omnipay\EuPlatesc\Message;

class CompletePurchaseResponse extends AbstractResponse
{
    
    protected $action;
    protected $responseError;

    public function __construct(RequestInterface $request, $data, $responseError)
    {
        parent::__construct($request, $data);

        $this->request       = $request;
        $this->responseError = $responseError;

        if (isset($data['action'])) {
            $this->action = $data['action'];
        }
    }

    public function isSuccessful()
    {
        return in_array($this->action, ['0']);
    }

    public function isPending()
    {
        return false;
    }

    public function getMessage()
    {
        return $this->action;
    }

    public function getData()
    {
        return $this->data;
    }

    public function sendResponse()
    {
       echo "OK";
    }
}
