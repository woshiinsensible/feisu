<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\Notice;
use App\Model\ProUser;
use App\Model\Recharge;
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
            return json_encode(['error_code'=>222,'msg'=>'时间已过期，请重新登录'],JSON_UNESCAPED_UNICODE);
        }


        //判断用户是否被禁用,并获取代理用户的相关数据
        $resStatus = ProUser::where('pro_id',$puserId)->get(['pro_status','pro_discount','pro_surplus','pro_used']);
        if(!$resStatus->isEmpty()){
            if($resStatus->toArray()[0]['pro_status'] == 0){
                echo "<script>alert('代理账号已被冻结，请练习管理员');history.go(-1)</script>";
                return;
            }
        }

        //获取公告信息
        $resNotice = Notice::get(['no_id','no_title','no_time']);
        return view('user.proxy.proxy')
            ->with('resStatus',$resStatus)
            ->with('resNotice',$resNotice);

    }

    //代理用户查看一条公告showNotice
    public function showNotice(Request $request)
    {
        if(!$request->has('no_id')){
            return json_encode(['error_code'=>113,'msg'=>'没有公告id传入'],JSON_UNESCAPED_UNICODE);
        }

        $noId = $request->input('no_id');

        $noCom = Notice::where('no_id',$noId)->first(['no_title','no_time','no_com']);
        if(!empty($noCom)){
            $resNo = $noCom->toArray();
        }

        return view('user.proxy.snotice')
            ->with('data',$resNo);
    }

    //获取代理用户充值记录
    public function rechargeRecode(Request $request)
    {
        if (!$request->session()->has('user_name')) {
            return json_encode(['error_code'=>113,'msg'=>'用户不存在'],JSON_UNESCAPED_UNICODE);
        }

        $proName = $request->session()->get('user_name');

        $res = Recharge::where('pro_name',$proName)->get([
            'rec_id',
            'rec_count',
            'rec_time',
            'rec_com'
        ]);

        $resArray = array();

        if(!$res->isEmpty()){
            $resArray = $res->toArray();
        }

        return view('user.proxy.recharge')
            ->with('resArray',$resArray);

    }

}