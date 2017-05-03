<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\GameZone1;
use App\Model\ProUser;
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
        switch ($no) {
            case 0:
                echo "no = 0";
                break;
            case 1:
                return view('user.game1.game');
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
        $objPHPExcel = \PHPExcel_IOFactory::load('C:\Users\wuyanjun\Desktop\yys2.xls');
        $dataArray = $objPHPExcel->getActiveSheet()->toArray();
        array_shift($dataArray);

        $resUser = DB::table('fs_game_bank1')->where('b_used',0)->get(['b_user']);

//        dd($zones);
//        //获取大区自动编码的起始值
//        $noStart = DB::table('fs_game_bank1')->where('b_terminal','ios')->orderBy('b_no', 'desc')->first(['b_no']);
//
//        if(!$noStart){
//            $bNo = '000001';
//        }
//        $bNo = $noStart->b_no+1;
//        $bNo = sprintf("%'06d", $bNo);
//        var_dump($bNo);
//        die;

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

        $excelDate = array();
        //如果数据库为空，第一次上传excel文件，直接插入
        if(!$resUser){
            foreach ($dataArray as $key=>$val){
                $price = 0;
                $excelDate[$key]['b_user'] = $val[0];
                $excelDate[$key]['b_pwd'] = $val[1];
                $excelDate[$key]['b_terminal'] = $val[2];
                $excelDate[$key]['b_zone'] = $val[3];
                $excelDate[$key]['b_group'] = $val[4];
                $pArray = explode('+',$val[4]);

                foreach ($pArray as $pVal){
                    $price += $combine[$pVal];
                }
                $excelDate[$key]['b_price'] = $price;

            }
            //插入数据库
            $resInsert = DB::table('fs_game_bank1')->insert($excelDate);
            if($resInsert){
                return json_encode(['error_code'=>0,'msg'=>'导入excel文件成功'],JSON_UNESCAPED_UNICODE);
            }
        }


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
                $pArray = explode('+',$val[4]);

                foreach ($pArray as $pVal){
                    $price += $combine[$pVal];
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
                    $resU = 1;
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
                $pArray = explode('+',$val[4]);

                foreach ($pArray as $pVal){
                    $price += $combine[$pVal];
                }
                $excelDate[$key]['b_price'] = $price;
                //插入数据库
                $resInsert = DB::table('fs_game_bank1')->insert($excelDate);
                if($resInsert){
                    $resI = 1;
                }
            }

            //如果更新和插入都成功，提示上传excel文件成功
            if($resI+$resU>1){
                return json_encode(['error_code'=>0,'msg'=>'excel文件上传成功'],JSON_UNESCAPED_UNICODE);
            }

        }

    }

}