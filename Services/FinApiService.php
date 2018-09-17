<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 6/12/18
 * Time: 2:31 PM
 */

namespace FinApiDemo\Services;

use FinApiDemo\Entities\FinApi\AccessToken;
use FinApiDemo\Entities\FinApi\FinApiClientSettings;
use FinApiDemo\Services\Interfaces\IFinApiBankService;
use FinApiDemo\Services\Interfaces\IFinApiService;
use FinApiDemo\Services\Interfaces\IFinApiUserService;
use FinApiDemo\Services\Interfaces\IUserService;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Monolog\Logger;


class FinApiService implements IFinApiService
{
    const API_AUTH_URI = '/oauth/token';

    /** @var FinApiClientSettings */
    private $finApiClientSettings;
    /**
     * @var IFinApiBankService
     */
    private $apiBankService;
    /**
     * @var IFinApiUserService
     */
    private $finApiUserService;
    /**
     * @var IUserService
     */
    private $userService;

    /** @var Logger */
    private $logger;

    public function __construct(Logger $logger, FinApiClientSettings $finApiClientSettings, IFinApiBankService $apiBankService, IFinApiUserService $finApiUserService, IUserService $userService)
    {
        $this->logger = $logger;
        $this->finApiClientSettings = $finApiClientSettings;
        $this->apiBankService = $apiBankService;
        $this->finApiUserService = $finApiUserService;
        $this->userService = $userService;
    }

    /**
     * Verifies if the client token is valid and not expired yet
     *
     * @return bool
     */
    public function isClientTokenValid()
    {
        //@todo: implement caching
        return false;
    }

    /**
     * Requests a new client token
     *
     * @return AccessToken
     */
    public function requestClientToken()
    {
        $httpClient = new Client();

        try {

            $response = $httpClient->post(
                $this->finApiClientSettings->apiUrl . self::API_AUTH_URI,
                [
                    RequestOptions::FORM_PARAMS => [
                        'grant_type' => 'client_credentials',
                        'client_id' => $this->finApiClientSettings->clientId,
                        'client_secret' => $this->finApiClientSettings->clientSecret
                    ]
                ]
            );

            $responseCode = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();

            if ($responseCode === 200) {
                return $this->mapToAccessTokenObject(json_decode($responseBody));
            }

            $this->logger->info(self::class . ': Unable to authorize. Code:' . $responseCode. '. Body:' . $responseBody);

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage() . "\n" . $e->getTraceAsString());
        }

        return null;
    }

    public function getClientAccessToken()
    {
        if (!$this->isClientTokenValid()) {
            return $this->requestClientToken();
        } else {
            //@todo: return cached client token
        }
    }

    /**
     * @inheritdoc
     */
    public function requestUserAccessToken(\FinApiDemo\Entities\FinApi\User $user)
    {
        $httpClient = new Client();

        try {

            $response = $httpClient->post(
                $this->finApiClientSettings->apiUrl . self::API_AUTH_URI,
                [
                    RequestOptions::FORM_PARAMS => [
                        'grant_type' => 'password',
                        'client_id' => $this->finApiClientSettings->clientId,
                        'client_secret' => $this->finApiClientSettings->clientSecret,
                        'username' => $user->id,
                        'password' => $user->password
                    ]
                ]
            );

            $responseCode = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();

            if ($responseCode === 200) {
                return $this->mapToAccessTokenObject(json_decode($responseBody));
            }

            $this->logger->info(self::class . ': Unable to authorize. Code:' . $responseCode. '. Body:' . $responseBody);

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage() . "\n" . $e->getTraceAsString());
        }

        return null;
    }

    /**
     * Maps the stdClass object to AccessToken object
     *
     * {
     * "access_token": "CT7di8BdwLUgNHYsC8nq9gvKtMXwMxQkuEUjDbew1QvPdCbALgSKSoX4HVhQxUyv_ciOkBdag9xfKyqp9gKd0zxYqzGTF9Ri09y4_J_haUom0NxQeo4LJvBmQeaG8NJD",
     * "token_type": "bearer",
     * "expires_in": 1854,
     * "scope": "all"
     * }
     * @param $source
     * @return AccessToken
     */
    private function mapToAccessTokenObject($source)
    {
        return new AccessToken(
            $source->access_token,
            $source->token_type,
            $source->expires_in,
            $source->refresh_token??'',
            $source->scope
        );
    }
}