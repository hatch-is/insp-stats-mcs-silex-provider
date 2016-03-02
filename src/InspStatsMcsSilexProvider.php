<?php

namespace InspectionStatsMcs\IonicPushService;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Class IonicPushServiceProvider
 *
 * @package InspectionStatsMcs\IonicPushService
 */
class IonicPushServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     */
    public function register(Application $app)
    {

    }
    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {
        // TODO: Implement boot() method.
    }
}