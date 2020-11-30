<?php

namespace app\admin\controller;

use app\BaseController;
use think\facade\Filesystem;
use think\Request;

class Image extends BaseController
{
    /**
     * 图片上传
     * @param Request $request
     * @return \think\response\Json
     */
    public function upload(Request $request)
    {
        if (!$request->isPost()) {
            return showJson('error', '请求方式错误');
        }
        $file = $request->file('file');
        //  TODO:1、上传图片类型需要判断png gif jpg 2、文件大小限制600kb,
        //设置保存路径 (可以在配置文件中配置filesystem.php)
        $filename = Filesystem::disk('public')->putFile('image/upload', $file);
        if (!$filename) {
            return showJson('error', '图片上传失败');
        }
        $data = [
            'image' => '/storage/' . $filename
        ];
        return showJson('success', '图片上传成功', $data);
    }

    /**
     * layUI图片上传格式
     * @return \think\response\Json
     */
    public function layUpload()
    {
        if (!$this->request->isPost()) {
            return showJson('error', "请求不合法");
        }
        $file = $this->request->file("file");
        $filename = \think\facade\Filesystem::disk('public')->putFile("image/upload", $file);
        if (!$filename) {
            return json(["code" => 1, "data" => []], 200);
        }

        $result = [
            "code" => 0,
            "data" => [
                "src" => "/storage/" . $filename,
            ],
        ];
        return json($result, 200);

    }

}