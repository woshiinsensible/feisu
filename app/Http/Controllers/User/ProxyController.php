<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\ProUser;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class ProxyController extends Controller
{

    public function proxyIndex(Request $request)
    {
        //中间件已经判断是否存在user_token
        $res = $request->session()->get('user_token');
        $puserId = explode('-',base64_decode($res))[0];
        if (!is_numeric($puserId)){
            return json_encode(['error_code'=>222,'msg'=>'非法用户'],JSON_UNESCAPED_UNICODE);
        }

    }

}