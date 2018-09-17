<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 6/12/18
 * Time: 5:42 PM
 */

namespace FinApiDemo\Entities\FinApi;


class Bank
{
    /** string */
    public $id; //": 277672,

    /** @var string */
    public $name; //": "FinAPI Test Bank",

    /** @var string */
    public $loginHint; //": null,

    /** @var string */
    public $bic; //": null,

    /** @var string */
    public $blz; //": "00000000",

    /** @var string */
    public $blzs; //": [     "00000000" ],

    /** @var string */
    public $loginFieldUserId; //": "Onlinebanking-ID",

    /** @var string */
    public $loginFieldCustomerId; //": null,

    /** @var string */
    public $loginFieldPin; //": "PIN",

    /** @var string */
    public $isSupported; //": true,

    /** @var string */
    public $supportedDataSources; //": [ "FINTS_SERVER" ],

    /** @var string */
    public $pinsAreVolatile; //": false,

    /** @var string */
    public $location; //": null,

    /** @var string */
    public $city; //": null,

    /** @var string */
    public $isTestBank; //": true,

    /** @var string */
    public $popularity; //": 734,

    /** @var string */
    public $health; //": 100,

    /** @var string */
    public $lastCommunicationAttempt; //": "2018-06-12 15:39:35.000",

    /** @var string */
    public $lastSuccessfulCommunication; //": "2018-06-12 15:33:48.000"


}