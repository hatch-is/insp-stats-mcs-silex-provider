<?php

namespace InspectionStatsMcs;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Class InspStatsMcsSilexProvider
 *
 * @package InspectionStatsMcs
 */
class InspStatsMcsSilexProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     */
    public function register(Application $app)
    {
        $app['hatch-is.insp-stats-mcs.processor'] = $app->share(
            function () use ($app) {
                return new Processor(
                    $app['hatch-is.insp-stats-mcs.endpoint']
                );
            }
        );
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

    }
}
