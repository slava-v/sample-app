<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 6/12/18
 * Time: 4:22 PM
 */

namespace FinApiDemo\Entities\FinApi;


class BankConnection
{
    public $bankId;

    public $bankingUserId;

    public $bankingCustomerId;

    public $bankingPin;

    public $storePin;

    public $name;

    public $skipPositionsDownload;

    public $loadOwnerData;

    public $maxDaysForDownload;

    public $accountTypeIds;

    public $challengeResponse;

}