<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 6/12/18
 * Time: 3:54 PM
 */

namespace FinApiDemo\Repositories\Interfaces;


interface IUserRepository
{
    function getById($userId);

    function isTokenValid();
}