<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\ProUser;
use App\Model\User;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class FindController extends Controller
{

    //盐值
    public $solt = 'insensible';

    //查询代理的信息
     public function findProxyList(Request $request)
     {
         $pageSize = $request->input('page_size',10);
         $where = $request->input('pro_name');
         $proList = ProUser::where('pro_name',$where)->paginate($pageSize,[
             'pro_id',
             'pro_name',
             'pro_surplus',
             'pro_used',
             'pro_pick',
             'pro_time',
             'pro_discount',
             'pro_comment',
             'pro_status']);

         $proCount = ProUser::count();
         $proSurplus = ProUser::sum('pro_surplus');
         $proUsed = ProUser::sum('pro_used');

         $proRes = array(
             'pro_count'=>$proCount,
             'pro_surplus'=>$proSurplus,
             'pro_used'=>$proUsed
         );

         return view('user.find1.admin')->with('proList',$proList)->with('proRes',$proRes);
     }

     //查询提号记录
    public function findPickupList(Request $request)
    {
        $pageSize = $request->input('page_size',10);

        $where = $request->input('pro_name');

        $pickupList = ProUser::leftJoin('fs_game_bank1', 'fs_pro_users.pro_name', '=', 'fs_game_bank1.b_proxy_user')
            ->where('fs_game_bank1.b_status',1)
            ->where('pro_name',$where)
            ->orderBy('fs_game_bank1.b_pickup_time', 'desc')
            ->paginate($pageSize,[
                'fs_game_bank1.b_id',
                'fs_game_bank1.b_proxy_user',
                'fs_pro_users.pro_discount',
                'fs_pro_users.pro_surplus',
                'fs_game_bank1.b_user',
                'fs_game_bank1.b_pickup_time',
                'fs_pro_users.pro_used',
                'fs_pro_users.pro_pick',
                'fs_pro_users.pro_comment'
            ]);
        return view('user.find1.pickup')->with('pickupList',$pickupList);
    }

    //查询充值记录
    public function findRechargeList(Request $request)
    {
        $pageSize = $request->input('page_size',10);
        $proName = $request->input('pro_name');
        $sTime = $request->input('s_time');
        $eTime = $request->input('e_time');
        if(empty($proName) && empty($sTime) && !empty($eTime)){
            echo "<script>alert('时间段查询时,结束日期不能为空')</script>";
            return;
        }
        if(empty($proName) && !empty($sTime) && empty($eTime)){
            echo "<script>alert('时间段查询时,开始日期不能为空')</script>";
            return;
        }
        if(!empty($proName) && empty($sTime) && empty($eTime)){
            $rechargeList = Recharge::where('pro_name',$proName)->paginate($pageSize,[
                'rec_id',
                'pro_name',
                'rec_count',
                'rec_time',
                'rec_com'
            ]);
        }
        if(empty($proName) && !empty($sTime) && !empty($eTime)){
            $rechargeList = Recharge::where('rec_time','>=',$sTime)
                ->where('rec_time','<=',$eTime)
                ->paginate($pageSize,[
                'rec_id',
                'pro_name',
                'rec_count',
                'rec_time',
                'rec_com'
            ]);
        }

        if(!empty($proName) && !empty($sTime) && !empty($eTime)){
            $rechargeList = Recharge::where('pro_name',$proName)
                ->where('rec_time','>=',$sTime)
                ->where('rec_time','<=',$eTime)
                ->paginate($pageSize,[
                    'rec_id',
                    'pro_name',
                    'rec_count',
                    'rec_time',
                    'rec_com'
                ]);
        }
        return view('user.index.reshow')->with('rechargeList',$rechargeList);
    }

}