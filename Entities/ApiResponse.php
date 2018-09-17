<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 6/12/18
 * Time: 7:35 PM
 */

namespace FinApiDemo\Entities;

class ApiResponse
{
    public $data;

    public $success;

    public $error;

    public function __construct($data = '', ApiError $error = null)
    {
        $this->data = $data;
        $this->success = $error === null;
        $this->error = $error;
    }


}