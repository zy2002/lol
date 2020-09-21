<?php 
namespace app\shangcheng\model;


use think\Model;
use think\Db;

    class LoginzhuceModel extends Model
    {
        protected  $table = 'xiaomi_user';
        
        //注册用户
        public function zhuces($data){
            
            return Db::name('user')->insert($data);
 
        }

        //登录用户
        public function logins($field){
         
            return Db::name('user')->where($field)->find();
        }

        //手机号码登录用户
        public function sjhlogins($field){

            return Db::name('user')->where($field)->find();

        }
        
        //查询用户和手机号码是否被注册
        public function sflogin($field){
            
            return Db::name('user')->where($field)->select();
        }



        
        
        
        
        
    }



?>