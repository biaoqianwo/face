<?php
namespace Biaoqianwo\Face\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Doctrine\Common\Cache\FilesystemCache;

class CacheProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $pimple)
    {
        $pimple['cache'] = function () {
            return new FilesystemCache(sys_get_temp_dir());
        };
    }
}
