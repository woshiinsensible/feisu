<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\Notice;
use App\Model\Pickup;
use App\Model\ProUser;
use App\Model\Recharge;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class AdminController extends Controller
{
    //显示代理的信息
    public function proxyList(Request $request)
    {
        $pageSize = $request->input('page_size',10);
        $proList = ProUser::paginate($pageSize,[
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

        return view('user.index.admin')->with('proList',$proList)->with('proRes',$proRes);
    }

    //显示充值信息
    public function rechargeList(Request $request)
    {
        $pageSize = $request->input('page_size',10);
        $rechargeList = Recharge::paginate($pageSize,[
            'rec_id',
            'pro_name',
            'rec_count',
            'rec_time',
            'rec_com'
        ]);
        return view('user.index.reshow')->with('rechargeList',$rechargeList);
    }

    //跳转修改密码页面，并携带参数
    public function showPwd(Request $request)
    {
        $pro_id = $request->input('pro_id','');
        $pro_name = $request->input('pro_name','');
        $data = array(
            'pro_id' => $pro_id,
            'pro_name' => $pro_name
        );
        return view('user.index.cpwd')->with('data',$data);
    }

    //修改密码
    public function changePwd(Request $request)
    {
        if(!$request->has('pro_id')){
            return json_encode(['error_code'=>113,'msg'=>'没有pro_id传入'],JSON_UNESCAPED_UNICODE);
//            echo "<script>alert('没有pro_id传入')</script>";
//            return view('user.cpwd')->with('data',$data);
        }

        $proId = $request->input('pro_id');

        if(!$request->has('new_pwd')){
            return json_encode(['error_code'=>113,'msg'=>'没有new_pwd传入'],JSON_UNESCAPED_UNICODE);
//            echo "<script>alert('没有new_pwd传入')</script>";
//            return view('user.cpwd')->with('data',$data);
        }
        $newPassword = $request->input('new_pwd');
        $userLen = mb_strlen($newPassword);
        if($userLen<6 || $userLen>12){
            return json_encode(['error_code'=>222,'msg'=>'密码在6-12位之间'],JSON_UNESCAPED_UNICODE);
//            echo "<script>alert('密码在6-12位之间')</script>";
//            return view('user.cpwd')->with('data',$data);
        }

        $password = md5($newPassword);
        $res = ProUser::where('pro_id',$proId)->update(['pro_pwd' => $password]);

        if(!$res){
//            echo "<script>alert('修改密码失败')</script>";
//            return view('user.cpwd')->with('data',$data);
            return json_encode(['error_code'=>222,'msg'=>'修改密码失败'],JSON_UNESCAPED_UNICODE);
        }

//        return redirect('/proxyList?page='.$page);
        return json_encode(['error_code'=>0,'msg'=>''],JSON_UNESCAPED_UNICODE);

    }

    //跳转修改备注页面，并携带参数
    public function showCom(Request $request)
    {
        $pro_id = $request->input('pro_id','');
        $pro_name = $request->input('pro_name','');
        $data = array(
            'pro_id' => $pro_id,
            'pro_name' => $pro_name
        );
        return view('user.index.ccom')->with('data',$data);
    }

    //修改备注
    public function changeCom(Request $request)
    {

        if(!$request->has('pro_id')){
            return json_encode(['error_code'=>113,'msg'=>'没有pro_id传入'],JSON_UNESCAPED_UNICODE);
        }

        $proId = $request->input('pro_id');

        if(!$request->has('new_com')){
            return json_encode(['error_code'=>113,'msg'=>'没有new_com传入'],JSON_UNESCAPED_UNICODE);
        }

        $proCom = $request->input('new_com');

        $res = ProUser::where('pro_id',$proId)->update(['pro_comment' => $proCom]);

        if(!$res){
            return json_encode(['error_code'=>113,'msg'=>'修改备注失败'],JSON_UNESCAPED_UNICODE);
        }

        return json_encode(['error_code'=>0,'msg'=>''],JSON_UNESCAPED_UNICODE);
    }

    //修改状态
    public function changeSta(Request $request)
    {
        if(!$request->has('pro_id')){
            return json_encode(['error_code'=>222,'msg'=>'没有pro_id传入'],JSON_UNESCAPED_UNICODE);
        }

        $proId = $request->input('pro_id');

        $res = ProUser::where('pro_id',$proId)->get(['pro_status']);

        if(!$res->isEmpty()){
            $resSta = $res->toArray()[0]["pro_status"];
        }

        if($resSta == 1){
            $res1 = ProUser::where('pro_id',$proId)->update(['pro_status' => 0]);

            if(!$res1){
                return json_encode(['error_code'=>222,'msg'=>'修改状态失败'],JSON_UNESCAPED_UNICODE);
            }
        }elseif($resSta == 0){
            $res1 = ProUser::where('pro_id',$proId)->update(['pro_status' => 1]);

            if(!$res1) {
                return json_encode(['error_code'=>222,'msg'=>'修改状态失败'],JSON_UNESCAPED_UNICODE);
            }
        }

        return json_encode(['error_code'=>0,'msg'=>''],JSON_UNESCAPED_UNICODE);

    }

    //跳转修改备注页面，并携带参数
    public function recShow(Request $request)
    {
        $pro_id = $request->input('pro_id','');
        $pro_name = $request->input('pro_name','');
        $pro_discount = $request->input('pro_discount','');
        $pro_surplus = $request->input('pro_surplus','');
        $data = array(
            'pro_id' => $pro_id,
            'pro_name' => $pro_name,
            'pro_discount'=>$pro_discount,
            'pro_surplus'=>$pro_surplus
        );
        return view('user.index.recharge')->with('data',$data);
    }

    //充值
    public function recharge(Request $request)
    {
        if(!$request->has('pro_id')){
            return json_encode(['error_code'=>222,'msg'=>'没有pro_id传入'],JSON_UNESCAPED_UNICODE);
        }
        $proId = $request->input('pro_id');

        if(!$request->has('pro_name')){
            return json_encode(['error_code'=>222,'msg'=>'没有pro_name传入'],JSON_UNESCAPED_UNICODE);
        }
        $proName = $request->input('pro_name');


        if(!$request->has('rec_count')){
            return json_encode(['error_code'=>222,'msg'=>'请输入充值点数'],JSON_UNESCAPED_UNICODE);
        }

        $recCount = $request->input('rec_count');
        $recCom = $request->input('rec_com','');
        $recTime = date('Y-m-d H:i:s',time());


        $insRes = Recharge::insert([
            'pro_id'=>$proId,
            'pro_name'=>$proName,
            'rec_count'=>$recCount,
            'rec_time'=>$recTime,
            'rec_com'=>$recCom
        ]);
        if(!$insRes){
            return json_encode(['error_code'=>222,'msg'=>'充值失败'],JSON_UNESCAPED_UNICODE);
        }

        if(!$request->has('pro_surplus')){
            return json_encode(['error_code'=>222,'msg'=>'没有pro_surplus传入'],JSON_UNESCAPED_UNICODE);
        }
        $proTotal = $request->input('pro_surplus');

        $resTotal = $proTotal+$recCount;

        $upPro = ProUser::where('pro_id',$proId)->update(['pro_surplus'=>$resTotal]);

        if(!$upPro){
            return json_encode(['error_code'=>222,'msg'=>'加入到pro_user表失败'],JSON_UNESCAPED_UNICODE);
        }

        return json_encode(['error_code'=>0,'msg'=>''],JSON_UNESCAPED_UNICODE);

    }

    //修改折扣
    public function changeDis(Request $request)
    {
        if(!$request->has('pro_id')){
            return json_encode(['error_code'=>222,'msg'=>'没有pro_id传入'],JSON_UNESCAPED_UNICODE);
        }
        $proId = $request->input('pro_id');

        if(!$request->has('pro_discount')){
            return json_encode(['error_code'=>222,'msg'=>'字段pro_discount不存在'],JSON_UNESCAPED_UNICODE);
        }

        $proDiscount = $request->input('pro_discount',0.5);

        $disRes = ProUser::where('pro_id',$proId)->update(['pro_discount'=>$proDiscount]);

        if(!$disRes){
            return json_encode(['error_code'=>222,'msg'=>'修改折扣失败'],JSON_UNESCAPED_UNICODE);
        }

        return json_encode(['error_code'=>0,'msg'=>''],JSON_UNESCAPED_UNICODE);
    }

    //显示提号信息
    public function pickupList(Request $request)
    {
        $pageSize = $request->input('page_size',10);

        $pickupList = ProUser::leftJoin('fs_game_bank1', 'fs_pro_users.pro_name', '=', 'fs_game_bank1.b_proxy_user')
            ->where('fs_game_bank1.b_status',1)
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
        return view('user.index.pickup')->with('pickupList',$pickupList);
    }

    //查看公告跳转页面
    public function noticeShow(Request $request)
    {
        $no_id = $request->input('no_id','');
        $data = Notice::where('no_id',$no_id)->get([
            'no_title',
            'no_time',
            'no_com'
        ]);
        if(!$data){
            return json_encode(['error_code'=>222,'msg'=>'内容不存在'],JSON_UNESCAPED_UNICODE);
        }
        return view('user.index.snotice')->with('data',$data);
    }

    //显示历史公告
    public function noticeList(Request $request)
    {
        $pageSize = $request->input('page_size',10);

        $noticeList = Notice::orderBy('no_up')->orderBy('no_time','desc')->paginate($pageSize,[
            'no_id',
            'no_title',
            'no_time',
            'no_up'
        ]);

        return view('user.index.notice')->with('noticeList',$noticeList);
    }

    //发布公告
    public function pubNotice(Request $request)
    {
        if(!$request->has('no_title')){
            return json_encode(['error_code'=>222,'msg'=>'请输入公告标题'],JSON_UNESCAPED_UNICODE);
        }
        $noTitle = $request->input('no_title');

        if(!$request->has('no_com')){
            return json_encode(['error_code'=>222,'msg'=>'请输入公告内容'],JSON_UNESCAPED_UNICODE);
        }
        $noCom = $request->input('no_com');

        $noUp = $request->input('no_up',0);


        if(!$request->has('no_time')){
            return json_encode(['error_code'=>222,'msg'=>'没有时间传入'],JSON_UNESCAPED_UNICODE);
        }
        $noTime = $request->input('no_time');

        $noRes = Notice::insert([
            'no_title'=>$noTitle,
            'no_com'=>$noCom,
            'no_up'=>$noUp,
            'no_time'=>$noTime
        ]);

        if(!$noRes){
            return json_encode(['error_code'=>222,'msg'=>'发布公告失败'],JSON_UNESCAPED_UNICODE);
        }

        return json_encode(['error_code'=>0,'msg'=>''],JSON_UNESCAPED_UNICODE);
    }

    //删除公告
    public function delNotice(Request $request)
    {
        if(!$request->has('no_id')){
            return json_encode(['error_code'=>222,'msg'=>'没有no_id传入'],JSON_UNESCAPED_UNICODE);
        }
        $noId = $request->input('no_id');

        $delRes = Notice::where('no_id',$noId)->delete();
        if(!$delRes){
            return json_encode(['error_code'=>222,'msg'=>'删除公告失败'],JSON_UNESCAPED_UNICODE);
        }

        return json_encode(['error_code'=>0,'msg'=>''],JSON_UNESCAPED_UNICODE);
    }

    //跳转修改页面
    public function noticeModShow(Request $request)
    {
        $no_id = $request->input('no_id','');
        $data = Notice::where('no_id',$no_id)->get([
            'no_id',
            'no_title',
            'no_time',
            'no_com'
        ]);
        if(!$data){
            return json_encode(['error_code'=>222,'msg'=>'修改的内容不存在'],JSON_UNESCAPED_UNICODE);
        }
        return view('user.index.mnotice')->with('data',$data);
    }

    //修改公告
    public function modNotice(Request $request)
    {
        if(!$request->has('no_id')){
            return json_encode(['error_code'=>222,'msg'=>'没有no_id传入'],JSON_UNESCAPED_UNICODE);
        }
        $noId = $request->input('no_id');

        if(!$request->has('no_title')){
            return json_encode(['error_code'=>222,'msg'=>'请输入公告标题'],JSON_UNESCAPED_UNICODE);
        }
        $noTitle = $request->input('no_title');

        if(!$request->has('no_com')){
            return json_encode(['error_code'=>222,'msg'=>'请输入公告内容'],JSON_UNESCAPED_UNICODE);
        }
        $noCom = $request->input('no_com');

        $noUp = $request->input('no_up',0);

        if(!$request->has('no_time')){
            return json_encode(['error_code'=>222,'msg'=>'没有时间传入'],JSON_UNESCAPED_UNICODE);
        }
        $noTime = $request->input('no_time');

        $modRes = Notice::where('no_id',$noId)->update([
            'no_title'=>$noTitle,
            'no_com'=>$noCom,
            'no_up'=>$noUp,
            'no_time'=>$noTime
        ]);

        if(!$modRes){
            return json_encode(['error_code'=>222,'msg'=>'修改公告失败'],JSON_UNESCAPED_UNICODE);
        }

        return json_encode(['error_code'=>0,'msg'=>''],JSON_UNESCAPED_UNICODE);


    }


}