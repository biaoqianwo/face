# The Face Recognition SDK For BAT.

[![Latest Stable Version](https://poser.pugx.org/biaoqianwo/face/v/stable)](https://packagist.org/packages/biaoqianwo/face)
[![Total Downloads](https://poser.pugx.org/biaoqianwo/face/downloads)](https://packagist.org/packages/biaoqianwo/face)
[![License](https://poser.pugx.org/biaoqianwo/face/license)](https://packagist.org/packages/biaoqianwo/face)

- [百度AI人脸识别](#baidu-face)
    - [人脸比对](#baidu-match)

# Feature

 - 自定义缓存支持；
 - 符合 PSR 标准，可以很方便的与你的框架结合；
 - 命名不那么乱七八糟；
 - 支持目前市面多家服务商(BAT)

# Support

 - [百度AI人脸识别](http://ai.baidu.com/tech/face)
 - [阿里云人脸识别](https://data.aliyun.com/product/face)
 - [腾讯云万象优图](https://cloud.tencent.com/product/FaceRecognition)

# Requirement

 - PHP > 5.6
 - [composer](https://getcomposer.org/)

# Installation

```bash
composer require biaoqianwo/face
```

# Usage

基本使用（以百度人脸识别为例）

```php
use Biaoqianwo\Face\Application;

$app = new Application([
    'app_key' => 'app_key',
    'secret_key' => 'secret_key'
]);

//人脸比对
$result = $app->baidu->match($filePath);
```

**返回结果**

```json
{
    "log_id": 530427582,
    "image_status": "normal",
    "words_result_num": 6,
    "words_result": {
        "住址": {
            "words": "上海市闵行区华漕镇红卫村宗家巷1号"
        },
        "出生": {
            "words": "19870723"
        },
        "姓名": {
            "words": "鹿晗"
        },
        "公民身份号码": {
            "words": "123456789123456132X"
        },
        "性别": {
            "words": "男"
        },
        "民族": {
            "words": "汉"
        }
    }
}
```

# 各平台支持的方法

> 详情请参考官方文档

所有平台支持的方法中，都满足以下结构：

```php
$app->platform->$method($files, $options = [])
```

`$files` 的值可以为

 1. 文件路径（完整）
 2. `SplFileInfo` 对象
 3. `Resource`
 4. 在线图片地址（部分服务商不支持）
 5. Array

 > 注：`options` 的值都是可选的

<a name="baidu-face"></a>
## [百度AI人脸识别](http://ai.baidu.com/tech/face)

目前采用 `AccessToken` 作为 `API` 认证方式，查看[鉴权认证机制](http://ai.baidu.com/docs#/Auth/top)

<a name="baidu-match"></a>
#### 人脸比对

```php
$app->baidu->match($files, [
    'max_face_num' => 1,
    'face_fields'  => 'expression',
]);
```

<a name="aliyun-face"></a>
## [阿里云人脸识别](https://data.aliyun.com/product/face)

目前采用 `APPCODE` 作为 `API` 认证方式，[查看我的APPCODE](https://market.console.aliyun.com/imageconsole/index.htm)

```php
use Biaoqianwo\Face\Application;

$app = new Application([
      'appcode' => '40bc103c7fe6417b87152f6f68bead2f',
    ]
]);
```

> 阿里云人脸识别不支持在线图片地址

<a name="aliyun-match"></a>
#### 人脸比对

```php
$app->aliyun->match($file, [
    'side' => 'face',
]);
```

<a name="tencent-face"></a>
## [腾讯云人脸识别](https://cloud.tencent.com/product/FaceRecognition)

> 可登录 [云API密钥控制台](https://console.cloud.tencent.com/capi)查看你的[个人 API 密钥](https://console.cloud.tencent.com/capi)

```php
use Biaoqianwo\Face\Application;

$app = new Application([
    'app_id' => '1254032478',
    'secret_id' => 'AKIDzODdB1nOELz0T8CEjTEkgKJOob3t2Tso',
    'secret_key' => '6aHHkz236LOYu0nRuBwn5PwT0x3km7EL',
    'bucket' => 'test1'
]);
```

> 腾讯云 人脸识别 暂不支持在线图片地址

<a name="tencent-match"></a>
#### 人脸比对

```php
$app->tencent->match($file, [
    'card_type' => 0,
]);
```
## LICENSE
MIT
