<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 6/12/18
 * Time: 3:44 PM
 */

namespace FinApiDemo\Services\Interfaces;


use FinApiDemo\Entities\SaveDroid\User;

interface IUserService
{
    /**
     * Returns the current app user
     *
     * @return User
     */
    function getCurrentUser();
}