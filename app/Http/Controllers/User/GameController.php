<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\GameZone1;
use App\Model\ProUser;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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
        if(!$request->has('z_id')){
            return json_encode(['error_code'=>222,'msg'=>'没有z_id传入'],JSON_UNESCAPED_UNICODE);
        }
        $noId = $request->input('z_id');

        $delRes = GameZone1::where('z_id',$noId)->delete();
        if(!$delRes){
            return json_encode(['error_code'=>222,'msg'=>'删除大区失败'],JSON_UNESCAPED_UNICODE);
        }

        return json_encode(['error_code'=>0,'msg'=>''],JSON_UNESCAPED_UNICODE);
    }

    //修改大区跳转的页面
    public function modZoneShow(Request $request)
    {
        $no_id = $request->input('z_id','');
        $data = GameZone1::where('z_id',$no_id)->get([
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


        $modRes = GameZone1::where('z_id',$zId)->update([
            'z_name'=>$zName,
            'z_short'=>$zShort
        ]);

        if(!$modRes){
            return json_encode(['error_code'=>222,'msg'=>'修改大区失败'],JSON_UNESCAPED_UNICODE);
        }

        return json_encode(['error_code'=>0,'msg'=>''],JSON_UNESCAPED_UNICODE);

    }
}