<?php


namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class AuthorizationService
 * @package App\Services
 */
class AuthorizationService
{
    /**
     * @var string|mixed
     */
    private string $baseUrlAuthorization;

    /**
     * @var string|mixed
     */
    private string $uriAuthorization;

    /**
     * AuthorizationService constructor.
     */
    public function __construct()
    {
        $this->baseUrlAuthorization = env('BASE_URL_AUTHORIZATION');
        $this->uriAuthorization = env('URI_AUTHORIZATION');
    }

    /**
     * Check for authorization transaction
     *
     * @return string
     * @throws GuzzleException
     */
    public function checkAuthorization(): string
    {
        $client =  new Client(['base_uri' => $this->baseUrlAuthorization, 'verify' => false]);

        $response = $client->request('GET', $this->uriAuthorization);

        $contents = json_decode($response->getBody()->getContents(), true);

        return $contents['message'];
    }
}
