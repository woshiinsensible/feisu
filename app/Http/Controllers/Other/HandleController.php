<?php
namespace App\Http\Controllers\Other;

use App\Http\Controllers\Controller;
use App\Model\Notice;
use App\Model\Pickup;
use App\Model\ProUser;
use App\Model\Recharge;
use App\Model\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class HandleController extends Controller
{
    //获取信息插入表7
    public function getInfo(Request $request)
    {
        if (!$request->has('reg_code')) {
            return json_encode(['error' => 111, 'msg' => '注册码不能为空'], JSON_UNESCAPED_UNICODE);
        }
        $regCode = $request->input('reg_code');

        if (!$request->has('account')) {
            return json_encode(['error' => 111, 'msg' => '账号不能为空'], JSON_UNESCAPED_UNICODE);
        }
        $account = $request->input('account');

        if (!$request->has('password')) {
            return json_encode(['error' => 111, 'msg' => '密码不能为空'], JSON_UNESCAPED_UNICODE);
        }
        $password = $request->input('password');

        if (!$request->has('device')) {
            return json_encode(['error' => 111, 'msg' => '设备不能为空'], JSON_UNESCAPED_UNICODE);
        }
        $device = $request->input('device');

        $ress = file_get_contents("http://feifeifuzhu.com/feifei/index.php/Admin/getCode/zhucema/{$regCode}/youxi/WARZ2");

        $count = explode(',',$ress);

        if(empty($count)){
            return json_encode(['error' => 111, 'msg' => '注册码错误'], JSON_UNESCAPED_UNICODE);
        }

        //获取限制数量
//        dd($count[5]);
//        die;

        //获取时间
        if($count[8] === '0'){
            switch ($count[7])
            {
                case 'ri':
                    $expiry = time()+3600*24;
                    break;
                case 'zhou':
                    $expiry = time()+3600*24*7;
                    break;
                case 'yue':
                    $expiry = time()+3600*24*30;
                    break;
                case 'ji':
                    $expiry = time()+3600*24*90;
                    break;
                case 'nian':
                    $expiry = time()+3600*24*356;
                    break;
                default:
                    return json_encode(['error' => 111, 'msg' => '有效期无效'], JSON_UNESCAPED_UNICODE);
            }
        }elseif (time() < $count[7]){
            return json_encode(['error' => 111, 'msg' => '注册码已经到期，请联系管理购买时间，唯一QQ：972102275'], JSON_UNESCAPED_UNICODE);
        }

        $res = file_get_contents("http://www.feifeifuzhu.com/feifei/index.php/Index/getNewCode/wzname/{$account}/wzpwe/{$device}/pass/{$password}/game/WARZ");

        if(!$res){
            return json_encode(['error' => 111, 'msg' => '输入有误'], JSON_UNESCAPED_UNICODE);
        }
        $res2 = explode('|', $res);

        $num = count($res2);

        if($num > intval($count[5])){
            return json_encode(['error' => 111, 'msg' => '挂机数量超过注册码限制数量，请修改后，重新提交！'], JSON_UNESCAPED_UNICODE);

        }

        $arr1 = array(
            '游戏客户端',
            '账号1',
            '密码',
            'px/py',
            '采集部队',
            '采集联盟矿',
            '满兵采集',
            '采集带指挥官',
            '采集石油',
            '采集粮食',
            '采集钢材',
            '采集合金',
            '造射手',
            '造勇士',
            '造战车',
            '造僵尸',
            '造兵等级',
            '造兵上限',
            //If 造兵上限 = 0 Then 造兵上限=999999
            '治疗伤兵',
            '建筑列队',
            '升级基地',
            '升级其他建筑',
            '升级城外建筑',
            '空地建设',
            '升级顺序',
            '研究科技',
            '优先三列队',
            '援助中心位置',
            '援助资源',
            '修复城墙',
            '钻石灭火',
            '粮食收割',
            '收割间隔',
            '疯狂采集',
            '采集加成',
            '留空',
            '城外音响',
            '探险任务',
            '深耕',
            '金手指',
            '自动开罩',
            '资源箱',
            '自助餐厅',
            '联盟工资',
            '联盟捐款',
            '联盟帮助',
            '防封_聊天',
            '防封_攻击',
            '军械库',
            '生产材料',
            '买家换号间隔',
            '深夜挂机',
        );


//        dd($arr1);

        //判断数据是否正确
        foreach ($res2 as $val2) {
            $res3 = explode(',', $val2);
//            dd($res3);
            if (count($res3) == 50) {
                return json_encode(['error' => 111, 'msg' => '配置错误，修改配置'], JSON_UNESCAPED_UNICODE);
            }
            if (!strstr($res3[3], '/')) {
                return json_encode(['error' => 111, 'msg' => '坐标信息错误'], JSON_UNESCAPED_UNICODE);
            }
        }

        foreach ($res2 as $val2) {
            $res3 = explode(',', $val2);

            if ($res3[50] == '') {
                $res3[50] = '0';
            }
            if ($res3[17] == '0') {
                $res3[17] = '999999';
            }
            if ($res3[31] == '0') {
                $res3[32] = '-1';
            }


            if($res3[12]>0){
                $a1 = 10;
            }
            if($res3[13]>0){
                $a2 = 10;
            }
            if($res3[14]>0){
                $a3 = 10;
            }
            if($res3[15]>0){
                $a4 = 10;
            }

            if($res3[20]>0){
                $a5 = 20;
            }
            if($res3[21]>0){
                $a6 = 15;
            }
            if($res3[22]>0){
                $a7 = 15;
            }

            if($res3[34] == 1){
                $a8 = 10;
            }elseif ($res3[34] >1){
                $a8 = 20;
            }
            if($res3[41] == 1){
                $a9 = 5;
            }elseif ($res3[41] >1){
                $a9 = 10;
            }
            if($res3[46] == 1){
                $a10 = 10;
            }elseif ($res3[46] >1){
                $a10 = 10;
            }

            if($res3[48] >0){
                $a11 = 10;
            }

            $a = $a1+$a2+$a3+$a4+intval($res3[18])*15+$a5+$a6+$a7+intval($res3[25])*15+intval($res3[29])*10+intval($res3[31])*25+intval($res3[33])*5+$a8+intval($res3[36])*5+intval($res3[37])*10+intval($res3[38])*5+intval($res3[39])*5+intval($res3[40])*10+$a9+intval($res3[42])*5+intval($res3[43])*10+intval($res3[44])*15+intval($res3[45])*10+$a10+$a11+intval($res3[47])*20;

            if($count[5] <30){
                $b = $num/$count[5]*120;
            }elseif($count[5] >29){
                $b = $num/30*120;
            }

            $c = ($a+90)*0.8/400*$b;
            if($c < 45){
                $c =45;
            }

            $res4 = array_combine($arr1, $res3);

            $where = $regCode . "/0/" . $account . "/" . $password . "/" . $device;
            $gold = "0/0/0/0";
            $honor = $res4['px/py'] . "/" . $res4['采集部队'] . "/" . $res4['采集带指挥官'] . "/" . $res4['满兵采集'] . "/" . $res4['采集石油'] . "/" . $res4['采集粮食'] . "/" . $res4['采集钢材'] . "/" . $res4['采集合金'] . "/" . $res4['深耕'] . "/" . $res4['金手指'];
            $honor2 = $res4['援助中心位置'] . "/" . $res4['援助资源'] . "/" . $res4['修复城墙'] . "/" . $res4['钻石灭火'] . "/" . $res4['收割间隔'] . "/" . $res4['疯狂采集'] . "/" . $res4['采集加成'] . "/" . $res4['城外音响'] . "/" . $res4['探险任务'] . "/" . $res4['自助餐厅'] . "/" . $res4['联盟工资'] . "/" . $res4['联盟捐款'] . "/" . $res4['联盟帮助'] . "/" . $res4['军械库'] . "/" . $res4['生产材料'] . "/" . $res4['自动开罩'] . "/" . $res4['资源箱'];
            $city = $res4['升级基地'] . "/0";
            $school = $res4['建筑列队'] . "/" . $res4['升级其他建筑'] . "/" . $res4['升级城外建筑'] . "/" . $res4['空地建设'] . "/" . $res4['升级顺序'];
            $book = $res4['研究科技'] . "/0/" . $res4['防封_聊天'] . "/" . $res4['防封_攻击'] . "/" . $res4['深夜挂机'];
            $fire = $res4['造兵上限'] . "/" . $res4['治疗伤兵'] . "/" . $res4['造射手'] . "/" . $res4['造勇士'] . "/" . $res4['造战车'] . "/" . $res4['造僵尸'];
            $model = "0/0";
            $jiange = "0/0/0";
            $jiange2 = "0/" . $c;

            $test = "http://222.185.25.254:8088/jsp1/input7-1.jsp?day=0&name=$account&passwd=$password&wheree=$where&gold=$gold&honor=$honor&honor2=$honor2&city=$city&school=$school&book=$book&fire=$fire&model=$model&jiange=$jiange&jiange2=$jiange2";


            file_get_contents($test);

            //cs=当前时间+60*15   （表示这个账号先放到3表里面，等15分钟后，传回1表）
            $cs = time()+60*15;
            file_get_contents("http://222.185.25.254:8088/jsp1/input3.jsp?name=$account&passwd=$password&info=WARZ-3&jiange=$cs");


            return json_encode(['error' => 0, 'msg' => ''], JSON_UNESCAPED_UNICODE);
        }

    }

    //添加删除按钮的功能
    public function delInfo(Request $request)
    {
        if (!$request->has('reg_code')) {
            return json_encode(['error' => 111, 'msg' => '注册码不能为空'], JSON_UNESCAPED_UNICODE);
        }
        $regCode = $request->input('reg_code');

        $res = file_get_contents("http://222.185.25.254:8088/jsp1/get8.jsp?name=$regCode");
        $res2 = explode(',',trim($res));
        $res3 = explode('/',$res2[3]);
        foreach ($res3 as $val3){
            if(!empty($val3)){
                file_get_contents("http://222.185.25.254:8088/jsp1/delete1.jsp?name=$val3");
                file_get_contents("http://222.185.25.254:8088/jsp1/delete3.jsp?name=$val3");
                file_get_contents("http://222.185.25.254:8088/jsp1/delete7.jsp?name=$val3");
            }
        }
        file_get_contents("http://222.185.25.254:8088/jsp1/delete8.jsp?name=$regCode");
        return json_encode(['error' => 0, 'msg' => ''], JSON_UNESCAPED_UNICODE);
    }
}