<?php
namespace Biaoqianwo\Face\Providers;

use Pimple\Container;
use Biaoqianwo\Face\Aliyun\AppCode;
use Biaoqianwo\Face\Aliyun\FaceManager;
use Pimple\ServiceProviderInterface;

class AliyunProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $pimple)
    {
        $pimple['aliyun.auth'] = function ($app) {
            return new AppCode($app['config']->get('appcode'));
        };

        $pimple['aliyun'] = function ($app) {
            return new FaceManager($app['aliyun.auth']);
        };
    }
}
