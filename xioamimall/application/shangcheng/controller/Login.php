<?php 
namespace app\shangcheng\controller;

use think\Controller;
use think\Session;
use app\shangcheng\model\LoginzhuceModel;
use think\session\driver\Redis;



    class Login extends Controller
    {

        //渲染小米商城登录页
        public function login(){

           return $this->fetch();
           
        }
        
        //普通登录逻辑
        public function dologin(){
            
            //接收ajax传过来的值
            if(request()->isAjax()){
                //1、接收参数
                $username = input("param.username");
                $password = input("param.password");
                $yanzhengma = input("param.yanzhengma");
                    
    
                //3、验证码验证
                if (!captcha_check( $yanzhengma) ){
                    
                    return json([
                        
                        'code' => -1,
                        'msg' => '验证码错误',
                        'data' => ''
                        
                    ]);
                }

               //2、where条件
               $where = [
                   "username" => ["eq",$username]
                   
               ];
               
                //引入model
                $loginModle = new LoginzhuceModel();
                $hasUser= $loginModle->logins($where);
                
              
                
                if(empty($hasUser)){   //为空不存在
                    return json(['code'=>-3,'msg'=>'用户不存在','data'=>'']);
                }
                
                if(md5($password) != $hasUser['password']){  //密码错误
                    return json(['code'=>-4,'msg'=>'密码错误','data'=>'']);
                }

                //写入session
                session('username', $username); //用户姓名
                session('id', $hasUser['id']); //用户id
                session('role',$hasUser['role']); //用户权限

                
                return json(['code'=>1,'msg'=>'登录成功','data'=>'/shangcheng/index/index']);
           
            }
            
        }


        //获取验证码
        public function sjlogin(){
           if(request()->isAjax()){
               //1:连接redis
               $redis = new \Redis();
               $redis->connect('127.0.0.1','6379');

               //2:获取验证码值
               $yzms = input("huoqu");


               //3:防止验证码重复提交
               $key = $redis->get('key');
               if($key){
                   return "请在1分钟之后在试";
               }else {
                   //随机数
                   $str = random_int(100000,999999);
                   //发送到手机验证码方式
                   //$res = SendSMS(”手机号码“,”数组“,1);
                   //设置有效期为60秒的键值
                   $yzm = $redis->setex('key',60,$str);
                   //把随机数赋值给获取到的值
                   $yzms = $str;
                   Session::set("yzms",$yzms);

                   return  $yzms;

               }

           }

        }

        //手机号登录
        public function sjhlogin(){

            if(request()->isAjax()){
                //接收值
                $phone = input("sjhs");
                $yzm = input("yamss");

                //从Session取出来的验证码
                $yzms = Session::get('yzms');

                //判断验证码是否正确
                if($yzm != $yzms){

                    return json(['code'=>-1,'msg'=>'验证码不正确','data'=>'']);

                }

                //判断手机号码是否合法
                if(!preg_match("/^1[345789]{1}\d{9}$/",$phone)){


                    return json([

                        'code' => -2,
                        'msg' => '手机号码不合法',
                        'data' => ''

                    ]);
                }

                //手机登录的where
                $where = [
                    'phone' => ['eq',$phone]

                ];

                //引入model
                $loginModle = new LoginzhuceModel();
                $hasUsers = $loginModle->sjhlogins($where);


                //写入session
                session('username',$phone);

                //判断是否登录成功
                if($hasUsers){

                    return json(['code'=>1,'msg'=>'登录成功','data'=>'/shangcheng/index/index']);

                }else{

                    return json(['code'=>2,'msg'=>'登录失败','data'=>'']);

                }
            }

        }


        //清除session退出登录
        public function loginOut(){
            session('username', null);
            session('id', null);

            $this->redirect(url('login'));

        }

    }





?>