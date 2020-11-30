<?php


namespace app\admin\controller;


class Specs extends \app\BaseController
{
    public function dialog()
    {
        return view("", [
            "specs" => json_encode(config("specs"))
        ]);
    }

}