<?php
//开启严格模式
declare(strict_types=1);
namespace app\common\lib\sms;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use think\facade\Log;

class AliSms
{
    /**
     * 阿里云短信验证码发送场景
     * @param string $phone
     * @param int $code
     * @return bool
     * @throws ClientException
     */
    public static function sendCode(string $phone, int $code): bool
    {
        //如果为空
        if (!$phone || !$code) {
            return false;
        }
        AlibabaCloud::accessKeyClient(config('aliyun.access_key'), config('aliyun.access_secret'))
            ->regionId(config('aliyun.region_id'))
            ->asDefaultClient();
        //验证码格式
        $templateParam = [
            'code' => $code
        ];
        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host(config('aliyun.host'))
                ->options([
                    'query' => [
                        'RegionId' => config('aliyun.region_id'),
                        'PhoneNumbers' => $phone,
                        'SignName' => config('aliyun.sign_name'),//短信签名
                        'TemplateCode' => config('aliyun.template_code'),//短信模板
                        'TemplateParam' => json_encode($templateParam),//参数
                    ],
                ])
                ->request();
            //写日志
            Log::info('alisms-sendcode-'.$phone.'-result'.json_encode($result->toArray()));
        } catch (ClientException $e) {
            Log::error('alisms-sendcode-'.$phone.'-ClientException'.$e->getMessage());
            return false;
        } catch (ServerException $e) {
            Log::error('alisms-sendcode-'.$phone.'-ServerException'.$e->getMessage());
            return false;
        }
        return true;
    }
}