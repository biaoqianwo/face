<?php
namespace Biaoqianwo\Face\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Biaoqianwo\Face\Tencent\FaceManager;
use Biaoqianwo\Face\Tencent\Authorization;

class TencentProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $pimple)
    {
        $pimple['tencent.auth'] = function ($app) {
            return new Authorization(
                $app['config']->get('appId'),
                $app['config']->get('secretId'),
                $app['config']->get('secretKey'),
                $app['config']->get('bucket')
            );
        };

        $pimple['tencent'] = function ($app) {
            return new FaceManager($app['tencent.auth']);
        };
    }
}
