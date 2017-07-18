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

    public function wang_dai_stop(Request $request)
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

        if (!$request->has('shuatu') || $request->input('shuatu')=== '0') {
            return json_encode(['error_code' => 111, 'msg' => '刷图选择不能为空'], JSON_UNESCAPED_UNICODE);
        }

        if (!$request->has('cishu')) {
            return json_encode(['error_code' => 111, 'msg' => '次数不能为空'], JSON_UNESCAPED_UNICODE);
        }

        if (!$request->has('shanghao')) {
            return json_encode(['error_code' => 111, 'msg' => '上号不能为空'], JSON_UNESCAPED_UNICODE);
        }

        $zhanqu = str_replace($qian,$hou,$request->input('zhanqu'));
        $zhanghao = str_replace($qian,$hou,$request->input('zhanghao'));
        $mima = str_replace($qian,$hou,$request->input('mima'));
        $shuatu = str_replace($qian,$hou,$request->input('shuatu'));
        $cishu = str_replace($qian,$hou,$request->input('cishu'));
        $shanghao = str_replace($qian,$hou,$request->input('shanghao'));

        $parm = $zhanqu.$zhanghao;

        //http://222.185.25.254:8088/jsp1/getyouxi2.jsp?name=AZQQ-972102275

        $res = file('http://222.185.25.254:8088/jsp1/getyouxi2.jsp?name='.$parm)[0];

//        $res = file('http://222.185.25.254:8088/jsp1/getyouxi2.jsp?name=AZQQ-972102275')[0];

        $res1 = str_replace($qian,$hou,$res);

        if(empty($res1)){
            return json_encode(['error_code' => 111, 'msg' => '账号错误！'], JSON_UNESCAPED_UNICODE);
        }

        $res2 = explode(',',$res1);

        $rz = explode('/',$res2[3])[0];

        if($res2[2] === '0'){
            return json_encode(['error_code' => 111, 'msg' => '您的账号，并没有挂机！'], JSON_UNESCAPED_UNICODE);
        }else{
            file_put_contents('http://222.185.25.254:8088/jsp1/inputyouxi2-1.jsp?name='.$res2[0].'&pwe='.$res2[1].'&wheree=0&beizhu1='.$rz.'/0&beizhu2=0');
            return json_encode(['error_code' => 111, 'msg' => '停挂成功，请5分钟之后再登陆游戏'], JSON_UNESCAPED_UNICODE);

        }

    }

    public function wang_dai_start(Request $request)
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

        if (!$request->has('shuatu') || $request->input('shuatu')=== '0') {
            return json_encode(['error_code' => 111, 'msg' => '刷图选择不能为空'], JSON_UNESCAPED_UNICODE);
        }

        if (!$request->has('cishu')) {
            return json_encode(['error_code' => 111, 'msg' => '次数不能为空'], JSON_UNESCAPED_UNICODE);
        }

        if (!$request->has('shanghao')) {
            return json_encode(['error_code' => 111, 'msg' => '上号不能为空'], JSON_UNESCAPED_UNICODE);
        }

        $zhanqu = str_replace($qian,$hou,$request->input('zhanqu'));
        $zhanghao = str_replace($qian,$hou,$request->input('zhanghao'));
        $mima = str_replace($qian,$hou,$request->input('mima'));
        $shuatu = str_replace($qian,$hou,$request->input('shuatu'));
        $cishu = str_replace($qian,$hou,$request->input('cishu'));
        $shanghao = str_replace($qian,$hou,$request->input('shanghao'));

        $parm = $zhanqu.$zhanghao;

        $res = file('http://222.185.25.254:8088/jsp1/getyouxi2.jsp?name='.$parm)[0];

//        $res = file('http://222.185.25.254:8088/jsp1/getyouxi2.jsp?name=AZQQ-972102275')[0];



        $res1 = str_replace($qian,$hou,$res);

//        dd($res1);

        if(empty($res1)){
            return json_encode(['error_code' => 111, 'msg' => '账号错误！'], JSON_UNESCAPED_UNICODE);
        }

        $res2 = explode(',',$res1);

        $rz = explode('/',$res2[3])[0];

        switch ($zhanqu)
        {
            case 'AZVX-':
                $zq2 = '安卓微信';
                break;
            case 'AZQQ-':
                $zq2 = '安卓QQ';
                break;
            case 'IOSVX-':
                $zq2 = '苹果微信';
                break;
            case 'IOSQQ-':
                $zq2 = '苹果QQ';
                break;
        }


        switch ($shuatu)
        {
            case '3':
                $zq = '大师魔女回忆';
                break;
            case '2':
                $zq = '精英魔女回忆';
                break;
            case '1':
                $zq = '普通魔女回忆';
                break;
        }

//        dd($res2[2]);

        if($res2[2] !== '0'){
            $resArray = [
                '您的账号'.$res2[2].'挂机中',
                '剩余次数:'.$rz,
                '挂机地图:'.$zq,
                '确认要修改么？',
                $res2[0]
            ];
            return json_encode(['error_code' => 123, 'msg' => $resArray], JSON_UNESCAPED_UNICODE);
        }

        if($res2[2] === '0'){
            $shijian = (time()+$shanghao*60)*1000;
            file_get_contents('http://222.185.25.254:8088/jsp1/inputyouxi2-1.jsp?name='.$res2[0].'&pwe='.$res2[1].'&wheree=0&beizhu1='.$res2[1].'&beizhu2='.$shuatu.'');
            file_get_contents('http://222.185.25.254:8088/jsp1/delete3.jsp?name='.$res2[0].'');
            file_get_contents('http://222.185.25.254:8088/jsp1/input3.jsp?name='.$res2[0].'&passwd='.$res2[1].'&info=WZRY-2&jiange='.$shijian.'');
            $resArray = [
                '游戏战区:'.$zq2,
              '游戏账号：'.$zhanghao,
              '游戏密码：'.$res2[1],
              '当前剩余点数：'.$rz,
                '本次代刷耗费：'.$cishu,
                '预计登陆：'.$shanghao

            ];
            return json_encode(['error_code' => 123, 'msg' => $resArray], JSON_UNESCAPED_UNICODE);
        }

    }

    public function wang_yes2(Request $request)
    {

        set_time_limit(60);

        $qian=array(" ","　","\t","\n","\r");
        $hou=array("","","","","");


        $zhanghao = $request->input('zhanghao');

        $res = file('http://222.185.25.254:8088/jsp1/getyouxi2.jsp?name='.$zhanghao)[0];

//        $res = file('http://222.185.25.254:8088/jsp1/getyouxi2.jsp?name=AZQQ-972102275')[0];

        $res1 = str_replace($qian,$hou,$res);



        $res2 = explode(',',$res1);

//        dd($res2);

//        $rz = explode('/',$res2[3])[0];



        //http://222.185.25.254:8088/jsp1/inputyouxi2-1.jsp?name=(游戏战区&游戏账号)&pwe=游戏密码&wheree=几号机器登陆&beizhu1=总点数/刷图次数&beizhu2=刷图选择
        $res2 = file('http://222.185.25.254:8088/jsp1/inputyouxi2-1.jsp?name='.$res2[0].'&pwe='.$res2[1].'&wheree='.$res2[2].'&beizhu1='.$res2[3].'&beizhu2='.$res2[4].'');

//        dd($res2);

        echo "<script>alert('修改成功');history.go(-1)</script>";


    }


    public function wang_sheng(Request $request)
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



        $zhanqu = str_replace($qian,$hou,$request->input('zhanqu'));
        $zhanghao = str_replace($qian,$hou,$request->input('zhanghao'));
        $mima = str_replace($qian,$hou,$request->input('mima'));


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

    public function wang_status(Request $request)
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



        $zhanqu = str_replace($qian,$hou,$request->input('zhanqu'));
        $zhanghao = str_replace($qian,$hou,$request->input('zhanghao'));
        $mima = str_replace($qian,$hou,$request->input('mima'));


        $parm = $zhanqu.$zhanghao;

        $res = file('http://222.185.25.254:8088/jsp1/getyouxi2.jsp?name='.$parm)[0];

        $res1 = str_replace($qian,$hou,$res);

        $r = explode('/',explode(',',$res1)[3])[0];
        $r2 = explode('/',explode(',',$res1)[3])[1];
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
            return json_encode(['error_code' => 111, 'msg' => '账号错误！'], JSON_UNESCAPED_UNICODE);
        }

        $res2 = explode(',',$res1);

        switch ($res2[4])
        {
            case '3':
                $zq2 = '大师魔女回忆';
                break;
            case '2':
                $zq2 = '精英魔女回忆';
                break;
            case '1':
                $zq2 = '普通魔女回忆';
                break;
        }

        if($res2[2] !== '0'){
            $resArray = [
                '您的账号'.$res2[2].'号机器挂机中',
                '剩余次数：'.$r2,
                '挂机地图：'.$zq2

            ];
            return json_encode(['error_code' => 123, 'msg' => $resArray], JSON_UNESCAPED_UNICODE);
        }

        if($res2[2] === '0' && $res2[4] >0){
            $resArray = [
                '您的账号尚未开始',
                '剩余次数：'.$r2,
                '挂机地图：'.$zq2

            ];
            return json_encode(['error_code' => 123, 'msg' => $resArray], JSON_UNESCAPED_UNICODE);
        }

        if($res2[2] === '0' && $res2[4] === '0'){
            $resArray = [
                '您的账号，尚未设置挂机',
            ];
            return json_encode(['error_code' => 123, 'msg' => $resArray], JSON_UNESCAPED_UNICODE);
        }

        if($res2[2] === '0' && $res2[4] === '-1'){
            $resArray = [
                '您的账号，已经手动停止代挂！',
            ];
            return json_encode(['error_code' => 123, 'msg' => $resArray], JSON_UNESCAPED_UNICODE);
        }

        if($res2[2] === '0' && $res2[4] === '-2'){
            $resArray = [
                '您的账号，密码设置错误！',
            ];
            return json_encode(['error_code' => 123, 'msg' => $resArray], JSON_UNESCAPED_UNICODE);
        }


        if($res2[2] === '0' && $res2[4] === '-3'){
        $resArray = [
            '请保证您要刷的关卡，已经手动成功闯关过一次！',
        ];
        return json_encode(['error_code' => 123, 'msg' => $resArray], JSON_UNESCAPED_UNICODE);
    }

        if($res2[2] === '0' && $res2[4] === '-4'){
            $resArray = [
                '请输入手机接收到的验证码！',
            ];
            return json_encode(['error_code' => 123, 'msg' => $resArray], JSON_UNESCAPED_UNICODE);
        }

        if($res2[2] === '0' && $res2[4] === '-5'){
            $resArray = [
                '请打开微信，扫描二维码！',
            ];
            return json_encode(['error_code' => 123, 'msg' => $resArray], JSON_UNESCAPED_UNICODE);
        }



    }

}