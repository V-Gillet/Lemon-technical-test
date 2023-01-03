<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GeoPluginAPI
{

    public function __construct(private HttpClientInterface $geopluginClient)
    {
    }

    public function geolocate(string $ipAddress)
    {

        $response = $this->geopluginClient->request(
            Request::METHOD_GET,
            '/json.gp',
            [
                'query' => [
                    'ip' => $ipAddress,
                ]
            ]
        );

        $content = $response->toArray();

        return $content;
    }
}
