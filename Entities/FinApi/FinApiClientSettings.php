<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 6/12/18
 * Time: 3:14 PM
 */

namespace FinApiDemo\Entities\FinApi;

class FinApiClientSettings
{
    public $clientId;

    public $clientSecret;

    public $apiUrl;

    public function __construct($clientId, $clientSecret, $apiUrl = '')
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->apiUrl = $apiUrl;
    }
}
