<?php

/*
 * This file is part of the godruoyi/ocr.
 *
 * (c) godruoyi <godruoyi@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Biaoqianwo\Face\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Biaoqianwo\Face\Baidu\AccessToken;
use Biaoqianwo\Face\Baidu\OCRManager;

class BaiduProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $pimple)
    {
        $pimple['baidu.auth'] = function ($app) {
            return new AccessToken(
                $app['config']->get('app_key'),
                $app['config']->get('secret_key'),
                $app['cache']
            );
        };

        $pimple['baidu'] = function ($app) {
            return new OCRManager($app['baidu.auth']);
        };
    }
}
