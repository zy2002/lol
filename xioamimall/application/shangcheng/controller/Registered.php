<?php 
namespace app\shangcheng\controller;

use think\Controller;
use app\shangcheng\model\LoginzhuceModel;



 class Registered extends Controller
    {
        
        
        //渲染小米商城注册页
        public function registered(){
     
           return $this->fetch();
        
        }
        
        //注册逻辑
        public function dozhuce(){
            
            //接收ajax传过来的值
            
            if(request()->isAjax()){
                
                //1、接收参数
                $username = input("param.username");
                $password = input("param.password");
                $passwords = input("param.passwords");
                $phone = input("param.phone");
                $yanzhengma = input("param.yanzhengma");
                
             
                
                //2、验证码验证
                if (!captcha_check( $yanzhengma) ){
                    
                    return json(['code' => -1,'msg' => '验证码错误', 'data' => '']);
                }
                
                //判断用户名是否符合要求
                if(!preg_match("/^[-\w]+$/",$username)) {
                    
                    return json(['code' => -2,'msg' => '用户名不能有汉字', 'data' => '']);
                    
                }
                
                //判断密码是否符合要求
                if( !preg_match("/^[a-zA-Z0-9]{6,50}$/",$password)){
                    return json(['code' => -3,  'msg' => '密码不能小于6位', 'data' => '' ]);
                }
                
                //判断密码与确认密码是否一致
                if($password != $passwords){
                    
                    return json([ 'code' => -5, 'msg' => '两次密码输入不一致','data' => '' ]);
                }

                //手机号码验证
                if(!preg_match("/^1[345789]{1}\d{9}$/",$phone)){

                    return json([ 'code' => -4,  'msg' => '手机号码不合法', 'data' => '']);

                }
                
                //4、注册条件
                $data = [
                    "username" => $username,
                    "password" => md5($password),
                    "phone" => $phone,

                ];


                //6、是否被注册
               /* $where = [
                    "username" => ['eq',$username]

                ];*/


                //5、引人model
                $loginModel  = new LoginzhuceModel();

               /* $shifuzc= $loginModel->sflogin($where);


                //判断用户名是否注册
                if($shifuzc['username'] != $username){

                    return json(['code' => -7,'msg' => '该用户名已经被注册','data' => '']);

                }

                //判断手机号是否已经注册
                if($phone == $shifuzc['phone']){

                    return json(['code' => -6,'msg' => '该手机号已经被注册','data' => '']);

                }*/

                $shujuRes = $loginModel->zhuces($data);

                if($shujuRes == 1){
                    return json([
                        
                        'code' => 1,
                        'msg' => '注册成功',
                        'data' => '/shangcheng/login/login'
                        
                    ]);
                    
                }else{
                    
                    return json([
                        
                        'code' => 2,
                        'msg' => '注册失败',
                        'data' => ''
                        
                    ]);
                }
             
            }
            
            
            
        }
        
    }





?>