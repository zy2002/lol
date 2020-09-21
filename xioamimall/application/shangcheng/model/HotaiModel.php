<?php
namespace app\shangcheng\model;

use think\Model;
use think\Db;

    class HotaiModel extends Model
    {

        protected  $table = 'xiaomi_scld';


        //查询省
        public function chasheng($fiele)
        {

            return Db::name('scld')->where($fiele)->select();

        }

        //add添加地址
        public function adddizhi($data)
        {


            return Db::table('xiaomi_dizhi')->insert($data);


        }

        //查询地址
        public function selectdizhi()
        {
            return Db::table('xiaomi_dizhi')->select();

        }

        //删除地址
        public function deletedizhis($s){

            return Db::table('xiaomi_dizhi')->delete($s);

        }


    }


