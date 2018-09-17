<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 6/12/18
 * Time: 2:32 PM
 */

namespace FinApiDemo\Services\Interfaces;

use FinApiDemo\Entities\FinApi\BankConnection;
use FinApiDemo\Entities\FinApi\AccessToken;

interface IFinApiBankService
{

    /**
     * @param AccessToken $userAccessToken
     * @param BankConnection $bankConnection
     * @return BankConnection
     */
    function importBankConnection(AccessToken $userAccessToken, BankConnection $bankConnection);
}