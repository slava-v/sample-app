<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 6/12/18
 * Time: 3:38 PM
 */

namespace FinApiDemo\Entities\FinApi;

class User
{
    public $id;

    public $password;

    public $email;

    public $phone;

    public $isAutoUpdateEnabled;

    public function __construct($id = '', $password = '', $email = '', $phone = '', $isAutoUpdateEnabled = false)
    {
        $this->id = $id;
        $this->password = $password;
        $this->email = $email;
        $this->phone = $phone;
        $this->isAutoUpdateEnabled = $isAutoUpdateEnabled;
    }
}