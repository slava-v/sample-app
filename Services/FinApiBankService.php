<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 6/12/18
 * Time: 2:31 PM
 */

namespace FinApiDemo\Services;

use FinApiDemo\Entities\FinApi\AccessToken;
use FinApiDemo\Entities\FinApi\BankConnection;
use FinApiDemo\Entities\FinApi\FinApiClientSettings;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Monolog\Logger;
use FinApiDemo\Services\Interfaces\IFinApiBankService;

class FinApiBankService implements IFinApiBankService
{
    const API_IMPORT_BANK_URI = '/api/v1/bankConnections/import';
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
     * @param AccessToken $userAccessToken
     * @param BankConnection $bankConnection
     * @return BankConnection
     */
    function importBankConnection(AccessToken $userAccessToken, BankConnection $bankConnection)
    {
        $httpClient = new Client([
                RequestOptions::HEADERS => [
                    'Authorization' => 'Bearer ' . $userAccessToken->accessToken
                ]
            ]
        );

        try {
            $response = $httpClient->post(
                $this->finApiClientSettings->apiUrl . self::API_IMPORT_BANK_URI,
                [
                    RequestOptions::JSON => (array)$bankConnection
                ]
            );

            $responseCode = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();

            if ($responseCode === 201) {
                return $this->mapToBankConnectionObject(json_decode($responseBody));
            }

            $this->logger->info(self::class . ': Unable to get current logged in user. Code:' . $responseCode . '. Body:' . $responseBody);

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage() . "\n" . $e->getTraceAsString());
        }

        return null;
    }

    /**
     * {
     * "id": 313551,
     * "bankId": 277672,
     * "bank": {
     * "id": 277672,
     * "name": "FinAPI Test Bank",
     * "loginHint": null,
     * "bic": null,
     * "blz": "00000000",
     * "blzs": [
     * "00000000"
     * ],
     * "loginFieldUserId": "Onlinebanking-ID",
     * "loginFieldCustomerId": null,
     * "loginFieldPin": "PIN",
     * "isSupported": true,
     * "supportedDataSources": [
     * "FINTS_SERVER"
     * ],
     * "pinsAreVolatile": false,
     * "location": null,
     * "city": null,
     * "isTestBank": true,
     * "popularity": 734,
     * "health": 100,
     * "lastCommunicationAttempt": "2018-06-12 15:39:35.000",
     * "lastSuccessfulCommunication": "2018-06-12 15:33:48.000"
     * },
     * "name": null,
     * "bankingUserId": null,
     * "bankingCustomerId": null,
     * "bankingPin": null,
     * "type": "DEMO",
     * "updateStatus": "IN_PROGRESS",
     * "categorizationStatus": "READY",
     * "lastManualUpdate": null,
     * "lastAutoUpdate": null,
     * "twoStepProcedures": [],
     * "ibanOnlyMoneyTransferSupported": false,
     * "ibanOnlyDirectDebitSupported": false,
     * "collectiveMoneyTransferSupported": false,
     * "defaultTwoStepProcedureId": null,
     * "accountIds": [
     * 519836
     * ],
     * "owners": null
     * }
     * @param $source
     * @return BankConnection
     */
    private function mapToBankConnectionObject($source)
    {
        $result = new BankConnection();
        $result->bankId = $source->bankId;
        $result->name = $source->name;
        $result->bankingUserId = $source->bankingUserId;
        $result->bankingCustomerId = $source->bankingCustomerId;
        $result->bankingPin = $source->bankingPin;

//        if (isset($source->bank)){
//            $result->bank = new Bank();
//            $result->bank->id = $source->bank->id;
//            $result->bank->name = $source->bank->name;
//        }

        return $result;
    }
}