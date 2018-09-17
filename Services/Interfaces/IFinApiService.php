<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 6/12/18
 * Time: 2:31 PM
 */

namespace FinApiDemo\Services\Interfaces;

use FinApiDemo\Entities\FinApi\AccessToken;

interface IFinApiService
{

    /**
     * Verifies if the client token is valid and not expired yet
     *
     * @return bool
     */
    function isClientTokenValid();

    /**
     * Requests a new client token
     *
     * @return AccessToken
     */
    function requestClientToken();

    /**
     * If there is a valid access token then it will be returned,
     * otherwise a new access token will be requested
     *
     * @return AccessToken
     */
    function getClientAccessToken();

    /**
     * Request a new user access token
     *
     * @param \FinApiDemo\Entities\FinApi\User $user
     * @return AccessToken
     */
    function requestUserAccessToken(\FinApiDemo\Entities\FinApi\User $user);
}