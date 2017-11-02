<?php
namespace Biaoqianwo\Face\Baidu;

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

    const DETECT = 'https://aip.baidubce.com/rest/2.0/vis-faceattribute/v1/faceattribute';
    const MATCH = 'https://aip.baidubce.com/rest/2.0/face/v2/match';

    public function __construct(AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @param $images
     * @param array $options
     * @return string
     */
    public function detect($images, array $options = [])
    {
        return $this->request(self::DETECT, $this->buildRequestParam($images, $options));
    }

    /**
     * @param $images
     * @param array $options
     * @return string
     */
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
     * @param $images
     * @param array $options
     * @return array
     */
    protected function buildRequestParam($images, $options = [])
    {
        if (is_array($images) && count($images) == 2) {
            $img = FileConverter::toBase64Encode($images[0]);
            $img1 = FileConverter::toBase64Encode($images[1]);
            //images:base64编码后的2张图片数据，半角逗号分隔，单次请求总共最大20M
            $options['images'] = implode(',', array($img, $img1));
        } else {
            $image = $images;
            $options['image'] = FileConverter::toBase64Encode($image);;
        }
        return $options;
    }
}
