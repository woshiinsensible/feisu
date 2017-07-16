<?php
namespace App\Http\Controllers\Other;

use App\Http\Controllers\Controller;
use App\Model\Notice;
use App\Model\Pickup;
use App\Model\ProUser;
use App\Model\Recharge;
use App\Model\Recode;
use App\Model\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use BrowserDetect;
class WangController extends Controller
{
    //test
    public function wang_test()
    {
        echo "<script>alert('ss');history.go(-1)</script>";
    }
    //保存用户信息
    public function wang_cookie(Request $request)
    {



//        $regCode = $request->input('zhanqu');

        $account = $request->input('zhanghao');

        $password = $request->input('mima');

        $device = $request->input('chongzhima');


        $response = new Response('cookie');

//        $response->withCookie(\cookie('sel1',$regCode,21600));
        $response->withCookie(\cookie('t1',$account,21600));
        $response->withCookie(\cookie('t2',$password,21600));
        $response->withCookie(\cookie('t3',$device,21600));
        return $response;
    }

    /*--充值--*/

    public function wang_recharge_do(Request $request)
    {
        set_time_limit(60);

        $qian=array(" ","　","\t","\n","\r");
        $hou=array("","","","","");

        if (!$request->has('zhanqu') || $request->input('zhanqu')=== '0') {
            return json_encode(['error_code' => 111, 'msg' => '战区不能为空'], JSON_UNESCAPED_UNICODE);
        }

        if (!$request->has('zhanghao')) {
            return json_encode(['error_code' => 111, 'msg' => '账号不能为空'], JSON_UNESCAPED_UNICODE);
        }

        if (!$request->has('mima')) {
            return json_encode(['error_code' => 111, 'msg' => '密码不能为空'], JSON_UNESCAPED_UNICODE);
        }

        if (!$request->has('chongzhima')) {
            return json_encode(['error_code' => 111, 'msg' => '充值码不能为空'], JSON_UNESCAPED_UNICODE);
        }


        if(!preg_match("/^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i",$request->input('chongzhima'))){
            return json_encode(['error_code' => 111, 'msg' => '充值码只能是英文和数字'], JSON_UNESCAPED_UNICODE);
        }


        if(strlen($request->input('chongzhima')) != 16){
            return json_encode(['error_code' => 111, 'msg' => '充值码位数不正确'], JSON_UNESCAPED_UNICODE);
        }

        $zhanqu = str_replace($qian,$hou,$request->input('zhanqu'));
        $zhanghao = str_replace($qian,$hou,$request->input('zhanghao'));
        $mima = str_replace($qian,$hou,$request->input('mima'));
        $chongzhima = str_replace($qian,$hou,$request->input('chongzhima'));

        $parm = $zhanqu.$zhanghao;

        $res = file('http://222.185.25.254:8088/jsp1/getyouxi2.jsp?name='.$parm)[0];

        $res1 = str_replace($qian,$hou,$res);

//        $r = explode('/',explode(',',$res1)[3])[0];
//
//        dd($r);



        switch ($zhanqu)
        {
            case 'AZVX-':
                $zq = '安卓微信';
                break;
            case 'AZQQ-':
                $zq = '安卓QQ';
                break;
            case 'IOSVX-':
                $zq = '苹果微信';
                break;
            case 'IOSQQ-':
                $zq = '苹果QQ';
                break;
        }

        if(empty($res1)){
            $resArray = [
                '游戏战区:'.$zq,
                '游戏账号:'.$zhanghao,
                '游戏密码:'.$mima,
                '新号尚未代挂过，如果有误，请再次获取！',
            ];
            return json_encode(['error_code' => 123, 'msg' => $resArray], JSON_UNESCAPED_UNICODE);
        }else{
            $r = explode('/',explode(',',$res1)[3])[0];
            $resArray = [

                '游戏战区:'.$zq,
                '游戏账号:'.$zhanghao,
                '游戏密码:'.$mima,
                '剩余点数:'.$r
                ];

            return json_encode(['error_code' => 123, 'msg' => $resArray], JSON_UNESCAPED_UNICODE);
        }

    }

    public function wang_recharge_submit(Request $request)
    {
        set_time_limit(60);

        $qian=array(" ","　","\t","\n","\r");
        $hou=array("","","","","");

//        dd($request->input('zhanqu') === '0');

        if (!$request->has('zhanqu') || $request->input('zhanqu')=== '0') {
            return json_encode(['error_code' => 111, 'msg' => '战区不能为空'], JSON_UNESCAPED_UNICODE);
        }

        if (!$request->has('shuatu') || $request->input('shuatu')=== '0') {
            return json_encode(['error_code' => 111, 'msg' => '刷图不能为空'], JSON_UNESCAPED_UNICODE);
        }

        if (!$request->has('zhanghao')) {
            return json_encode(['error_code' => 111, 'msg' => '账号不能为空'], JSON_UNESCAPED_UNICODE);
        }

        if (!$request->has('mima')) {
            return json_encode(['error_code' => 111, 'msg' => '密码不能为空'], JSON_UNESCAPED_UNICODE);
        }

        if (!$request->has('chongzhima')) {
            return json_encode(['error_code' => 111, 'msg' => '充值码不能为空'], JSON_UNESCAPED_UNICODE);
        }


        if(!preg_match("/^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i",$request->input('chongzhima'))){
            return json_encode(['error_code' => 111, 'msg' => '充值码只能是英文和数字'], JSON_UNESCAPED_UNICODE);
        }


        if(strlen($request->input('chongzhima')) != 16){
            return json_encode(['error_code' => 111, 'msg' => '充值码位数不正确'], JSON_UNESCAPED_UNICODE);
        }

        $zhanqu = str_replace($qian,$hou,$request->input('zhanqu'));
        $shuatu = str_replace($qian,$hou,$request->input('shuatu'));
        $zhanghao = str_replace($qian,$hou,$request->input('zhanghao'));
        $mima = str_replace($qian,$hou,$request->input('mima'));
        $chongzhima = str_replace($qian,$hou,$request->input('chongzhima'));

        $parm = $zhanqu.$zhanghao;

        $res = file('http://222.185.25.254:8088/jsp1/getyouxi2.jsp?name='.$parm)[0];

        $res1 = str_replace($qian,$hou,$res);

//        $r = explode('/',explode(',',$res1)[3])[0];
//
//        dd($r);

        switch ($zhanqu)
        {
            case 'AZVX-':
                $zq = '安卓微信';
                break;
            case 'AZQQ-':
                $zq = '安卓QQ';
                break;
            case 'IOSVX-':
                $zq = '苹果微信';
                break;
            case 'IOSQQ-':
                $zq = '苹果QQ';
                break;
        }

        if(empty($res1)){
            return json_encode(['error_code' => 111, 'msg' => '新号尚未代挂过，如果有误，请再次获取！'], JSON_UNESCAPED_UNICODE);
        }

        switch ($zhanqu)
        {
            case 'AZVX-':
                $zq = '安卓微信';
                break;
            case 'AZQQ-':
                $zq = '安卓QQ';
                break;
            case 'IOSVX-':
                $zq = '苹果微信';
                break;
            case 'IOSQQ-':
                $zq = '苹果QQ';
                break;
        }

        $rr = explode(',',$res1);

//        dd($rr);

        if(empty($res1)){
            $r= 0;
        }else{
            $r = explode('/',$rr[3])[0];

        }

        //华丽的分割线


        $res = file_get_contents('http://feifeifuzhu.com/feifei/index.php/Admin/getCode/zhucema/'.$chongzhima.'/youxi/WZRY');

        if($res == ' error'){
            return json_encode(['error_code' => 111, 'msg' => '该卡错误！请核对后再充值！'], JSON_UNESCAPED_UNICODE);
        }

        $res2 = explode(',',$res)[5];

        if($res2 === '0'){
            return json_encode(['error_code' => 111, 'msg' => '该卡已经充值过了'], JSON_UNESCAPED_UNICODE);
        }

        $resArray = [
            '游戏战区:'.$zq,
            '游戏账号:'.$zhanghao,
            '游戏密码:'.$mima,
            '当前剩余点数:'.$r,
            '充值卡面值:'.$res2,
            '是否确认充值?',
            $shuatu,
            $rr[2],
            explode('/',$rr[3])[1],
            $chongzhima,
            $zhanqu,
            $zhanghao,
            $mima,
            $r,
            $res2
        ];
        return json_encode(['error_code' => 123, 'msg' => $resArray], JSON_UNESCAPED_UNICODE);

//        dd($res2);

    }

    public function wang_yes(Request $request)
    {
        $zhanqu = $request->input('zhanqu');
        $zhanghao = $request->input('zhanghao');
        $mima = $request->input('mima');
        $chongzhima = $request->input('chongzhima');
        $jihaoji = $request->input('jihaoji');
        $shuatu = $request->input('shuatu');
        $zong = $request->input('zong');
        $sheng = $request->input('sheng');
        $time = time();

//        $r = $zhanqu.$zhanghao;
//        dd('http://222.185.25.254:8088/jsp1/inputyouxi2-1.jsp?name='.$r.'&pwe='.$mima.'&wheree='.$jihaoji.'&beizhu1='.$zong.'/'.$sheng.'&beizhu2='.$shuatu.'');

//        dd('http://feifeifuzhu.com/feifei/index.php/Admin/uploadNumber/bh1/'.$zhanqu.'/bh2/'.$zhanghao.'/bh3/'.$mima.'/bh4/'.$time.'/youxi/WZRY/shuliang/0/zhucema/'.$chongzhima.'/leixing/dk/daoqishijian/-2');

        $res = file_get_contents('http://feifeifuzhu.com/feifei/index.php/Admin/uploadNumber/bh1/'.$zhanqu.'/bh2/'.$zhanghao.'/bh3/'.$mima.'/bh4/'.$time.'/youxi/WZRY/shuliang/0/zhucema/'.$chongzhima.'/leixing/dk/daoqishijian/-2');

        //http://222.185.25.254:8088/jsp1/inputyouxi2-1.jsp?name=AZQQ-972102275&pwe=zhuyunfei1224&wheree=JAY-1009&beizhu1=1000/200&beizhu2=3

        $r = $zhanqu.$zhanghao;
        $res2 = file('http://222.185.25.254:8088/jsp1/inputyouxi2-1.jsp?name='.$r.'&pwe='.$mima.'&wheree='.$jihaoji.'&beizhu1='.$zong.'/'.$sheng.'&beizhu2='.$shuatu.'');

//        dd($res2);
        if($res == ' success'){
            echo "<script>alert('充值成功');history.go(-1)</script>";
        }

    }

    /*--代挂--*/


}