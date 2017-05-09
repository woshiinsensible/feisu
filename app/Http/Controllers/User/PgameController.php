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
class PgameController extends Controller
{
    //提取账号
    public function pickShow(Request $request)
    {
        if(!$request->has('no')){
            return json_encode(['error_code'=>113,'msg'=>'没有游戏号传入'],JSON_UNESCAPED_UNICODE);
        }

        $no = $request->input('no');
        $gameStatus = DB::table('fs_status')->where('g_id',$no)->get(['g_sell_status','g_id','g_price_status']);

        //判断游戏是否维护中
        if($gameStatus[0]->g_sell_status == 0){
            echo "<script>alert('游戏维护中·····');history.go(-1)</script>";
            return;
        }

        if(!$request->has('t')){
            return json_encode(['error_code'=>113,'msg'=>'没有表名传入'],JSON_UNESCAPED_UNICODE);
        }

        $page_size = $request->input('page_size',10);

        $tName = $request->input('t');

        //显示可以提取的账号
        $resBank = DB::table($tName)->where('b_used',0)->paginate($page_size);

        return view('user.pgame1.pick')->with('resBank',$resBank);

    }

    //跳转执行提货动作
    public function pickup(Request $request)
    {
        if(!$request->has('t')){
            return json_encode(['error_code'=>113,'msg'=>'没有表名传入'],JSON_UNESCAPED_UNICODE);
        }

        $tName = $request->input('t');

        if(!$request->has('b_id')){
            return json_encode(['error_code'=>113,'msg'=>'没有b_id传入'],JSON_UNESCAPED_UNICODE);
        }

        $bId = $request->input('b_id');

        //获取用户的折扣信息
        $userName = $request->session()->get('user_name');

        if (!$userName){
            return json_encode(['error_code'=>222,'msg'=>'非法用户'],JSON_UNESCAPED_UNICODE);
        }

        $resDiscount = ProUser::where('pro_name',$userName)->get(['pro_discount']);

        $discount = $resDiscount->toArray()[0]['pro_discount'];

        //获取购买的账号信息
        $resBank = DB::table($tName)->where('b_id',$bId)->get([
            'b_id',
            'b_no',
            'b_zone',
            'b_group',
            'b_com',
            'b_price'
        ]);

        //对象转数组
        $bankArray =  json_decode( json_encode($resBank[0]),true);

        $t_price = $discount * $bankArray['b_price'];
        $bankArray['pro_discount'] = $discount;
        $bankArray['t_price'] = $t_price;

        return view('user.pgame1.spick')->with('bankArray',$bankArray);

    }

    //确认购买账号
    public function buy(Request $request)
    {
        if(!$request->has('b_id')){
            return json_encode(['error_code'=>113,'msg'=>'没有b_id传入'],JSON_UNESCAPED_UNICODE);
        }

        $bId = $request->input('b_id');

        if(!$request->has('b_used')){
            return json_encode(['error_code'=>113,'msg'=>'没有b_used传入'],JSON_UNESCAPED_UNICODE);
        }

        $bUsed = $request->input('b_used');
        $bUsed = trim($bUsed);

        $userName = $request->session()->get('user_name');

        $pTime = date("Y-m-d H:i:s",time());

        //先判断用户剩余的点数是否足够购买此账号
        $resSurplus  = ProUser::where('pro_name',$userName)->get(['pro_surplus','pro_used','pro_pick']);

        if(!$resSurplus->isEmpty()){
            $surplusArray = $resSurplus->toArray();
        }

        //用户剩余的点数
        $surplus = $surplusArray[0]['pro_surplus'];

        if($surplus < $bUsed){
            return json_encode(['error_code'=>113,'msg'=>'用户点数:'.$surplus.',购买此账号所需点数:'.$bUsed.'!点数不足请充值！'],JSON_UNESCAPED_UNICODE);
        }

        $used = $surplusArray[0]['pro_used'];
        $pick = $surplusArray[0]['pro_pick'];

        //该加的加，该减的减
        //扣除用户的剩余点数
        $surplus = $surplus - $bUsed;
        $used = $used + $bUsed;
        //用户的提货数量加一
        $pick++;



        //更新bank中的数据
        $res = DB::table('fs_game_bank1')->where('b_id',$bId)->update([
            'b_pickup_time'=>$pTime,
            'b_used'=>$bUsed,
            'b_proxy_user'=>$userName,
            'b_status'=>1
        ]);



        if(!$res){
            return json_encode(['error_code'=>222,'msg'=>'购买账号失败'],JSON_UNESCAPED_UNICODE);
        }

        //pro_user跟新对应的数据
        $res1 = ProUser::where('pro_name',$userName)->update([
            'pro_surplus'=>$surplus,
            'pro_used'=>$used,
            'pro_pick'=>$pick
        ]);


        if(!$res1){
            return json_encode(['error_code'=>222,'msg'=>'购买账号失败'],JSON_UNESCAPED_UNICODE);
        }

    }

    //提货记录
    public function pickRecode(Request $request)
    {
        $userName = $request->session()->get('user_name');

        if (!$userName){
            return json_encode(['error_code'=>222,'msg'=>'非法用户'],JSON_UNESCAPED_UNICODE);
        }

        if(!$request->has('t')){
            return json_encode(['error_code'=>113,'msg'=>'没有表名传入'],JSON_UNESCAPED_UNICODE);
        }

        $page_size = $request->input('page_size',10);

        $tName = $request->input('t');

        $resBank = DB::table($tName)->where('b_user',$userName)->paginate($page_size);

        return view('user.pgame1.recode')->with('resBank',$resBank);
    }
}