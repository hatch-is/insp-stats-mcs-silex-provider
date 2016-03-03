<?php

namespace InspectionStatsMcs;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException as GuzzleClientException;
use GuzzleHttp\Psr7\Request;
use Symfony\Component\Security\Acl\Exception\Exception;

/**
 * Class Processor
 *
 * @package InspectionStatsMcs
 */
class Processor
{
    protected $endpoint;

    public function __construct($endpoint)
    {
        if (null === $endpoint) {
            throw new Exception('Inspection statistic service: endpoint is null');
        }

        $this->endpoint = $endpoint;
    }

    public function getInspectionsDashboard($locationId)
    {
        $client = new GuzzleClient();

        $request = new Request(
            'get',
            $this->getPath("/inspections/dashboard"),
            [
                'Content-Type' => 'application/json',
                'X-LOCATION' => $locationId
            ]
        );

        $response = $this->send($client, $request);
        return $response;
    }

    protected function getPath($path)
    {
        return $this->endpoint . '/' . $path;
    }

    /**
     * @param GuzzleClient $client
     * @param Request $request
     *
     * @return \Psr\Http\Message\StreamInterface
     * @throws \Exception
     */
    public function send(GuzzleClient $client, Request $request)
    {
        $uri = $request->getUri();
        $path = $this->endpoint . $uri->getPath();
        $uri = $uri->withPath($path);
        $request = $request->withUri($uri);

        try {
            $response = $client->send($request);
            return $response->getBody();
        } catch (GuzzleClientException $e) {
            throw new \Exception('Something bad happened with statistic service', 0, $e);
        }
    }
}
