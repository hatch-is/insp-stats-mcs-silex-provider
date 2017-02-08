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
     * @return \Psr\Http\Message\StreamInterface
     */
    public function analyzeBroadcastMessage($broadcastId)
    {
        $client = new GuzzleClient();
        $request = new Request(
            'get',
            $this->getPath(sprintf('/broadcast/%s/analytic', $broadcastId))
        );
        $response = $this->send($client, $request);
        return $response;
    }

    /**
     * @param array $filter
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function analyzeBroadcastMessages($filter = []) {
        $client = new GuzzleClient();

        $query = [
            'filter' => json_encode($filter)
        ];
        $query = http_build_query($query);
        $request = new Request(
            'get',
            $this->getPath(sprintf('/broadcasts/analytics?%s', $query)),
            [
                'Content-Type' => 'application/json'
            ]
        );
        $response = $this->send($client, $request);
        return $response;
    }

    /**
     * @param           $locationId
     * @param \DateTime $start
     * @param \DateTime $end
     * @param array     $filter
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getInspectionsDashboard($locationId, $start, $end, $filter = [])
    {
        $client = new GuzzleClient();

        $query = [];
        if (null !== $start) {
            $query['start'] = date('c', $start->getTimestamp());
        }
        if (null !== $end) {
            $query['end'] = date('c', $end->getTimestamp());;
        }

        if (!empty($filter)) {
            $query['filter'] = json_encode($filter);
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
        return $response;
    }

    /**
     * @param           $locationId
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getIncidentsDashboard($locationId, $start, $end)
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
                    '/incidents/info/dashboard?%s',
                    $query
                )
            ),
            [
                'Content-Type' => 'application/json',
                'X-LOCATION'   => $locationId
            ]
        );

        $response = $this->send($client, $request);
        return $response;
    }

    /**
     * @param           $locationId
     * @param \DateTime $start
     * @param \DateTIme $end
     * @param array     $filter
     *
     * @return mixed
     * @throws \Exception
     */
    public function getInspectionsStatistic($locationId, $start, $end, $filter = [])
    {
        $client = new GuzzleClient();

        $query = [];
        if (null !== $start) {
            $query['start'] = date('c', $start->getTimestamp());
        }
        if (null !== $end) {
            $query['end'] = date('c', $end->getTimestamp());;
        }

        if (!empty($filter)) {
            $query['filter'] = json_encode($filter);
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
        return $response;
    }

    /**
     * @param           $locationId
     * @param \DateTime $start
     * @param \DateTIme $end
     *
     * @return mixed
     * @throws \Exception
     */
    public function getIncidentsStatistic($locationId, $start, $end)
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
                    '/incidents/info/stats?%s',
                    $query
                )
            ),
            [
                'Content-Type' => 'application/json',
                'X-LOCATION'   => $locationId
            ]
        );

        $response = $this->send($client, $request);
        return $response;
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
        return $response;
    }

    /**
     * @param           $locationId
     * @param \DateTime $createdDate
     * @param \DateTime $modifiedDate
     * @param array     $filter
     *
     * @return mixed
     * @throws \Exception
     */
    public function getSimpleTemplateReport($locationId, $createdDate = null,
        $modifiedDate = null, $filter = []
    ) {
        $client = new GuzzleClient();

        $query = [];
        if (null !== $createdDate) {
            $query['createdDate'] = date('c', $createdDate->getTimestamp());
        }
        if (null !== $modifiedDate) {
            $query['modifiedDate'] = date('c', $modifiedDate->getTimestamp());;
        }
        if (!empty($filter)) {
            $query['filter'] = json_encode($filter);
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
        return $response;
    }

    /**
     * @param           $locationId
     * @param \DateTime $createdDate
     * @param \DateTime $modifiedDate
     * @param array     $filter
     *
     * @return mixed
     * @throws \Exception
     */
    public function getSimpleIncidentTemplateReport(
        $locationId,
        $createdDate = null,
        $modifiedDate = null,
        $filter = []
    ) {
        $client = new GuzzleClient();

        $query = [];
        if (null !== $createdDate) {
            $query['createdDate'] = date('c', $createdDate->getTimestamp());
        }
        if (null !== $modifiedDate) {
            $query['modifiedDate'] = date('c', $modifiedDate->getTimestamp());;
        }
        if (!empty($filter)) {
            $query['filter'] = json_encode($filter);
        }

        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath('/reports/incidentTemplates/simple?' . $query),
            [
                'Content-Type' => 'application/json',
                'X-LOCATION'   => $locationId
            ]
        );

        $response = $this->send($client, $request);
        return $response;
    }

    /**
     * @param             $locationId
     * @param string      $state
     * @param \DateTime   $date
     * @param null        $stateParam
     * @param \DateTime   $start
     * @param \DateTime   $end
     * @param array       $filter
     *
     * @return mixed
     * @throws \Exception
     */
    public function getInspectionReport($locationId, $state = 'completed',
        $date = null, $stateParam = null, $start = null, $end = null, $filter = []
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
        if (!empty($filter)) {
            $query['filter'] = json_encode($filter);
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

        return $response;
    }

    /**
     * @param string $inspectionId
     * @param string $userId
     * @param string $type
     * @param string $email
     * @param string $view
     * @param string $emails
     *
     * @return mixed
     * @throws \Exception
     */
    public function getSingleInspectionsReport(
        $inspectionId, $userId, $type, $email, $view, $emails
    ) {
        $client = new GuzzleClient();

        $query = [];
        if ($view != null) {
            $query['view'] = $view;
        }
        if ($emails != null) {
            $query['emails'] = $emails;
        }

        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath(
                sprintf("/reports/inspections/single/%s?%s", $inspectionId, $query)
            ),
            [
                'Content-Type' => $type,
                'X-USER' => $userId,
                'X-EMAIL' => $email
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

    /**
     * @param $locationId
     * @param $start
     * @param $end
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getIncidentsRate($locationId, $start, $end)
    {
        $client = new GuzzleClient();

        $query = [];
        if (null !== $start) {
            $query['start'] = $start;
        }
        if (null !== $end) {
            $query['end'] = $end;
        }
        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath(
                sprintf("/dashboard/incidents/rir?%s", $query)
            ),
            [
                'Content-Type' => "application/json",
                'X-LOCATION' => $locationId
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

    /**
     * @param $locationId
     * @param $start
     * @param $end
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getRecentFailures($locationId, $start, $end)
    {
        $client = new GuzzleClient();

        $query = [];
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
                sprintf("/dashboard/recentFailures?%s", $query)
            ),
            [
                'Content-Type' => "application/json",
                'X-LOCATION' => $locationId
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

    /**
     * @param $userId
     * @param $type
     * @param $email
     * @param $locationId
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getViolationsReport(
        $userId, $type, $email, $locationId, $start, $end
    ) {
        $client = new GuzzleClient();

        $query = [];
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
                sprintf("/reports/violations?%s", $query)
            ),
            [
                'Content-Type' => $type,
                'X-USER' => $userId,
                'X-EMAIL' => $email,
                'X-LOCATION' => $locationId
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

    /**
     * @param $userId
     * @param $type
     * @param $email
     * @param $locationId
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getCoachingReport(
        $userId, $type, $email, $locationId, $start, $end
    ) {
        $client = new GuzzleClient();

        $query = [];
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
                sprintf("/reports/coaching?%s", $query)
            ),
            [
                'Content-Type' => $type,
                'X-USER' => $userId,
                'X-EMAIL' => $email,
                'X-LOCATION' => $locationId
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

    /**
     * @param string $incidentId
     * @param string $userId
     * @param string $type
     * @param string $email
     * @param string $view
     * @param string $emails
     *
     * @return mixed
     * @throws \Exception
     */
    public function getSingleIncidentsReport(
        $incidentId, $userId, $type, $email, $view, $emails
    ) {
        $client = new GuzzleClient();

        $query = [];
        if ($view != null) {
            $query['view'] = $view;
        }
        if ($emails != null) {
            $query['emails'] = $emails;
        }
        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath(
                sprintf("/reports/incidents/single/%s?%s", $incidentId, $query)
            ),
            [
                'Content-Type' => $type,
                'X-USER' => $userId,
                'X-EMAIL' => $email
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

    /**
     * @param       $locationId
     * @param array $filter
     *
     * @return mixed
     */
    public function getSpecificReport($locationId, $filter = [])
    {
        $client = new GuzzleClient();

        $query = [];
        if (!empty($filter)) {
            $query['filter'] = json_encode($filter);
        }
        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath(
                sprintf("/reports/specific?%s", $query)
            ),
            [
                'X-LOCATION' => $locationId
            ]
        );
        
        $response = $this->send($client, $request);

        return $response;
    }

    /**
     * @param           $locationId
     * @param null      $templateId
     * @param \DateTime $createdDate
     * @param \DateTime $modifiedDate
     * @param null      $state
     * @param array     $filter
     *
     * @return mixed
     * @throws \Exception
     */
    public function getSimpleTemplateVersionReport(
        $locationId,
        $templateId = null,
        $createdDate = null,
        $modifiedDate = null,
        $state = null,
        $filter = []
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
        if (!empty($filter)) {
            $query['filter'] = json_encode($filter);
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

        return $response;
    }

    /**
     * @param             $locationId
     * @param string      $state
     * @param \DateTime   $date
     * @param null        $stateParam
     * @param \DateTime   $start
     * @param \DateTime   $end
     * @param array       $filter
     *
     * @return mixed
     * @throws \Exception
     */
    public function getIncidentReport($locationId, $state = 'completed',
        $date = null, $stateParam = null, $start = null, $end = null, $filter = []
    )
    {
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
        if (!empty($filter)) {
            $query['filter'] = json_encode($filter);
        }
        $query = http_build_query($query);
        $request = new Request(
            'get',
            $this->getPath(
                sprintf(
                    '/reports/incidents/%s?%s',
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
        return $response;
    }

    /**
     * @param           $locationId
     * @param null      $templateId
     * @param \DateTime $createdDate
     * @param \DateTime $modifiedDate
     * @param null      $state
     * @param array     $filter
     *
     * @return mixed
     * @throws \Exception
     */
    public function getSimpleIncidentTemplateVersionReport(
        $locationId,
        $templateId = null,
        $createdDate = null,
        $modifiedDate = null,
        $state = null,
        $filter = []
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
        if (!empty($filter)) {
            $query['filter'] = json_encode($filter);
        }

        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath(
                sprintf(
                    '/reports/incidentsTemplateVersions/simple?%s',
                    $query
                )
            ),
            [
                'Content-Type' => 'application/json',
                'X-LOCATION'   => $locationId
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

    /**
     * @param           $locationId
     * @param \DateTime $createdDate
     * @param \DateTime $completedDate
     * @param null      $state
     * @param array     $filter
     *
     * @return mixed
     * @throws \Exception
     */
    public function getSimpleFollowUpReport(
        $locationId,
        $createdDate = null,
        $completedDate = null,
        $state = null,
        $filter = []
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
        if (!empty($filter)) {
            $query['filter'] = json_encode($filter);
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

        return $response;
    }

    /**
     * @param           $locationId
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return mixed
     * @throws \Exception
     */
    public function getInspectionsDashboardActivity($locationId, $start, $end)
    {
        $client = new GuzzleClient();

        $query = [
            'start' => date('c', $start->getTimestamp()),
            'end'   => date('c', $end->getTimestamp())
        ];

        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath(
                sprintf(
                    '/dashboard/activity/inspections?%s',
                    $query
                )
            ),
            [
                'Content-Type' => 'application/json',
                'X-LOCATION'   => $locationId
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

    /**
     * @param           $locationId
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return mixed
     * @throws \Exception
     */
    public function getIncidentsDashboardActivity($locationId, $start, $end)
    {
        $client = new GuzzleClient();

        $query = [
            'start' => date('c', $start->getTimestamp()),
            'end'   => date('c', $end->getTimestamp())
        ];

        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath(
                sprintf(
                    '/dashboard/activity/incidents?%s',
                    $query
                )
            ),
            [
                'Content-Type' => 'application/json',
                'X-LOCATION'   => $locationId
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

    /**
     * @param $locationId
     * @param $start
     * @param $end
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getInspectionsDashboardDailyActivity($locationId, $start,
        $end
    ) {
        $client = new GuzzleClient();

        $query = [
            'start' => date('c', $start->getTimestamp()),
            'end'   => date('c', $end->getTimestamp())
        ];

        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath(
                sprintf(
                    '/dashboard/dailyActivity/inspections?%s',
                    $query
                )
            ),
            [
                'Content-Type' => 'application/json',
                'X-LOCATION'   => $locationId
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

    /**
     * @param           $locationId
     * @param \Datetime $start
     * @param \DateTime $end
     */
    public function getIncidentsDashboardDailyActivity($locationId, $start, $end
    ) {
        $client = new GuzzleClient();

        $query = [
            'start' => date('c', $start->getTimestamp()),
            'end'   => date('c', $end->getTimestamp())
        ];

        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath(
                sprintf(
                    '/dashboard/dailyActivity/incidents?%s',
                    $query
                )
            ),
            [
                'Content-Type' => 'application/json',
                'X-LOCATION'   => $locationId
            ]
        );

        $response = $this->send($client, $request);

        return $response;
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
            $data = [
                'body' => json_decode($response->getBody(), true),
                'headers' => [],
                'statusCode' => $response->getStatusCode()
            ];

            if(!empty($total = $response->getHeader('X-Total-Count'))) {
                $data['headers']['X-Total-Count'] = $total;
            }
            if(!empty($rate = $response->getHeader('X-Ratelimit-Remaining'))) {
                $data['headers']['X-Ratelimit-Remaining'] = $rate;
            }
            return $data;
        } catch (GuzzleClientException $e) {
            $message = $this->formatErrorMessage($e);
            throw new \Exception(json_encode($message), 0, $e);
        }
    }

    /**
     * @param GuzzleClientException $httpException
     *
     * @return array
     */
    protected function formatErrorMessage($httpException)
    {
        $message = [
            'message'  => 'Something bad happened with statistic service',
            'request'  => [
                'headers' => $httpException->getRequest()->getHeaders(),
                'body'    => $httpException->getRequest()->getBody()
            ],
            'response' => [
                'headers' => $httpException->getResponse()->getHeaders(),
                'body'    => $httpException->getResponse()->getBody()
                    ->getContents(),
                'status'  => $httpException->getResponse()->getStatusCode()
            ]
        ];

        return $message;
    }
}
