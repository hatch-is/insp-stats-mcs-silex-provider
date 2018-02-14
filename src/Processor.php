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

    /**
     * Processor constructor.
     *
     * @param $endpoint
     */
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
     * @param $locationGroup
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function analyzeBroadcastMessage($broadcastId, $locationGroup)
    {
        $client = new GuzzleClient();
        $request = new Request(
            'get',
            $this->getPath(sprintf('/broadcast/%s/analytic', $broadcastId)),
            [
                'content-type'     => 'application/json',
                'x-location-group' => $locationGroup
            ]
        );
        $response = $this->send($client, $request);
        return $response;
    }

    /**
     * @param array $filter
     * @param       $locationGroup
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function analyzeBroadcastMessages($filter = [], $locationGroup)
    {
        $client = new GuzzleClient();

        $query = [
            'filter' => json_encode($filter)
        ];
        $query = http_build_query($query);
        $request = new Request(
            'get',
            $this->getPath(sprintf('/broadcasts/analytics?%s', $query)),
            [
                'content-type'     => 'application/json',
                'x-location-group' => $locationGroup
            ]
        );
        $response = $this->send($client, $request);
        return $response;
    }

    /**
     * @param       $locationId
     * @param       $start
     * @param       $end
     * @param array $filter
     * @param       $locationGroup
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getInspectionsDashboard($locationId, $start, $end,
        $filter = [], $locationGroup
    ) {
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
                'Content-Type'     => 'application/json',
                'X-LOCATION'       => $locationId,
                'x-location-group' => $locationGroup
            ]
        );

        $response = $this->send($client, $request);
        return $response;
    }

    /**
     * @param $locationId
     * @param $start
     * @param $end
     * @param $locationGroup
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getIncidentsDashboard($locationId, $start, $end,
        $locationGroup
    ) {
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
                'Content-Type'     => 'application/json',
                'X-LOCATION'       => $locationId,
                'x-location-group' => $locationGroup
            ]
        );

        $response = $this->send($client, $request);
        return $response;
    }

    /**
     * @param       $locationId
     * @param       $start
     * @param       $end
     * @param array $filter
     * @param       $locationGroup
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getInspectionsStatistic($locationId, $start, $end,
        $filter = [], $locationGroup
    ) {
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
                'Content-Type'     => 'application/json',
                'X-LOCATION'       => $locationId,
                'x-location-group' => $locationGroup
            ]
        );

        $response = $this->send($client, $request);
        return $response;
    }

    /**
     * @param $locationId
     * @param $start
     * @param $end
     * @param $locationGroup
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getIncidentsStatistic($locationId, $start, $end,
        $locationGroup
    ) {
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
                'Content-Type'     => 'application/json',
                'X-LOCATION'       => $locationId,
                'x-location-group' => $locationGroup
            ]
        );

        $response = $this->send($client, $request);
        return $response;
    }

    /**
     * @param $locationId
     * @param $start
     * @param $end
     * @param $locationGroup
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getFollowUpsDashboard($locationId, $start, $end,
        $locationGroup
    ) {
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
                'Content-Type'     => 'application/json',
                'X-LOCATION'       => $locationId,
                'x-location-group' => $locationGroup
            ]
        );

        $response = $this->send($client, $request);
        return $response;
    }

	/**
	 * @param       $locationId
	 * @param null  $createdDate
	 * @param null  $createdDateStart
	 * @param null  $createdDateEnd
	 * @param null  $modifiedDate
	 * @param null  $modifiedDateStart
	 * @param null  $modifiedDateEnd
	 * @param array $filter
	 * @param       $locationGroup
	 * @param       $type
	 * @param       $view
	 * @param       $emails
	 * @param       $notes
	 * @param       $userId
	 *
	 * @return \Psr\Http\Message\StreamInterface
	 */
    public function getSimpleTemplateReport(
        $locationId,
        $createdDate = null,
        $createdDateStart = null,
        $createdDateEnd = null,
        $modifiedDate = null,
        $modifiedDateStart = null,
        $modifiedDateEnd = null,
        $filter = [],
        $locationGroup,
		$type,
		$view,
		$emails,
		$notes,
		$userId
    ) {
        $client = new GuzzleClient();

        $query = [];
        if (null !== $createdDate) {
            $query['createdDate'] = date('c', $createdDate->getTimestamp());
        }
        if (null !== $createdDateStart) {
            $query['createdDateStart'] = date(
                'c', $createdDateStart->getTimestamp()
            );
        }
        if (null !== $createdDateEnd) {
            $query['createdDateEnd'] = date(
                'c', $createdDateEnd->getTimestamp()
            );
        }

        if (null !== $modifiedDate) {
            $query['modifiedDate'] = date('c', $modifiedDate->getTimestamp());
        }
        if (null !== $modifiedDateStart) {
            $query['modifiedDateStart'] = date(
                'c', $modifiedDateStart->getTimestamp()
            );
        }
        if (null !== $modifiedDateEnd) {
            $query['modifiedDateEnd'] = date(
                'c', $modifiedDateEnd->getTimestamp()
            );
        }
        if (!empty($filter)) {
            $query['filter'] = json_encode($filter);
        }
		if (null != $view) {
			$query['view'] = $view;
		}
		if (null != $emails) {
			$query['emails'] = $emails;
		}
		if (null != $notes) {
			$query['notes'] = $notes;
		}
		if ($type != null) {
			$query['type'] = $type;
		}
        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath('/reports/templates/simple?' . $query),
            [
                'Content-Type'     => 'application/json',
                'X-LOCATION'       => $locationId,
                'x-location-group' => $locationGroup,
				'X-USER'           => $userId
            ]
        );

        $response = $this->send($client, $request);
        return $response;
    }

    /**
     * @param       $locationId
     * @param null  $createdDate
     * @param null  $modifiedDate
     * @param array $filter
     * @param       $locationGroup
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getSimpleIncidentTemplateReport(
        $locationId,
        $createdDate = null,
        $modifiedDate = null,
        $filter = [],
        $locationGroup
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
                'Content-Type'     => 'application/json',
                'X-LOCATION'       => $locationId,
                'x-location-group' => $locationGroup
            ]
        );

        $response = $this->send($client, $request);
        return $response;
    }

	/**
	 * @param        $locationId
	 * @param string $state
	 * @param null   $date
	 * @param null   $stateParam
	 * @param null   $start
	 * @param null   $end
	 * @param array  $filter
	 * @param        $type
	 * @param        $view
	 * @param        $emails
	 * @param        $notes
	 * @param        $userId
	 * @param        $locationGroup
	 *
	 * @return \Psr\Http\Message\StreamInterface
	 */
    public function getInspectionReport($locationId, $state = 'completed',
        $date = null, $stateParam = null, $start = null, $end = null,
        $filter = [], $type, $view, $emails, $notes, $userId, $locationGroup
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
		if (null != $view) {
			$query['view'] = $view;
		}
		if (null != $emails) {
			$query['emails'] = $emails;
		}
		if (null != $notes) {
			$query['notes'] = $notes;
		}
		if ($type != null) {
			$query['type'] = $type;
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
                'Content-Type'     => 'application/json',
                'X-LOCATION'       => $locationId,
                'x-location-group' => $locationGroup,
				'X-USER'           => $userId
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

    /**
     * @param $inspectionId
     * @param $userId
     * @param $type
     * @param $view
     * @param $emails
     * @param $notes
     * @param $locationGroup
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getSingleInspectionsReport(
        $inspectionId, $userId, $type, $view, $emails, $notes, $locationGroup
    ) {
        $client = new GuzzleClient();

        $query = [];
        if ($view != null) {
            $query['view'] = $view;
        }
        if ($emails != null) {
            $query['emails'] = $emails;
        }
        if ($notes != null) {
            $query['notes'] = $notes;
        }
        if ($type != null) {
            $query['type'] = $type;
        }

        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath(
                sprintf(
                    "/reports/inspections/single/%s?%s", $inspectionId, $query
                )
            ),
            [
                'Content-Type'     => 'application/json',
                'X-USER'           => $userId,
                'x-location-group' => $locationGroup
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

    /**
     * @param $locationId
     * @param $start
     * @param $end
     * @param $locationGroup
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getIncidentsRate($locationId, $start, $end, $locationGroup)
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
                'Content-Type'     => "application/json",
                'X-LOCATION'       => $locationId,
                'x-location-group' => $locationGroup
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

    /**
     * @param $locationId
     * @param $start
     * @param $end
     * @param $locationGroup
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getRecentFailures($locationId, $start, $end, $locationGroup)
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
                'Content-Type'     => "application/json",
                'X-LOCATION'       => $locationId,
                'x-location-group' => $locationGroup
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

    /**
     * @param $userId
     * @param $type
     * @param $locationId
     * @param $start
     * @param $end
     * @param $view
     * @param $emails
     * @param $notes
     * @param $locationGroup
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getViolationsReport(
        $userId, $type, $locationId, $start, $end, $view, $emails,
        $notes, $locationGroup
    ) {
        $client = new GuzzleClient();

        $query = [];
        if (null !== $start) {
            $query['start'] = date('c', $start->getTimestamp());
        }
        if (null !== $end) {
            $query['end'] = date('c', $end->getTimestamp());
        }

        if (null != $view) {
            $query['view'] = $view;
        }
        if (null != $emails) {
            $query['emails'] = $emails;
        }
        if (null != $notes) {
            $query['notes'] = $notes;
        }
        if ($type != null) {
            $query['type'] = $type;
        }
        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath(
                sprintf("/reports/violations?%s", $query)
            ),
            [
                'Content-Type'     => 'application/json',
                'X-USER'           => $userId,
                'X-LOCATION'       => $locationId,
                'x-location-group' => $locationGroup
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

	/**
	 * @param $userId
	 * @param $type
	 * @param $locationId
	 * @param $start
	 * @param $end
	 * @param $view
	 * @param $emails
	 * @param $notes
	 * @param $locationGroup
	 * @param $name
	 * @param $locations
	 *
	 * @return \Psr\Http\Message\StreamInterface
	 */
    public function getBasedOnTemplateReport(
		$userId, $type, $locationId, $start, $end, $view, $emails,
		$notes, $locationGroup, $name, $locations
	) {
		$client = new GuzzleClient();

		$query = [];
		if (null !== $start) {
			$query['start'] = date('c', $start->getTimestamp());
		}
		if (null !== $end) {
			$query['end'] = date('c', $end->getTimestamp());
		}

		if (null != $view) {
			$query['view'] = $view;
		}
		if (null != $emails) {
			$query['emails'] = $emails;
		}
		if (null != $notes) {
			$query['notes'] = $notes;
		}
		if ($type != null) {
			$query['type'] = $type;
		}
		if ($name != null) {
			$query['name'] = $name;
		}
		if ($locations != null) {
			$query['locations'] = $locations;
		}

		$query = http_build_query($query);

		$request = new Request(
			'get',
			$this->getPath(
				sprintf("/reports/based/templates?%s", $query)
			),
			[
				'Content-Type'     => 'application/json',
				'X-USER'           => $userId,
				'X-LOCATION'       => $locationId,
				'x-location-group' => $locationGroup
			]
		);

		$response = $this->send($client, $request);

		return $response;
	}

    /**
     * @param $userId
     * @param $type
     * @param $locationId
     * @param $start
     * @param $end
     * @param $view
     * @param $emails
     * @param $notes
     * @param $locationGroup
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getNeedToOrderReport(
        $userId, $type, $locationId, $start, $end, $view, $emails,
        $notes, $locationGroup
    ) {
        $client = new GuzzleClient();

        $query = [];
        if (null !== $start) {
            $query['start'] = date('c', $start->getTimestamp());
        }
        if (null !== $end) {
            $query['end'] = date('c', $end->getTimestamp());
        }

        if (null != $view) {
            $query['view'] = $view;
        }
        if (null != $emails) {
            $query['emails'] = $emails;
        }
        if (null != $notes) {
            $query['notes'] = $notes;
        }
        if ($type != null) {
            $query['type'] = $type;
        }
        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath(
                sprintf("/reports/needtoorder?%s", $query)
            ),
            [
                'Content-Type'     => 'application/json',
                'X-USER'           => $userId,
                'X-LOCATION'       => $locationId,
                'x-location-group' => $locationGroup
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

    /**
     * @param $userId
     * @param $type
     * @param $locationId
     * @param $start
     * @param $end
     * @param $view
     * @param $emails
     * @param $notes
     * @param $locationGroup
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getCoachingReport(
        $userId, $type, $locationId, $start, $end, $view, $emails, $notes,
        $locationGroup
    ) {
        $client = new GuzzleClient();

        $query = [];
        if (null !== $start) {
            $query['start'] = date('c', $start->getTimestamp());
        }
        if (null !== $end) {
            $query['end'] = date('c', $end->getTimestamp());
        }

        if (null != $view) {
            $query['view'] = $view;
        }
        if (null != $emails) {
            $query['emails'] = $emails;
        }
        if (null != $notes) {
            $query['notes'] = $notes;
        }
        if ($type != null) {
            $query['type'] = $type;
        }
        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath(
                sprintf("/reports/coaching?%s", $query)
            ),
            [
                'Content-Type'     => 'application/json',
                'X-USER'           => $userId,
                'X-LOCATION'       => $locationId,
                'x-location-group' => $locationGroup
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

	/**
	 * @param $userId
	 * @param $type
	 * @param $locationId
	 * @param $start
	 * @param $end
	 * @param $view
	 * @param $emails
	 * @param $notes
	 * @param $locationGroup
	 *
	 * @return \Psr\Http\Message\StreamInterface
	 */
	public function getDatedItemsReport(
		$userId, $type, $locationId, $start, $end, $view, $emails, $notes,
		$locationGroup
	) {
		$client = new GuzzleClient();

		$query = [];
		if (null !== $start) {
			$query['start'] = date('c', $start->getTimestamp());
		}
		if (null !== $end) {
			$query['end'] = date('c', $end->getTimestamp());
		}

		if (null != $view) {
			$query['view'] = $view;
		}
		if (null != $emails) {
			$query['emails'] = $emails;
		}
		if (null != $notes) {
			$query['notes'] = $notes;
		}
		if ($type != null) {
			$query['type'] = $type;
		}
		$query = http_build_query($query);

		$request = new Request(
			'get',
			$this->getPath(
				sprintf("/reports/dated-items?%s", $query)
			),
			[
				'Content-Type'     => 'application/json',
				'X-USER'           => $userId,
				'X-LOCATION'       => $locationId,
				'x-location-group' => $locationGroup
			]
		);

		$response = $this->send($client, $request);

		return $response;
	}

	/**
	 * @param $userId
	 * @param $locationId
	 * @param $start
	 * @param $end
	 * @param $locationGroup
	 *
	 * @return \Psr\Http\Message\StreamInterface
	 */
    public function getAerialReport(
    	$userId, $locationId, $start, $end, $locationGroup
	)
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
				sprintf("/reports/aerial?%s", $query)
			),
			[
				'Content-Type'     => 'application/json',
				'X-USER'           => $userId,
				'X-LOCATION'       => $locationId,
				'x-location-group' => $locationGroup
			]
		);

		$response = $this->send($client, $request);

		return $response;
	}

    /**
     * @param $incidentId
     * @param $userId
     * @param $type
     * @param $view
     * @param $emails
     * @param $notes
     * @param $locationGroup
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getSingleIncidentsReport(
        $incidentId, $userId, $type, $view, $emails, $notes, $locationGroup
    ) {
        $client = new GuzzleClient();

        $query = [];
        if ($view != null) {
            $query['view'] = $view;
        }
        if ($emails != null) {
            $query['emails'] = $emails;
        }
        if ($notes != null) {
            $query['notes'] = $notes;
        }
        if ($type != null) {
            $query['type'] = $type;
        }
        $query = http_build_query($query);

        $request = new Request(
            'get',
            $this->getPath(
                sprintf("/reports/incidents/single/%s?%s", $incidentId, $query)
            ),
            [
                'Content-Type'     => 'application/json',
                'X-USER'           => $userId,
                'x-location-group' => $locationGroup
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

    /**
     * @param       $locationId
     * @param array $filter
     * @param       $locationGroup
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getSpecificReport($locationId, $filter = [], $locationGroup)
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
                'Content-Type'     => 'application/json',
                'X-LOCATION'       => $locationId,
                'x-location-group' => $locationGroup
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

	/**
	 * @param       $locationId
	 * @param null  $templateId
	 * @param null  $createdDate
	 * @param null  $createdDateStart
	 * @param null  $createdDateEnd
	 * @param null  $modifiedDate
	 * @param null  $modifiedDateStart
	 * @param null  $modifiedDateEnd
	 * @param null  $state
	 * @param array $filter
	 * @param       $locationGroup
	 * @param       $type
	 * @param       $view
	 * @param       $emails
	 * @param       $notes
	 * @param       $userId
	 *
	 * @return \Psr\Http\Message\StreamInterface
	 */
    public function getSimpleTemplateVersionReport(
        $locationId,
        $templateId = null,
        $createdDate = null,
        $createdDateStart = null,
        $createdDateEnd = null,
        $modifiedDate = null,
        $modifiedDateStart = null,
        $modifiedDateEnd = null,
        $state = null,
        $filter = [],
        $locationGroup,
		$type,
		$view,
		$emails,
		$notes,
		$userId
    ) {
        $client = new GuzzleClient();

        $query = [];

        if (null !== $createdDate) {
            $query['createdDate'] = date('c', $createdDate->getTimestamp());
        }
        if (null !== $createdDateStart) {
            $query['createdDateStart'] = date(
                'c', $createdDateStart->getTimestamp()
            );
        }
        if (null !== $createdDateEnd) {
            $query['createdDateEnd'] = date(
                'c', $createdDateEnd->getTimestamp()
            );
        }


        if (null !== $modifiedDate) {
            $query['modifiedDate'] = date('c', $modifiedDate->getTimestamp());
        }
        if (null !== $modifiedDateStart) {
            $query['modifiedDateStart'] = date(
                'c', $modifiedDateStart->getTimestamp()
            );
        }
        if (null !== $modifiedDateEnd) {
            $query['modifiedDateEnd'] = date(
                'c', $modifiedDateEnd->getTimestamp()
            );
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

		if (null != $view) {
			$query['view'] = $view;
		}
		if (null != $emails) {
			$query['emails'] = $emails;
		}
		if (null != $notes) {
			$query['notes'] = $notes;
		}
		if ($type != null) {
			$query['type'] = $type;
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
                'Content-Type'     => 'application/json',
                'X-LOCATION'       => $locationId,
                'x-location-group' => $locationGroup,
				'X-USER'           => $userId
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

    /**
     * @param           $locationId
     * @param string    $state
     * @param \DateTime $date
     * @param null      $stateParam
     * @param \DateTime $start
     * @param \DateTime $end
     * @param array     $filter
     * @param           $locationGroup
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getIncidentReport($locationId, $state = 'completed',
        $date = null, $stateParam = null, $start = null, $end = null,
        $filter = [], $locationGroup
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
                    '/reports/incidents/%s?%s',
                    $state,
                    $query
                )
            ),
            [
                'Content-Type'     => 'application/json',
                'X-LOCATION'       => $locationId,
                'x-location-group' => $locationGroup
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
     * @param           $locationGroup
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getSimpleIncidentTemplateVersionReport(
        $locationId,
        $templateId = null,
        $createdDate = null,
        $modifiedDate = null,
        $state = null,
        $filter = [],
        $locationGroup
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
                'Content-Type'     => 'application/json',
                'X-LOCATION'       => $locationId,
                'x-location-group' => $locationGroup
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

	/**
	 * @param       $locationId
	 * @param null  $createdDate
	 * @param null  $createdDateStart
	 * @param null  $createdDateEnd
	 * @param null  $completedDate
	 * @param null  $completedDateStart
	 * @param null  $completedDateEnd
	 * @param null  $state
	 * @param array $filter
	 * @param       $locationGroup
	 * @param       $type
	 * @param       $view
	 * @param       $emails
	 * @param       $notes
	 * @param       $userId
	 *
	 * @return \Psr\Http\Message\StreamInterface
	 */
    public function getSimpleFollowUpReport(
        $locationId,
        $createdDate = null,
        $createdDateStart = null,
        $createdDateEnd = null,
        $completedDate = null,
        $completedDateStart = null,
        $completedDateEnd = null,
        $state = null,
        $filter = [],
        $locationGroup,
		$type,
		$view,
		$emails,
		$notes,
		$userId
    ) {
        $client = new GuzzleClient();

        $query = [];

        //createdDate
        if (null !== $createdDate) {
            $query['createdDate'] = date('c', $createdDate->getTimestamp());
        }
        if (null !== $createdDateStart) {
            $query['createdDateStart'] = date(
                'c', $createdDateStart->getTimestamp()
            );
        }
        if (null !== $createdDateEnd) {
            $query['createdDateEnd'] = date(
                'c', $createdDateEnd->getTimestamp()
            );
        }

        //completedDate
        if (null !== $completedDate) {
            $query['completedDate'] = date('c', $completedDate->getTimestamp());
        }
        if (null !== $completedDateStart) {
            $query['completedDateStart'] = date(
                'c', $completedDateStart->getTimestamp()
            );
        }
        if (null !== $completedDateEnd) {
            $query['completedDateEnd'] = date(
                'c', $completedDateEnd->getTimestamp()
            );
        }
        if (null !== $state) {
            $query['state'] = $state;
        }
        if (!empty($filter)) {
            $query['filter'] = json_encode($filter);
        }

		if (null != $view) {
			$query['view'] = $view;
		}
		if (null != $emails) {
			$query['emails'] = $emails;
		}
		if (null != $notes) {
			$query['notes'] = $notes;
		}
		if ($type != null) {
			$query['type'] = $type;
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
                'Content-Type'     => 'application/json',
                'X-LOCATION'       => $locationId,
                'x-location-group' => $locationGroup,
				'X-USER'           => $userId,
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

	/**
	 * @param $locationId
	 * @param $start
	 * @param $end
	 * @param $locationGroup
	 *
	 * @return \Psr\Http\Message\StreamInterface
	 * @throws \Exception
	 */
    public function getInspectionsDashboardActivity($locationId, $start, $end,
        $locationGroup
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
                    '/dashboard/activity/inspections?%s',
                    $query
                )
            ),
            [
                'Content-Type'     => 'application/json',
                'X-LOCATION'       => $locationId,
                'x-location-group' => $locationGroup
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

	/**
	 * @param $locationId
	 * @param $start
	 * @param $end
	 * @param $locationGroup
	 *
	 * @return \Psr\Http\Message\StreamInterface
	 * @throws \Exception
	 */
    public function getDashboardInspectionByUsersActivity($locationId, $start, $end,
		$locationGroup
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
					'/dashboard/userInspections/activity?%s',
					$query
				)
			),
			[
				'Content-Type'     => 'application/json',
				'X-LOCATION'       => $locationId,
				'x-location-group' => $locationGroup
			]
		);

		$response = $this->send($client, $request);

		return $response;
	}
	/**
	 * @param $locationId
	 * @param $start
	 * @param $end
	 * @param $period
	 * @param $locationGroup
	 *
	 * @return \Psr\Http\Message\StreamInterface
	 * @throws \Exception
	 */
    public function getDashboardInspectionActivity($locationId, $start, $end, $period, $locationGroup)
	{
		$client = new GuzzleClient();

		$query = [
			'start'  => date('c', $start->getTimestamp()),
			'end'    => date('c', $end->getTimestamp()),
			'period' => $period
		];

		$query = http_build_query($query);
		$request = new Request(
			'get',
			$this->getPath(
				sprintf('/dashboard/inspections/activity?%s',$query)
			),
			[
				'Content-Type'     => 'application/json',
				'X-LOCATION'       => $locationId,
				'x-location-group' => $locationGroup
			]
		);

		$response = $this->send($client, $request);

		return $response;
	}

    /**
     * @param $locationId
     * @param $start
     * @param $end
     * @param $locationGroup
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getIncidentsDashboardActivity($locationId, $start, $end,
        $locationGroup
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
                    '/dashboard/activity/incidents?%s',
                    $query
                )
            ),
            [
                'Content-Type'     => 'application/json',
                'X-LOCATION'       => $locationId,
                'x-location-group' => $locationGroup
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

    /**
     * @param $locationId
     * @param $start
     * @param $end
     * @param $locationGroup
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getInspectionsDashboardDailyActivity($locationId, $start,
        $end, $locationGroup
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
                'Content-Type'     => 'application/json',
                'X-LOCATION'       => $locationId,
                'x-location-group' => $locationGroup
            ]
        );

        $response = $this->send($client, $request);

        return $response;
    }

    /**
     * @param $locationId
     * @param $start
     * @param $end
     * @param $locationGroup
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getIncidentsDashboardDailyActivity($locationId, $start,
        $end, $locationGroup
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
                'Content-Type'     => 'application/json',
                'X-LOCATION'       => $locationId,
                'x-location-group' => $locationGroup
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
                'body'       => json_decode($response->getBody(), true),
                'headers'    => [],
                'statusCode' => $response->getStatusCode()
            ];

            if (!empty($total = $response->getHeader('X-Total-Count'))) {
                $data['headers']['X-Total-Count'] = $total;
            }
            if (!empty($rate = $response->getHeader('X-Ratelimit-Remaining'))) {
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
