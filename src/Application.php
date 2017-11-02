<?php
namespace Biaoqianwo\Face;

use Exception;
use Pimple\Container;
use Biaoqianwo\Face\Support\Config;

/**
 * @author  <biaoqianwo 704872038@qq.com>
 * @copyright 2017
 *
 * @see  http://ai.baidu.com/docs#/Face-API/top
 * @see  https://github.com/biaoqianwo/face
 *
 * @property string $baidu 百度AI人脸识别
 *     method match($images, $options = []) 人脸比对
 */
class Application extends Container
{
    /**
     * Default Providers
     *
     * @var array
     */
    protected $providers = [
        Providers\CacheProvider::class,
        Providers\BaiduProvider::class,
        Providers\TencentProvider::class,
        Providers\AliyunProvider::class,
    ];

    /**
     * Initeral Application Instance
     *
     * @param string|array $configs
     */
    public function __construct($configs = null)
    {
        $this['config'] = new Config($configs);
        $this->registerProviders();
    }

    /**
     * Register Provider
     *
     * @return void
     */
    protected function registerProviders()
    {
        foreach (array_merge($this->providers, $this['config']->get('providers', [])) as $provider) {
            $this->register(new $provider);
        }
    }

    /**
     * @param $property
     * @return mixed
     * @throws Exception
     */
    public function __get($property)
    {
        if (isset($this[$property])) {
            return $this[$property];
        }
        throw new Exception(sprintf('Property "%s" is not defined.', $property));
    }

    /**
     * @return mixed
     */
    public function baidu()
    {
        return $this['baidu'];
    }

    /**
     * @return mixed
     */
    public function aliyun()
    {
        return $this['aliyun'];
    }

    /**
     * @return mixed
     */
    public function tencent()
    {
        return $this['tencent'];
    }
}
