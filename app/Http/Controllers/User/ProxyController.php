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

    //盐值
    public $solt = 'insensible';

    public function proxyList(Request $request)
    {
        //判断用户token是否存在
        $token = $request->session()->get('user_token');

    }

}