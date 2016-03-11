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
            $this->getPath("/inspections/info/dashboard"),
            [
                'Content-Type' => 'application/json',
                'X-LOCATION' => $locationId
            ]
        );

        $response = $this->send($client, $request);
        return json_decode($response->getContents());
    }

    public function getInspectionsStatistic($locationId)
    {
        $client = new GuzzleClient();

        $request = new Request(
            'get',
            $this->getPath("/inspections/info/stats"),
            [
                'Content-Type' => 'application/json',
                'X-LOCATION' => $locationId
            ]
        );

        $response = $this->send($client, $request);
        return json_decode($response->getContents());
    }

    public function getWorkOrdersDashboard($locationId)
    {
        $client = new GuzzleClient();

        $request = new Request(
            'get',
            $this->getPath("/workOrders/info/dashboard"),
            [
                'Content-Type' => 'application/json',
                'X-LOCATION' => $locationId
            ]
        );

        $response = $this->send($client, $request);
        return json_decode($response->getContents());
    }

    /**
     * @param $locationId
     * @param \DateTime $createdDate
     * @param \DateTime $modifiedDate
     * @return mixed
     * @throws \Exception
     */
    public function getSimpleTemplateReport($locationId, $createdDate = null, $modifiedDate = null)
    {
        $client = new GuzzleClient();

        $query = [];
        if(null !== $createdDate) {
            $query['createdDate'] = date('c', $createdDate->getTimestamp());
        }
        if(null !== $modifiedDate) {
            $query['modifiedDate'] = date('c', $modifiedDate->getTimestamp());;
        }

        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath('/reports/templates/simple?'.$query),
            [
                'Content-Type' => 'application/json',
                'X-LOCATION' => $locationId
            ]
        );

        $response = $this->send($client, $request);
        return json_decode($response->getContents());
    }

    protected function getPath($path)
    {
        return $this->endpoint . $path;
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
        try {
            $response = $client->send($request);
            return $response->getBody();
        } catch (GuzzleClientException $e) {
            throw new \Exception('Something bad happened with statistic service', 0, $e);
        }
    }
}
