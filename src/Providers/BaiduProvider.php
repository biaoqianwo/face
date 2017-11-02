<?php
namespace Biaoqianwo\Face\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Biaoqianwo\Face\Baidu\AccessToken;
use Biaoqianwo\Face\Baidu\FaceManager;

class BaiduProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $pimple)
    {
        $pimple['baidu.auth'] = function ($app) {
            return new AccessToken(
                $app['config']->get('appKey'),
                $app['config']->get('secretKey'),
                $app['cache']
            );
        };

        $pimple['baidu'] = function ($app) {
            return new FaceManager($app['baidu.auth']);
        };
    }
}
