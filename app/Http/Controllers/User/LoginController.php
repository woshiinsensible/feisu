<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\ProUser;
use App\Model\User;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class LoginController extends Controller
{

    //盐值
    public $solt = 'insensible';

    public function test2(Request $request)
    {
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-type: image/jpeg');
        $builder = new CaptchaBuilder;
        $builder->build($width = 100, $height = 40, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();

        //把内容存入session
        $request->session()->put('ver_code', $phrase);
        //生成图片

        $builder->output();
    }

    public function test(Request $request)
    {
        $verCodeSession = $request->session()->get('user_token1');

        var_dump($verCodeSession);
    }
    //用户登录
    public function login(Request $request)
    {
        //role_id等于1，管理员登录；2，代理用户登录
        if(!$request->has('role')){
            return json_encode(['error_code'=>441,'msg'=>'角色不能为空'],JSON_UNESCAPED_UNICODE);
        }
        $roleId = $request->input('role');
        if(!in_array($roleId,[1,2,3])){
            return json_encode(['error_code'=>442,'msg'=>'角色不正确'],JSON_UNESCAPED_UNICODE);
        }

        if($roleId == 1){
            //name
            if(!$request->has('name')){
                return json_encode(['error_code'=>111,'msg'=>'用户名不能为空'],JSON_UNESCAPED_UNICODE);
            }

            $userName = $request->input('name');
            $userLen = mb_strlen($userName);
            if($userLen<4 || $userLen>10){
                return json_encode(['error_code'=>221,'msg'=>'用户名在4-10位之间'],JSON_UNESCAPED_UNICODE);
            }

            $res1 = User::where('user_name',$userName)->get(['user_id']);
            if($res1->isEmpty()){
                return json_encode(['error_code'=>331,'msg'=>'用户不存在'],JSON_UNESCAPED_UNICODE);
            }

            $userId = $res1->toArray()[0]['user_id'];

            //password
            if(!$request->has('password')){
                return json_encode(['error_code'=>112,'msg'=>'密码不能为空'],JSON_UNESCAPED_UNICODE);
            }
            $userPassword = $request->input('password');
            $userLen = mb_strlen($userPassword);
            if($userLen<6 || $userLen>12){
                return json_encode(['error_code'=>222,'msg'=>'密码在6-12位之间'],JSON_UNESCAPED_UNICODE);
            }

            $userPasswordMd5 = md5($userPassword);
            $res = User::where('user_pwd',$userPasswordMd5)->where('user_id',$userId)->get(['user_id']);
            if($res->isEmpty()){
                return json_encode(['error_code'=>332,'msg'=>'密码不正确'],JSON_UNESCAPED_UNICODE);
            }


            //verCode
            if(!$request->has('ver_code')){
                return json_encode(['error_code'=>551,'msg'=>'验证码不能为空'],JSON_UNESCAPED_UNICODE);
            }
            $verCode = $request->input('ver_code');

            $verCodeSession = $request->session()->pull('ver_code');

            //验证码0000，不用验证
            if($verCode != 0000){
                if(strcmp($verCodeSession, $verCode) !== 0){
                    return json_encode(['error_code'=>771,'msg'=>'验证码不正确'],JSON_UNESCAPED_UNICODE);
                }
            }

            //生成token放入session，并跳转页面
            $user_id = $res1->toArray()[0]['user_id'];
            $user_token = base64_encode($user_id.'-'.$this->solt.'-'.md5(uniqid(mt_rand(),1)));
            $request->session()->put('user_token', $user_token);
            $request->session()->put('user_name', $userName);
            //判断role，跳转到不同的页面
//        if($roleId == 1){
//            return view('user.admin');
//        }else{
//            return view('user.poxy');
//        }
            //通过ajax调转对应页面
            return json_encode(['error_code'=>0,'msg'=>'','role'=>$roleId],JSON_UNESCAPED_UNICODE);
        }

        //role_id=2位代理用户登录
        if($roleId == 2){
            //name
            if(!$request->has('name')){
                return json_encode(['error_code'=>111,'msg'=>'用户名不能为空'],JSON_UNESCAPED_UNICODE);
            }

            $userName = $request->input('name');
            $userLen = mb_strlen($userName);
            if($userLen<4 || $userLen>10){
                return json_encode(['error_code'=>221,'msg'=>'用户名在4-10位之间'],JSON_UNESCAPED_UNICODE);
            }

            $res1 = ProUser::where('pro_name',$userName)->get(['pro_id']);
            if($res1->isEmpty()){
                return json_encode(['error_code'=>331,'msg'=>'用户不存在'],JSON_UNESCAPED_UNICODE);
            }

            $proId = $res1->toArray()[0]['pro_id'];

            //password
            if(!$request->has('password')){
                return json_encode(['error_code'=>112,'msg'=>'密码不能为空'],JSON_UNESCAPED_UNICODE);
            }
            $userPassword = $request->input('password');
            $userLen = mb_strlen($userPassword);
            if($userLen<6 || $userLen>12){
                return json_encode(['error_code'=>222,'msg'=>'密码在6-12位之间'],JSON_UNESCAPED_UNICODE);
            }

            $userPasswordMd5 = md5($userPassword);
            $res = ProUser::where('pro_pwd',$userPasswordMd5)->where('pro_id',$proId)->get(['pro_id']);
            if($res->isEmpty()){
                return json_encode(['error_code'=>332,'msg'=>'密码不正确'],JSON_UNESCAPED_UNICODE);
            }


            //verCode
            if(!$request->has('ver_code')){
                return json_encode(['error_code'=>551,'msg'=>'验证码不能为空'],JSON_UNESCAPED_UNICODE);
            }
            $verCode = $request->input('ver_code');

            $verCodeSession = $request->session()->pull('ver_code');

            //验证码0000，不用验证
            if($verCode != 0000){
                if(strcmp($verCodeSession, $verCode) !== 0){
                    return json_encode(['error_code'=>771,'msg'=>'验证码不正确'],JSON_UNESCAPED_UNICODE);
                }
            }


            //生成token放入session，并跳转页面
            $user_id = $res1->toArray()[0]['pro_id'];
            $user_token = base64_encode($user_id.'-'.$this->solt.'-'.md5(uniqid(mt_rand(),1)));
            $request->session()->put('user_token', $user_token);
            $request->session()->put('user_name', $userName);

            //判断role，跳转到不同的页面
//        if($roleId == 1){
//            return view('user.admin');
//        }else{
//            return view('user.poxy');
//        }
            //通过ajax调转对应页面
            return json_encode(['error_code'=>0,'msg'=>'','role'=>$roleId],JSON_UNESCAPED_UNICODE);
        }
    }
}