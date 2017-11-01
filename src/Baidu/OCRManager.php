<?php

/*
 * This file is part of the godruoyi/ocr.
 *
 * (c) godruoyi <godruoyi@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Biaoqianwo\Face\Baidu;

use RuntimeException;
use Doctrine\Common\Cache\Cache;
use Biaoqianwo\Face\Support\FileConverter;
use Biaoqianwo\Face\Support\Http;

/**
 * @author    godruoyi godruoyi@gmail.com>
 * @copyright 2017
 *
 * @see  http://ai.baidu.com/docs#/OCR-API/top
 * @see  https://github.com/godruoyi/ocr
 *
 * @method array idcard($images, $options = []) 身份证识别
 */
class OCRManager
{
    /**
     * AccessToken Instance
     *
     * @var AccessToken
     */
    protected $accessToken;

    /**
     * OCR API Whether to support url
     *
     * @var boolean
     */
    protected $supportUrl = true;

    const IDCARD = 'https://aip.baidubce.com/rest/2.0/ocr/v1/idcard';

    /**
     * Register AccessToken
     *
     * @param AccessToken $accessToken
     */
    public function __construct(AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * 身份证识别（不支持在线地址）
     *
     * @param  string|\SplFileInfo $images
     * @param  array $options
     *
     *         参数                     是否可选     类型        可选范围/说明
     *         detect_direction          N       boolean      true/false 是否检测图像朝向，默认不检测
     *         id_card_side              Y       string       front、back，front：身份证正面；back：身份证背面
     *         detect_risk               N       boolan       true/false 是否开启身份证风险类型功能，默认false
     *
     * @throws \RuntimeException
     *
     * @return array
     */
    public function idcard($images, array $options = [])
    {
        $this->supportUrl = false;
        return $this->request(self::IDCARD, $this->buildRequestParam($images, $options));
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
        //Baidu OCR不支持多个url或图片，只支持一次识别一张
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
