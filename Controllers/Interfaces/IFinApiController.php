<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 6/12/18
 * Time: 2:29 PM
 */

namespace FinApiDemo\Controllers\Interfaces;

use Slim\Http\Request;
use Slim\Http\Response;

interface IFinApiController
{
    /**
     * Method imports user bank
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return mixed
     */
    function importBank(Request $request, Response $response, array $args);
}