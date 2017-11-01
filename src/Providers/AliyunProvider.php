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
use Biaoqianwo\Face\Aliyun\AppCode;
use Biaoqianwo\Face\Aliyun\OCRManager;
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
            return new OCRManager($app['aliyun.auth']);
        };
    }
}
