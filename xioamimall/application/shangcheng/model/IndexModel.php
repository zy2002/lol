<?php
namespace app\shangcheng\model;


use think\Model;
use think\Db;

    class  IndexModel extends Model
    {
        protected  $table = 'xiaomi_goods';

        //查询全部的明星单品
        public function selectitem($where)
        {

            return Db::name('goods')->where($where)->select();

        }


        //查询小米明星单品详情
        public function xqselect($where)
        {
            return Db::name('goods')->where($where)->select();
        }





    }


