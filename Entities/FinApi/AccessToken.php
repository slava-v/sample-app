<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 6/12/18
 * Time: 3:31 PM
 */

namespace FinApiDemo\Entities\FinApi;


class AccessToken
{
    public $accessToken;

    public $tokenType;

    public $expiresIn;

    public $refreshToken;

    public $scope;

    public function __construct($accessToken = '', $tokenType = '', $expiresIn = '', $refreshToken = '', $scope = '')
    {
        $this->accessToken = $accessToken;
        $this->tokenType = $tokenType;
        $this->expiresIn = $expiresIn;
        $this->refreshToken = $refreshToken;
        $this->scope = $scope;
    }

    function isValid()
    {

    }
}