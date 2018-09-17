<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 6/12/18
 * Time: 3:35 PM
 */

namespace FinApiDemo\Entities\MyCo;


class User
{
    public $username;

    public $password;

    public $email;

    /** @var \FinApiDemo\Entities\FinApi\User */
    public $finApiUser;

    public function __construct($username = '', $password = '', $email = '', \FinApiDemo\Entities\FinApi\User $finApiUser = null)
    {

        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->finApiUser = $finApiUser;
    }
}