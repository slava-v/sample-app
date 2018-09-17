<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 6/12/18
 * Time: 2:32 PM
 */

namespace FinApiDemo\Services\Interfaces;

use FinApiDemo\Entities\FinApi\AccessToken;

interface IFinApiUserService
{
    /**
     * Get current user
     * @param AccessToken $userAccessToken
     * @return mixed
     */
    function getUser(AccessToken $userAccessToken);

    /**
     * Create a new user
     *
     * @param AccessToken $clientAccessToken
     * @param \FinApiDemo\Entities\FinApi\User $user
     * @return mixed
     */
    function createUser(AccessToken $clientAccessToken, \FinApiDemo\Entities\FinApi\User $user);
}