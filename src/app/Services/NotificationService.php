<?php


namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class NotificationService
{
    /**
     * @var string|mixed
     */
    private string $baseUrlNotification;

    /**
     * @var string|mixed
     */
    private string $uriNotification;

    /**
     * AuthorizationService constructor.
     */
    public function __construct()
    {
        $this->baseUrlNotification = env('BASE_URL_NOTIFICATION');
        $this->uriNotification = env('URI_NOTIFICATION');
    }

    /**
     * Send notification to user
     *
     * @return string
     * @throws GuzzleException
     */
    public function sendNotify(): string
    {
        $client =  new Client([
            'base_uri' => $this->baseUrlNotification,
        ]);

        $response = $client->request('POST', $this->uriNotification);

        $contents = json_decode($response->getBody()->getContents(), true);

        return $contents['message'];
    }
}
