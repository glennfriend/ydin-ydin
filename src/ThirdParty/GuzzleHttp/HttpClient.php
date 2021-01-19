<?php
declare(strict_types=1);

namespace Ydin\ThirdParty\GuzzleHttp;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 *
 */
class HttpClient
{
    /**
     * @param string $url
     * @param array $options
     * @return false|array
     * @throws GuzzleException
     */
    static public function query(string $url, array $options = [])
    {
        $client = new GuzzleHttpClient();

        $response = $client->request('GET', $url, $options);
        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            // @see https://developer.mozilla.org/zh-TW/docs/Web/HTTP/Status
        } else {
            return false;
        }

        $body = (string)$response->getBody();
        return json_decode($body, true);
    }

}
