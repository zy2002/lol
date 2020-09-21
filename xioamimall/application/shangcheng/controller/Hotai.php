<?php
namespace app\shangcheng\controller;

use app\shangcheng\model\HotaiModel;
use think\Controller;
use think\Session;

    class Hotai extends Controller
    {
        //5：渲染小米商城订单
        public function gerenzhongxin(){
            $user = Session::get('username');
            if( $user == null) {

                $this->assign('res', '亲!请登录');
                $this->redirect(url('/shangcheng/login/login'));

            }else{

                $this->assign('res', $user);
                return $this->fetch('dingdanzhongxin');
            }


        }

        //5：渲染小米商城我的个中心
        public  function   personal(){

            $user = Session::get('username');
            if( $user == null) {

                $this->assign('res', '亲!请登录');
                $this->redirect(url('/login/login'));

            }else{

                $this->assign('res', $user);
                return $this->fetch('self_info');
            }

        }

        //渲染我的收获地址
        public function shaddress(){

            $user = Session::get('username');
            if( $user == null) {

                $this->assign('res', '亲!请登录');
                $this->redirect(url('/login/login'));

            }else{


                //引入modle
                $hotaiModel = new HotaiModel();

                //查询省条件
                $where = [

                    'type' => ['eq',1]
                ];

                //查询省
                $province = $hotaiModel->chasheng($where);

                //查询地址
                $dizhiRes = $hotaiModel->selectdizhi();


                //分配地址
                $this->assign('dizhis',$dizhiRes);

                //分配省
                $this->assign('province',$province);
                $this->assign('res', $user);



                return $this->fetch('shaddress');
            }


        }

        //查询市县/区
        public function getRegion(){

                if(request()->isAjax()){

                    //接收值
                    $map['pid']=input("pid");
                    $map['type']=input("type");

                    //引入modle
                    $hotaiModel = new HotaiModel();


                    //sql
                    $list=db("scld")->where($map)->select();

                    return $list;

                }


        }

        //添加地址逻辑
        public function addizhis()
        {

            //判断是否是ajax接收
            if (request()->isAjax()) {
                //接收值ajax传过来的值
                $sheng = input("sheng");
                $city = input("city");
                $town = input("town");

                $dizhi = input("dizhi");
                $names = input("names");
                $phone = input("phone");
                $danxuanzhi = input("danxuanzhi");

                $zodizhi = $sheng . $city . $town;

                //判断
                //手机号码验证
                if (!preg_match("/^1[345789]{1}\d{9}$/", $phone)) {

                    return json(['code' => -4, 'msg' => '手机号码不合法', 'data' => '']);

                }


                //引入model
                $hotaiModel = new HotaiModel();

                //添加地址数据
                $data = [

                    "quyu" => $zodizhi,
                    "xxdizhi" => $dizhi,
                    "name" => $names,
                    "phone" => $phone,
                    "tinyint" => $danxuanzhi

                ];

                //添加地址方法
                $dizhiRes = $hotaiModel->adddizhi($data);

                    //成功
                    if ($dizhiRes == 1) {

                        return json(['code' => 1, 'msg' => '添加地址成功', 'data' => '']);

                    } else {

                        return json(['code' => 1, 'msg' => '添加地址失败', 'data' => '']);
                    }
                }
            }




            //删除地址
            public function shangcheng()
            {


                //接收值
                $id = input("id");

                //引入model
                $hotaiModel = new HotaiModel();

                $dihhziRes = $hotaiModel->deletedizhis($id);

                if($dihhziRes == 1){


                    return 1;


                }else{

                    return 2;

                }



            }










    }



    ?>
