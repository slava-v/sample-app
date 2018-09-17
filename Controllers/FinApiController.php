<?php

namespace FinApiDemo\Controllers;

use FinApiDemo\Entities\ApiError;
use FinApiDemo\Entities\ApiResponse;
use FinApiDemo\Entities\FinApi\BankConnection;
use FinApiDemo\Controllers\Interfaces\IFinApiController;
use FinApiDemo\Services\Interfaces\IFinApiBankService;
use FinApiDemo\Services\Interfaces\IFinApiService;
use FinApiDemo\Services\Interfaces\IFinApiUserService;
use FinApiDemo\Services\Interfaces\IUserService;
use Monolog\Logger;
use Slim\Http\Request;
use Slim\Http\Response;

class FinApiController implements IFinApiController
{
    /**
     * @var IFinApiService
     */
    private $finApiService;
    /**
     * @var Logger
     */
    private $logger;
    /**
     * @var IFinApiUserService
     */
    private $finApiUserService;
    /**
     * @var IUserService
     */
    private $userService;
    /**
     * @var IFinApiBankService
     */
    private $finApiBankService;

    public function __construct(Logger $logger, IFinApiService $finApiService, IFinApiUserService $finApiUserService, IFinApiBankService $finApiBankService, IUserService $userService)
    {
        $this->finApiService = $finApiService;
        $this->logger = $logger;
        $this->finApiUserService = $finApiUserService;
        $this->userService = $userService;
        $this->finApiBankService = $finApiBankService;
    }


    function importBank(Request $request, Response $response, array $args)
    {
        $bankId = (int)$args['bankId'];
        //$username = $args['username'];
        //$password = $args['password'];

        //@todo: Validation

        try {
            $currentAppUser = $this->userService->getCurrentUser();

            $clientAccessToken = $this->finApiService->getClientAccessToken();

            if (!$currentAppUser->finApiUser instanceof \FinApiDemo\Entities\FinApi\User){
                // Create user
                $newUser = new \FinApiDemo\Entities\FinApi\User('', '', '', '', true);
                $currentAppUser->finApiUser = $this->finApiUserService->createUser($clientAccessToken, $newUser);
            }
            $userAccessToken = $this->finApiService->requestUserAccessToken($currentAppUser->finApiUser);

            $bankConnection = new BankConnection();
            $bankConnection->bankId = $bankId;

            $newBank = $this->finApiBankService->importBankConnection($userAccessToken, $bankConnection);

            if ($newBank->bankId !== $bankId) {
                throw new \Exception('Bank not created');
            }

            $result = new ApiResponse($newBank);

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage() . "\n" . $e->getTraceAsString());

            $result = new ApiResponse('', new ApiError($e->getCode(), $e->getMessage()));
        }

        return $response->withJson($result);
    }
}