<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\GameZone1;
use App\Model\ProUser;
use App\Model\Status;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

require_once './PHPExcel.php';
require_once './PHPExcel/IOFactory.php';

class GameController extends Controller
{
    //显示游戏主界面
    public function gameShow(Request $request)
    {
        if(!$request->has('no')){
            return json_encode(['error_code'=>113,'msg'=>'没有游戏号传入'],JSON_UNESCAPED_UNICODE);
        }

        $no = $request->input('no');

        $gameStatus = DB::table('fs_status')->where('g_id',$no)->get(['g_sell_status','g_id','g_price_status']);

//        //判断游戏是否维护中
//        if($gameStatus[0]->g_sell_status == 0){
//            echo "<script>alert('游戏维护中·····');history.go(-1)</script>";
//            return;
//        }



        switch ($no) {
            case 0:
                echo "no = 0";
                break;
            case 1:
                return view('user.game1.game')->with('gameStatus',$gameStatus);
                break;
            case 2:
                return view('user.game1.game');
                break;
        }

    }

    //显示大区信息，通过传递来的参数判断是那张表
    public function zoneShow(Request $request)
    {
        if(!$request->has('t')){
            return json_encode(['error_code'=>113,'msg'=>'没有表名传入'],JSON_UNESCAPED_UNICODE);
        }

        $page_size = $request->input('page_size',10);

        $tName = $request->input('t');
        $zoneList = DB::table($tName)->paginate($page_size);
        return view('user.game1.zone')->with('zoneList',$zoneList);
    }

    //删除大区信息
    public function delZone(Request $request)
    {
        if(!$request->has('t')){
            return json_encode(['error_code'=>113,'msg'=>'没有表名传入'],JSON_UNESCAPED_UNICODE);
        }

        $tName = $request->input('t');

        if(!$request->has('z_id')){
            return json_encode(['error_code'=>222,'msg'=>'没有z_id传入'],JSON_UNESCAPED_UNICODE);
        }
        $noId = $request->input('z_id');

        $delRes = DB::table($tName)->where('z_id',$noId)->delete();
        if(!$delRes){
            return json_encode(['error_code'=>222,'msg'=>'删除大区失败'],JSON_UNESCAPED_UNICODE);
        }

        return json_encode(['error_code'=>0,'msg'=>''],JSON_UNESCAPED_UNICODE);
    }

    //修改大区跳转的页面
    public function modZoneShow(Request $request)
    {
        if(!$request->has('t')){
            return json_encode(['error_code'=>113,'msg'=>'没有表名传入'],JSON_UNESCAPED_UNICODE);
        }

        $tName = $request->input('t');

        $no_id = $request->input('z_id','');
        $data = DB::table($tName)->where('z_id',$no_id)->get([
            'z_id',
            'z_name',
            'z_short'
        ]);

        if(!$data){
            return json_encode(['error_code'=>222,'msg'=>'修改的内容不存在'],JSON_UNESCAPED_UNICODE);
        }
        return view('user.game1.mzone')->with('data',$data);
    }

    //修改大区信息
    public function modZone(Request $request)
    {
        if(!$request->has('t')){
            return json_encode(['error_code'=>113,'msg'=>'没有表名传入'],JSON_UNESCAPED_UNICODE);
        }

        $tName = $request->input('t');

        if(!$request->has('z_id')){
            return json_encode(['error_code'=>222,'msg'=>'没有z_id传入'],JSON_UNESCAPED_UNICODE);
        }
        $zId = $request->input('z_id');

        if(!$request->has('z_name')){
            return json_encode(['error_code'=>222,'msg'=>'请输入大区全称'],JSON_UNESCAPED_UNICODE);
        }
        $zName = $request->input('z_name');

        if(!$request->has('z_short')){
            return json_encode(['error_code'=>222,'msg'=>'请输入大区简称'],JSON_UNESCAPED_UNICODE);
        }
        $zShort = $request->input('z_short');


        $modRes = DB::table($tName)->where('z_id',$zId)->update([
            'z_name'=>$zName,
            'z_short'=>$zShort
        ]);

        if(!$modRes){
            return json_encode(['error_code'=>222,'msg'=>'修改大区失败'],JSON_UNESCAPED_UNICODE);
        }

        return json_encode(['error_code'=>0,'msg'=>''],JSON_UNESCAPED_UNICODE);

    }

    //添加大区
    public function addZone(Request $request)
    {
        if(!$request->has('t')){
            return json_encode(['error_code'=>113,'msg'=>'没有表名传入'],JSON_UNESCAPED_UNICODE);
        }

        $tName = $request->input('t');

        if(!$request->has('z_name')){
            return json_encode(['error_code'=>222,'msg'=>'请输入大区全称'],JSON_UNESCAPED_UNICODE);
        }
        $zName = $request->input('z_name');

        if(!$request->has('z_short')){
            return json_encode(['error_code'=>222,'msg'=>'请输入大区简称'],JSON_UNESCAPED_UNICODE);
        }
        $zShort = $request->input('z_short');

        $zRes = DB::table($tName)->insert([
            'z_name'=>$zName,
            'z_short'=>$zShort
        ]);

        if(!$zRes){
            return json_encode(['error_code'=>222,'msg'=>'添加大区失败'],JSON_UNESCAPED_UNICODE);
        }

        return json_encode(['error_code'=>0,'msg'=>''],JSON_UNESCAPED_UNICODE);
    }

    //显示账号价格信息，通过传递来的参数判断是那张表
    public function priceShow(Request $request)
    {
        if(!$request->has('t')){
            return json_encode(['error_code'=>113,'msg'=>'没有表名传入'],JSON_UNESCAPED_UNICODE);
        }

        $page_size = $request->input('page_size',10);

        $tName = $request->input('t');
        $priceList = DB::table($tName)->paginate($page_size);
        return view('user.game1.price')->with('priceList',$priceList);
    }

    //调转到修改价格页面
    public function modPriceShow(Request $request)
    {
        if(!$request->has('t')){
            return json_encode(['error_code'=>113,'msg'=>'没有表名传入'],JSON_UNESCAPED_UNICODE);
        }

        $tName = $request->input('t');

        $a_id = $request->input('a_id','');
        $data = DB::table($tName)->where('a_id',$a_id)->get([
            'a_id',
            'a_name',
            'a_price'
        ]);

        if(!$data){
            return json_encode(['error_code'=>222,'msg'=>'修改的内容不存在'],JSON_UNESCAPED_UNICODE);
        }
        return view('user.game1.mprice')->with('data',$data);
    }

    //修改账号价格
    public function modPrice(Request $request)
    {
        if(!$request->has('t')){
            return json_encode(['error_code'=>113,'msg'=>'没有表名传入'],JSON_UNESCAPED_UNICODE);
        }

        $tName = $request->input('t');

        if(!$request->has('a_id')){
            return json_encode(['error_code'=>222,'msg'=>'没有a_id传入'],JSON_UNESCAPED_UNICODE);
        }
        $zId = $request->input('a_id');

        if(!$request->has('a_name')){
            return json_encode(['error_code'=>222,'msg'=>'请输入名称'],JSON_UNESCAPED_UNICODE);
        }
        $zName = $request->input('a_name');

        if(!$request->has('a_price')){
            return json_encode(['error_code'=>222,'msg'=>'请输入价格'],JSON_UNESCAPED_UNICODE);
        }
        $zShort = $request->input('a_price');


        $modRes = DB::table($tName)->where('a_id',$zId)->update([
            'a_name'=>$zName,
            'a_price'=>$zShort
        ]);

        if(!$modRes){
            return json_encode(['error_code'=>222,'msg'=>'修改价格失败'],JSON_UNESCAPED_UNICODE);
        }

        return json_encode(['error_code'=>0,'msg'=>''],JSON_UNESCAPED_UNICODE);
    }

    //添加账号
    public function addPrice(Request $request)
    {
        if(!$request->has('t')){
            return json_encode(['error_code'=>113,'msg'=>'没有表名传入'],JSON_UNESCAPED_UNICODE);
        }

        $tName = $request->input('t');

        if(!$request->has('a_name')){
            return json_encode(['error_code'=>222,'msg'=>'请输入名称'],JSON_UNESCAPED_UNICODE);
        }
        $aName = $request->input('a_name');

        if(!$request->has('a_price')){
            return json_encode(['error_code'=>222,'msg'=>'请输入价格'],JSON_UNESCAPED_UNICODE);
        }
        $aPrice = $request->input('a_price');

        $zRes = DB::table($tName)->insert([
            'a_name'=>$aName,
            'a_price'=>$aPrice
        ]);

        if(!$zRes){
            return json_encode(['error_code'=>222,'msg'=>'添加价格失败'],JSON_UNESCAPED_UNICODE);
        }

        return json_encode(['error_code'=>0,'msg'=>''],JSON_UNESCAPED_UNICODE);
    }

    //excel
    public function readExcel(Request $request)
    {
        $ext = $request->file('excel')->getClientOriginalExtension();
        if($ext != 'xls'){
            return json_encode(['error_code'=>113,'msg'=>'上传的文件必须师.xls文件'],JSON_UNESCAPED_UNICODE);

        }

        //php.ini上传最大文件大小
        $phpSize = $request->file('excel')->getMaxFilesize();
        //上传文件的大小
        $uploadSize = $request->file('excel')->getClientSize();

        if($uploadSize > $phpSize){
            return json_encode(['error_code'=>113,'msg'=>'上传的文件大小不能超过4m'],JSON_UNESCAPED_UNICODE);
        }



        if ($request->file('excel')->isValid()){
            $request->file('excel')->move('./excel/','excel1.xls');
        }

        $objPHPExcel = \PHPExcel_IOFactory::load('./excel/excel1.xls');
        $dataArray = $objPHPExcel->getActiveSheet()->toArray();
        array_shift($dataArray);

       //为了家加快速度，简单判断下excel文件是否为null
        foreach ($dataArray as $test){
                if(is_null($test[0])){
                    return json_encode(['error_code'=>12111,'msg'=>'excel文件中空数据，请删除他们'],JSON_UNESCAPED_UNICODE);
                }
        }


        //获取没有出售的账号
        $resUser = DB::table('fs_game_bank1')->where('b_used',0)->get(['b_user']);

        //保存终端的种类
        $type = array();
        //获取账号定价
        $resAccount = DB::table('fs_game_account1')->get(['a_name','a_price']);

        //组合成名字=>价格数组,计价使用
        $nameArray = array();
        $priceArray = array();
        foreach ($resAccount as $valPrice){
            $nameArray[] = $valPrice->a_name;
            $priceArray[] = $valPrice->a_price;
        }
        $combine = array_combine($nameArray,$priceArray);

        //获取上传文件的类型种类
        foreach ($dataArray as $key=>$val){
            $type[] = $val[2];
        }


        $excelDate = array();
        //如果数据库为空，第一次上传excel文件，直接插入
        if(!$resUser){
            //处理类型，自动编号
            $arrayCount = array_count_values($type);
            $typeUni = array_unique($type);
            $terminalArray = array();
            foreach ($typeUni as $v){

                for($i = 1;$i <= $arrayCount[$v];$i++){
                    $terminalArray[$v][] = $v.sprintf("%'06d", $i);
                }
            }


            foreach ($dataArray as $key=>$val){
                $price = 0;
                $excelDate[$key]['b_user'] = $val[0];
                $excelDate[$key]['b_pwd'] = $val[1];
                $excelDate[$key]['b_terminal'] = $val[2];
                $excelDate[$key]['b_zone'] = $val[3];
                $excelDate[$key]['b_group'] = $val[4];
                $excelDate[$key]['b_no'] = array_shift($terminalArray[$val[2]]);



                //判断价格字段进行相应的处理
                if(!$val[5]){
                    $pArray = explode('+',$val[4]);

                    foreach ($pArray as $pVal){
                        $price += $combine[$pVal];
                    }
                    $excelDate[$key]['b_price'] = $price;
                }elseif ($val[5]>0 && $val[5]<1){
                    $pArray = explode('+',$val[4]);

                    foreach ($pArray as $pVal){
                        $price += $combine[$pVal];
                    }
                    $excelDate[$key]['b_price'] = $price*$val[5];
                }elseif($val[5]>1){
                    $excelDate[$key]['b_price'] = $val[5];
                }
            }


            //插入数据库
            $resInsert = DB::table('fs_game_bank1')->insert($excelDate);
            if($resInsert){
                echo <<<EOT
"<script type="text/javascript">
        alert("上传文件成功");
        self.location=document.referrer;
    </script>"
EOT;
//                return json_encode(['error_code'=>0,'msg'=>'导入excel文件成功'],JSON_UNESCAPED_UNICODE);
            }
        }


        //数据库不为空，获取当前数据库存在的对应最大编号
        $typeUni = array_unique($type);
        $arrayCount = array_count_values($type);
        $resArray = array();
        foreach ($typeUni as $val){
            $res = DB::table('fs_game_bank1')->where('b_terminal',$val)->orderBy('b_no','desc')->first(['b_no']);
            $res1 = substr($res->b_no,-6);
            $res1=$res1+0;
            for($i = $res1+1;$i <= $arrayCount[$val]+$res1;$i++){
                $resArray[$val][] = $val.sprintf("%'06d", $i);
            }
        }
//        dd($arrayCount);
//        dd($resArray);
        //如果数据库不为空,拼装用户名数组
        $resU = 0;
        $resI = 0;
        $userArray = array();
        foreach ($resUser as $userVal){
            $userArray[] = $userVal->b_user;
        }

        foreach ($dataArray as $key=>$val){
            //如果导入的文件中用户名存在，进行更新
            if(in_array($val[0],$userArray)){
                $price = 0;
                //判断价格字段进行相应的处理
                if(!$val[5]){
                    $pArray = explode('+',$val[4]);
                    foreach ($pArray as $pVal){
                        $price += $combine[$pVal];
                    }

                }elseif ($val[5]>0 && $val[5]<1){
                    $pArray = explode('+',$val[4]);

                    foreach ($pArray as $pVal){
                        $price += $combine[$pVal];
                    }

                    $price = $price*$val[5];
                }elseif($val[5]>1){
                    $price = $val[5];
                }

                $resUpdeta = DB::table('fs_game_bank1')->where('b_user',$val[0])->update([
                    'b_pwd'=>$val[1],
                    'b_zone'=>$val[3],
                    'b_group'=>$val[4],
                    'b_price'=>$price,
                    'b_com'=>$val[6],
                    'b_status'=>1
                ]);


                if($resUpdeta){
                    $resU++;
                }

            }else{

                //如果导入的文件中用户名不存在，进行插入
                $price = 0;
                $excelDate[$key]['b_user'] = $val[0];
                $excelDate[$key]['b_pwd'] = $val[1];
                $excelDate[$key]['b_terminal'] = $val[2];
                $excelDate[$key]['b_zone'] = $val[3];
                $excelDate[$key]['b_group'] = $val[4];
                $excelDate[$key]['b_com'] = $val[6];
                $excelDate[$key]['b_no'] = array_shift($resArray[$val[2]]);

                //判断价格字段进行相应的处理
                if(!$val[5]){
                    $pArray = explode('+',$val[4]);

                    foreach ($pArray as $pVal){
                        $price += $combine[$pVal];
                    }
                    $excelDate[$key]['b_price'] = $price;
                }elseif ($val[5]>0 && $val[5]<1){
                    $pArray = explode('+',$val[4]);

                    foreach ($pArray as $pVal){
                        $price += $combine[$pVal];
                    }
                    $excelDate[$key]['b_price'] = $price*$val[5];
                }elseif($val[5]>1){
                    $excelDate[$key]['b_price'] = $val[5];
                }

            }

        }
        if(!empty($excelDate)){
            $resInsert = DB::table('fs_game_bank1')->insert($excelDate);
                if($resInsert){
                    $resI++;
                }
        }
        //如果更新和插入都成功，提示上传excel文件成功
            if($resI+$resU>1){
                echo <<<EOT
"<script type="text/javascript">
        alert("上传文件成功");
        self.location=document.referrer;
    </script>"
EOT;
//                return json_encode(['error_code'=>0,'msg'=>'excel文件上传成功'],JSON_UNESCAPED_UNICODE);
            }

    }

    //显示账号列表
    public function bankShow(Request $request)
    {
        if(!$request->has('t')){
            return json_encode(['error_code'=>113,'msg'=>'没有表名传入'],JSON_UNESCAPED_UNICODE);
        }

        $page_size = $request->input('page_size',10);

        $countArray = array();
        $tName = $request->input('t');

        $bankCount = DB::table($tName)->count();
        $nousedCount = DB::table($tName)->where('b_used',0)->count();

        $usedCount = $bankCount - $nousedCount;
        $countArray['bankCount'] = $bankCount;
        $countArray['nousedCount'] = $nousedCount;
        $countArray['usedCount'] = $usedCount;


        $bankList = DB::table($tName)->paginate($page_size);

        return view('user.game1.bank')
            ->with('bankList',$bankList)
            ->with('countArray',$countArray);
    }

    //更新组合账号的价格
    public function updatePrice(Request $request)
    {
        if(!$request->has('t')){
            return json_encode(['error_code'=>113,'msg'=>'没有表名传入'],JSON_UNESCAPED_UNICODE);
        }

        $tName = $request->input('t');

        if(!$request->has('b_id')){
            return json_encode(['error_code'=>222,'msg'=>'没有b_id传入'],JSON_UNESCAPED_UNICODE);
        }
        $zId = $request->input('b_id');

        if(!$request->has('b_price')){
            return json_encode(['error_code'=>222,'msg'=>'请输入价格'],JSON_UNESCAPED_UNICODE);
        }
        $zShort = $request->input('b_price');

        $zShort = intval($zShort);

        $modRes = DB::table($tName)->where('b_id',$zId)->update([
            'b_price'=>$zShort
        ]);


        if(!$modRes){
            return json_encode(['error_code'=>222,'msg'=>'更新价格失败'],JSON_UNESCAPED_UNICODE);
        }

        return json_encode(['error_code'=>0,'msg'=>''],JSON_UNESCAPED_UNICODE);
    }

    //单个删除组合账号
    public function delSingle(Request $request)
    {
        if(!$request->has('t')){
            return json_encode(['error_code'=>113,'msg'=>'没有表名传入'],JSON_UNESCAPED_UNICODE);
        }

        $tName = $request->input('t');

        if(!$request->has('b_id')){
            return json_encode(['error_code'=>222,'msg'=>'没有b_id传入'],JSON_UNESCAPED_UNICODE);
        }
        $noId = $request->input('b_id');

        $delRes = DB::table($tName)->where('b_id',$noId)->delete();
        if(!$delRes){
            return json_encode(['error_code'=>222,'msg'=>'删除组合账号'],JSON_UNESCAPED_UNICODE);
        }

        return json_encode(['error_code'=>0,'msg'=>''],JSON_UNESCAPED_UNICODE);
    }

    //批量删除组合账号
    public function delBatch(Request $request)
    {
        if(!$request->has('t')){
            return json_encode(['error_code'=>113,'msg'=>'没有表名传入'],JSON_UNESCAPED_UNICODE);
        }

        $tName = $request->input('t');

        if(!$request->has('b_ids')){
            return json_encode(['error_code'=>222,'msg'=>'没有b_ids传入'],JSON_UNESCAPED_UNICODE);
        }
        $bIds = $request->input('b_ids');

        //$bIds删除重复元素
        $newBids = array_unique( $bIds);

        $delRes = DB::table($tName)->whereIn('b_id',$newBids)->delete();
        if(!$delRes){
            return json_encode(['error_code'=>222,'msg'=>'删除组合账号'],JSON_UNESCAPED_UNICODE);
        }

        return json_encode(['error_code'=>0,'msg'=>''],JSON_UNESCAPED_UNICODE);
    }

    //跳转组合账号修改页面
    public function modGroupShow(Request $request)
    {
        if(!$request->has('t')){
            return json_encode(['error_code'=>113,'msg'=>'没有表名传入'],JSON_UNESCAPED_UNICODE);
        }

        $tName = $request->input('t');

        $b_id = $request->input('b_id','');
        $data = DB::table($tName)->where('b_id',$b_id)->get([
            'b_id',
            'b_user',
            'b_pwd',
            'b_zone',
            'b_terminal',
            'b_group',
            'b_com',
            'b_price'
        ]);

        if(!$data){
            return json_encode(['error_code'=>222,'msg'=>'修改的内容不存在'],JSON_UNESCAPED_UNICODE);
        }

        //获取所有大区和简称
        $zoneData = DB::table('fs_game_zone1')->get();

        return view('user.game1.mgroup')->with('data',$data)->with('zoneData',$zoneData);
    }

    //修改组合账号
    public function modGroup(Request $request)
    {
        if(!$request->has('t')){
            return json_encode(['error_code'=>113,'msg'=>'没有表名传入'],JSON_UNESCAPED_UNICODE);
        }

        $tName = $request->input('t');

        if(!$request->has('b_id')){
            return json_encode(['error_code'=>222,'msg'=>'没有b_id传入'],JSON_UNESCAPED_UNICODE);
        }
        $bId = $request->input('b_id');

        if(!$request->has('b_user')){
            return json_encode(['error_code'=>222,'msg'=>'没有账号'],JSON_UNESCAPED_UNICODE);
        }
        $bUser = $request->input('b_user');

        if(!$request->has('b_pwd')){
            return json_encode(['error_code'=>222,'msg'=>'没有密码'],JSON_UNESCAPED_UNICODE);
        }
        $bPwd = $request->input('b_pwd');

        if(!$request->has('b_terminal')){
            return json_encode(['error_code'=>222,'msg'=>'没有大区简称'],JSON_UNESCAPED_UNICODE);
        }
        $bTerminal = $request->input('b_terminal');

        if(!$request->has('b_zone')){
            return json_encode(['error_code'=>222,'msg'=>'没有大区名称'],JSON_UNESCAPED_UNICODE);
        }
        $bZone = $request->input('b_zone');

        if(!$request->has('b_group')){
            return json_encode(['error_code'=>222,'msg'=>'没有组合'],JSON_UNESCAPED_UNICODE);
        }
        $bGroup = $request->input('b_group');

        $bCom = $request->input('b_com','');

        if(!$request->has('b_price')){
            return json_encode(['error_code'=>222,'msg'=>'没有价格'],JSON_UNESCAPED_UNICODE);
        }
        $bPrice = $request->input('b_price');


        $modRes = DB::table($tName)->where('b_id',$bId)->update([
            'b_user'=>$bUser,
            'b_pwd'=>$bPwd,
            'b_terminal'=>$bTerminal,
            'b_zone'=>$bZone,
            'b_group'=>$bGroup,
            'b_com'=>$bCom,
            'b_price'=>$bPrice
        ]);

        if(!$modRes){
            return json_encode(['error_code'=>222,'msg'=>'修改组合账号失败'],JSON_UNESCAPED_UNICODE);
        }

        return json_encode(['error_code'=>0,'msg'=>''],JSON_UNESCAPED_UNICODE);
    }

    //调转到上传组合账号页面
    public function uploadShow(Request $request)
    {
        if(!$request->has('t')){
            return json_encode(['error_code'=>113,'msg'=>'没有表名传入'],JSON_UNESCAPED_UNICODE);
        }

        $tName = $request->input('t');

        $zoneData = DB::table('fs_game_zone1')->get();

        return view('user.game1.upload')->with('tName',$tName)->with('zoneData',$zoneData);

    }

    //批量上传组合账号
    public function upload(Request $request)
    {
        $ext = $request->file('excel')->getClientOriginalExtension();
        if($ext != 'xls'){
            return json_encode(['error_code'=>113,'msg'=>'上传的文件必须师.xls文件'],JSON_UNESCAPED_UNICODE);

        }

        //php.ini上传最大文件大小
        $phpSize = $request->file('excel')->getMaxFilesize();
        //上传文件的大小
        $uploadSize = $request->file('excel')->getClientSize();

        if($uploadSize > $phpSize){
            return json_encode(['error_code'=>113,'msg'=>'上传的文件大小不能超过4m'],JSON_UNESCAPED_UNICODE);
        }



        if ($request->file('excel')->isValid()){
            $request->file('excel')->move('./excel/','excel1.xls');
            echo <<<EOT
"<script type="text/javascript">
        alert("上传文件成功");
        self.location=document.referrer;
    </script>"
EOT;
        }

    }

    //修改游戏销售状态
    public function changeSell(Request $request)
    {
        if(!$request->has('g_id')){
            return json_encode(['error_code'=>222,'msg'=>'没有g_id传入'],JSON_UNESCAPED_UNICODE);
        }

        $gId = $request->input('g_id');

        $res = Status::where('g_id',$gId)->get(['g_sell_status']);

        if(!$res->isEmpty()){
            $resSta = $res->toArray()[0]["g_sell_status"];
        }

        if($resSta == 1){
            $res1 = Status::where('g_id',$gId)->update(['g_sell_status' => 0]);

            if(!$res1){
                return json_encode(['error_code'=>222,'msg'=>'修改状态失败'],JSON_UNESCAPED_UNICODE);
            }
        }elseif($resSta == 0){
            $res1 = Status::where('g_id',$gId)->update(['g_sell_status' => 1]);

            if(!$res1) {
                return json_encode(['error_code'=>222,'msg'=>'修改状态失败'],JSON_UNESCAPED_UNICODE);
            }
        }

        return json_encode(['error_code'=>0,'msg'=>''],JSON_UNESCAPED_UNICODE);
    }

    //修改价格显示状态
    public function changePrice(Request $request)
    {
        if(!$request->has('g_id')){
            return json_encode(['error_code'=>222,'msg'=>'没有g_id传入'],JSON_UNESCAPED_UNICODE);
        }

        $gId = $request->input('g_id');

        $res = Status::where('g_id',$gId)->get(['g_price_status']);

        if(!$res->isEmpty()){
            $resSta = $res->toArray()[0]["g_price_status"];
        }

        if($resSta == 1){
            $res1 = Status::where('g_id',$gId)->update(['g_price_status' => 0]);

            if(!$res1){
                return json_encode(['error_code'=>222,'msg'=>'修改状态失败'],JSON_UNESCAPED_UNICODE);
            }
        }elseif($resSta == 0){
            $res1 = Status::where('g_id',$gId)->update(['g_price_status' => 1]);

            if(!$res1) {
                return json_encode(['error_code'=>222,'msg'=>'修改状态失败'],JSON_UNESCAPED_UNICODE);
            }
        }

        return json_encode(['error_code'=>0,'msg'=>''],JSON_UNESCAPED_UNICODE);
    }
}