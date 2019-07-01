<?php
namespace Princeh\QiniuUpload;
use Illuminate\Http\Request;
use zgldh\QiniuStorage\QiniuStorage;
use Illuminate\Routing\Controller as BaseController;
class Controller extends BaseController
{
    public function uploadToken()
    {
        $disk = \Storage::disk('qiniu');
        $token = $disk->getDriver()->uploadToken();
        return response()->json([
            'token' => $token
        ]);
    }
}