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
            throw new Exception(
                'Inspection statistic service: endpoint is null'
            );
        }

        $this->endpoint = $endpoint;
    }

    /**
     * @param $broadcastId
     *
     * @return mixed
     * @throws \Exception
     */
    public function analyzeBroadcastMessage($broadcastId)
    {
        $client = new GuzzleClient();
        $request = new Request(
            'get',
            $this->getPath(sprintf('/broadcast/%s/analytic', $broadcastId))
        );
        $response = $this->send($client, $request);
        return json_decode($response->getContents());
    }

    /**
     * @param array $filter
     * @param int   $skip
     * @param int   $limit
     *
     * @return mixed
     * @throws \Exception
     */
    public function analyzeBroadcastMessages($filter = [], $skip = 0, $limit = 0)
    {
        $client = new GuzzleClient();

        $query = [
            'skip' => $skip,
            'limit' => $limit,
            'filter' => $filter
        ];
        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath(sprintf('/broadcast/analytic?%s', $query))
        );
        $response = $this->send($client, $request);
        return json_decode($response->getContents());
    }

    /**
     * @param           $locationId
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return mixed
     * @throws \Exception
     */
    public function getInspectionsDashboard($locationId, $start, $end)
    {
        $client = new GuzzleClient();

        $query = [];
        if (null !== $start) {
            $query['start'] = date('c', $start->getTimestamp());
        }
        if (null !== $end) {
            $query['end'] = date('c', $end->getTimestamp());;
        }

        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath(
                sprintf(
                    '/inspections/info/dashboard?%s',
                    $query
                )
            ),
            [
                'Content-Type' => 'application/json',
                'X-LOCATION'   => $locationId
            ]
        );

        $response = $this->send($client, $request);
        return json_decode($response->getContents());
    }

    /**
     * @param           $locationId
     * @param \DateTime $start
     * @param \DateTIme $end
     *
     * @return mixed
     * @throws \Exception
     */
    public function getInspectionsStatistic($locationId, $start, $end)
    {
        $client = new GuzzleClient();

        $query = [];
        if (null !== $start) {
            $query['start'] = date('c', $start->getTimestamp());
        }
        if (null !== $end) {
            $query['end'] = date('c', $end->getTimestamp());;
        }

        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath(
                sprintf(
                    '/inspections/info/stats?%s',
                    $query
                )
            ),
            [
                'Content-Type' => 'application/json',
                'X-LOCATION'   => $locationId
            ]
        );

        $response = $this->send($client, $request);
        return json_decode($response->getContents());
    }

    /**
     * @param           $locationId
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return mixed
     * @throws \Exception
     */
    public function getFollowUpsDashboard($locationId, $start, $end)
    {
        $client = new GuzzleClient();

        $query = [];
        if (null !== $start) {
            $query['start'] = date('c', $start->getTimestamp());
        }
        if (null !== $end) {
            $query['end'] = date('c', $end->getTimestamp());;
        }

        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath(
                sprintf(
                    '/followUps/info/dashboard?%s',
                    $query
                )
            ),
            [
                'Content-Type' => 'application/json',
                'X-LOCATION'   => $locationId
            ]
        );

        $response = $this->send($client, $request);
        return json_decode($response->getContents());
    }

    /**
     * @param           $locationId
     * @param \DateTime $createdDate
     * @param \DateTime $modifiedDate
     *
     * @return mixed
     * @throws \Exception
     */
    public function getSimpleTemplateReport($locationId, $createdDate = null,
        $modifiedDate = null
    ) {
        $client = new GuzzleClient();

        $query = [];
        if (null !== $createdDate) {
            $query['createdDate'] = date('c', $createdDate->getTimestamp());
        }
        if (null !== $modifiedDate) {
            $query['modifiedDate'] = date('c', $modifiedDate->getTimestamp());;
        }

        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath('/reports/templates/simple?' . $query),
            [
                'Content-Type' => 'application/json',
                'X-LOCATION'   => $locationId
            ]
        );

        $response = $this->send($client, $request);
        return json_decode($response->getContents());
    }

    /**
     * @param             $locationId
     * @param string      $state
     * @param \DateTime   $date
     * @param null        $stateParam
     * @param \DateTime   $start
     * @param \DateTime   $end
     *
     * @return mixed
     * @throws \Exception
     */
    public function getInspectionReport($locationId, $state = 'completed',
        $date = null, $stateParam = null, $start = null, $end = null
    ) {
        $client = new GuzzleClient();

        $query = [];
        if (null !== $date) {
            $query['date'] = date('c', $date->getTimestamp());
        }
        if (null !== $stateParam) {
            $query['state'] = $stateParam;
        }
        if (null !== $start) {
            $query['start'] = date('c', $start->getTimestamp());
        }
        if (null !== $end) {
            $query['end'] = date('c', $end->getTimestamp());
        }

        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath(
                sprintf(
                    '/reports/inspections/%s?%s',
                    $state,
                    $query
                )
            ),
            [
                'Content-Type' => 'application/json',
                'X-LOCATION'   => $locationId
            ]
        );

        $response = $this->send($client, $request);

        return json_decode($response->getContents());
    }

    /**
     * @param           $locationId
     * @param null      $templateId
     * @param \DateTime $createdDate
     * @param \DateTime $modifiedDate
     * @param null      $state
     *
     * @return mixed
     * @throws \Exception
     */
    public function getSimpleTemplateVersionReport(
        $locationId,
        $templateId = null,
        $createdDate = null,
        $modifiedDate = null,
        $state = null
    ) {
        $client = new GuzzleClient();

        $query = [];
        if (null !== $createdDate) {
            $query['createdDate'] = date('c', $createdDate->getTimestamp());
        }
        if (null !== $modifiedDate) {
            $query['modifiedDate'] = date('c', $modifiedDate->getTimestamp());
        }
        if (null !== $state) {
            $query['state'] = $state;
        }
        if (null !== $templateId) {
            $query['templateId'] = $templateId;
        }

        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath(
                sprintf(
                    '/reports/templateVersions/simple?%s',
                    $query
                )
            ),
            [
                'Content-Type' => 'application/json',
                'X-LOCATION'   => $locationId
            ]
        );

        $response = $this->send($client, $request);

        return json_decode($response->getContents());
    }

    /**
     * @param           $locationId
     * @param \DateTime $createdDate
     * @param \DateTime $completedDate
     * @param null      $state
     *
     * @return mixed
     * @throws \Exception
     */
    public function getSimpleFollowUpReport(
        $locationId,
        $createdDate = null,
        $completedDate = null,
        $state = null
    ) {
        $client = new GuzzleClient();

        $query = [];
        if (null !== $createdDate) {
            $query['createdDate'] = date('c', $createdDate->getTimestamp());
        }
        if (null !== $completedDate) {
            $query['completedDate'] = date('c', $completedDate->getTimestamp());
        }
        if (null !== $state) {
            $query['state'] = $state;
        }

        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath(
                sprintf(
                    '/reports/followUp/simple?%s',
                    $query
                )
            ),
            [
                'Content-Type' => 'application/json',
                'X-LOCATION'   => $locationId
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
     * @param Request      $request
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
            throw new \Exception(
                'Something bad happened with statistic service', 0, $e
            );
        }
    }
}
