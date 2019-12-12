<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class MessageGenerator
{

    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function getMessage(String $msg=null)
    {
        $message = ($msg == null) ? $this->params->get('default_msg'): $msg;
        $response = new JsonResponse();
        $response->setData(['message' => $message]);
        $response->send();
    }

}

