<?php
return [
    'host' => 'dysmsapi.aliyuncs.com',//服务器地址
    'access_key' => env('aliyun.access_key'),//accessKeyId
    'access_secret' => env('aliyun.access_secret'),//accessSecret
    'region_id' => 'cn-hangzhou',//区域地址
    'sign_name' => 'ABCD商城',//短信签名
    'template_code' => 'SMS_205816136',//短信模板
];