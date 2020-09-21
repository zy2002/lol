<?php
namespace app\shangcheng\controller;

use think\Controller;
use think\Session;
use app\shangcheng\model\IndexModel;

    class Index extends Controller
    {

            //1:渲染主页小米商城
            public function  index(){

                $user = Session::get('username');
                if( $user == null){

                    $this->assign('res','亲!请登录');
                    return $this->fetch();

                }else{
                    //查询小米明星单品

                    $danModel = new IndexModel();

                    $item = "小米明星单品";

                    $where = [

                        'cateid' => ['eq',$item]

                    ];

                    $shujuRes = $danModel->selectitem($where);

                    $this->assign('shujus', $shujuRes);
                    $this->assign('res', $user);
                    return $this->fetch();

                }

            }




            //2:渲染购物车页
            public function  gouwuche(){
                $user = Session::get('username');

                if( $user == null) {

                    $this->assign('res', '亲!请登录');
                    return $this->fetch('gouwuche');

                }else{

                    $this->assign('res', $user);
                    return $this->fetch('gouwuche');
                }
            }

            //3:渲染小米手机列表
            public function liebiao(){
                $user = Session::get('username');

                if( $user == null) {

                    $this->assign('res', '亲!请登录');
                    return $this->fetch('liebiao');

                }else{

                    $this->assign('res', $user);
                    return $this->fetch('liebiao');
                }

            }

            //4:渲染详情页
            public function xiangqing(){
                $user = Session::get('username');

                if( $user == null) {


                    $this->assign('res', '亲!请登录');
                    return $this->fetch('xiangqing');

                }else{

                    $id = input('id');

                    $danModel = new IndexModel();

                    $where = [

                        'id' => ['eq',$id]
                    ];
                    $xqRes = $danModel->xqselect($where);


                    $this->assign(
                        'shuju',$xqRes
                    );
                    $this->assign('res', $user);

                    return $this->fetch('xiangqing');
                }
            }

    }





?>