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
use FinApiDemo\Services\Interfaces\IFinApiUserService;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Monolog\Logger;

class FinApiUserService implements IFinApiUserService
{
    const API_USERS_URI = '/api/v1/users';
    /**
     * @var FinApiClientSettings
     */
    private $finApiClientSettings;
    /**
     * @var Logger
     */
    private $logger;

    public function __construct(Logger $logger, FinApiClientSettings $finApiClientSettings)
    {
        $this->finApiClientSettings = $finApiClientSettings;
        $this->logger = $logger;
    }


    /**
     * @inheritdoc
     */
    function getUser(AccessToken $userAccessToken)
    {
        $httpClient = new Client();

        try {
            $response = $httpClient->get(
                $this->finApiClientSettings->apiUrl . self::API_USERS_URI,
                [
                    'headers' => [
                        'Authorization: Bearer ' . $userAccessToken->accessToken
                    ]
                ]
            );

            $responseCode = $response->getStatusCode();
            $responseBody = $response->getBody();

            if ($responseCode === 200) {
                return $this->mapToUserObject(json_decode($responseBody));
            }

            $this->logger->info(self::class . ': Unable to get current logged in user. Code:' . $responseCode . '. Body:' . $responseBody);

        } catch(\Exception $e) {
            $this->logger->error($e->getMessage() . "\n" . $e->getTraceAsString());
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    function createUser(AccessToken $clientAccessToken, \FinApiDemo\Entities\FinApi\User $user)
    {
        $httpClient = new Client([
            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer ' . $clientAccessToken->accessToken
            ],
        ]);

        // Filter empty fields. Api doesn't support sending empty fields
        $userDataArray = array_filter((array)$user,
            function ($item, $index) {
                return !empty($item);
            },
            ARRAY_FILTER_USE_BOTH
        );

        try {

            $response = $httpClient->post(
                $this->finApiClientSettings->apiUrl . self::API_USERS_URI,
                [
                    RequestOptions::JSON => $userDataArray,
                ]
            );

            $responseCode = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();

            if ($responseCode === 201) {
                return $this->mapToUserObject(json_decode($responseBody));
            }

            $this->logger->info(self::class . ': Unable to create new user. Code:' . $responseCode . '. Body:' . $responseBody);

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    /**
     * {
     * "id": "c390e74d-5f0c-460f-af75-bb6ade024650",
     * "password": "c412a02e-38e4-4377-8ade-e8de87dfa1f6",
     * "email": null,
     * "phone": null,
     * "isAutoUpdateEnabled": true
     * }
     *
     * @param $source
     * @return \FinApiDemo\Entities\FinApi\User
     */
    private function mapToUserObject($source)
    {
        return new \FinApiDemo\Entities\FinApi\User(
            $source->id,
            $source->password,
            $source->email,
            $source->phone,
            $source->isAutoUpdateEnabled
        );
    }
}