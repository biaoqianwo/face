<?php
namespace Biaoqianwo\Face\Baidu;

use RuntimeException;
use Doctrine\Common\Cache\Cache;
use Biaoqianwo\Face\Support\FileConverter;
use Biaoqianwo\Face\Support\Http;

/**
 * Class FaceManager
 * 百度人脸识别地址：http://ai.baidu.com/docs#/Face-PHP-SDK/top
 * @package Biaoqianwo\Face\Baidu
 */
class FaceManager
{
    protected $accessToken;

    /**
     * API Whether to support url
     * @var boolean
     */
    protected $supportUrl = true;

    const DETECT = 'https://aip.baidubce.com/rest/2.0/vis-faceattribute/v1/faceattribute';
    const MATCH = 'https://aip.baidubce.com/rest/2.0/face/v2/match';

    public function __construct(AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @param $image
     * @param array $options
     * ('max_face_num' => 1,
     * 'face_fields' => 'expression')
     * @return string
     */
    public function detect($image, array $options = [])
    {
        return $this->request(self::DETECT, $this->buildRequestParam($images, $options));
    }

    public function match($images, array $options = [])
    {
        return $this->request(self::MATCH, $this->buildRequestParam($images, $options));
    }


    /**
     * Append access_token to this url
     *
     * @param  string $url
     *
     * @return string
     */
    protected function request($url, array $options = [])
    {
        $httpClient = new Http;
        try {
            $response = $httpClient->request('POST', $url, [
                'form_params' => $options,
                'query' => [$this->accessToken->getQueryName() => $this->accessToken->getAccessToken(true)]
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
            } else {
                throw $e;
            }
        }

        return $httpClient->parseJson($response);
    }

    /**
     *  Build Request Param
     * @param string|\SplFileInfo $images
     * @param array $options
     * @return array
     */
    protected function buildRequestParam($images, $options = [])
    {
        if (is_array($images) && !empty($images[0])) {
            $images = $images[0];
        }

        if (!$this->supportUrl && FileConverter::isUrl($images)) {
            throw new RuntimeException('current method not support online picture.');
        }

        if ($this->supportUrl && FileConverter::isUrl($images)) {
            $options['url'] = $images;
        } else {
            $options['image'] = FileConverter::toBase64Encode($images);
        }

        return $options;
    }
}
