<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/8
 * Time: 15:18
 */
namespace backend\models;
use yii\db\ActiveRecord;

class Brand extends ActiveRecord{

    public function rules()
    {
        return[
            [['name','intro'],'required'],
            [['sort','status'],'integer'],
            ['logo','string']

        ];
    }
    public function attributeLabels()
    {
        return [
            'name'=>'品牌名称',
            'intro'=>'介绍',
            'sort'=>'排序',
            'logo'=>'LOGO',
            'status'=>'状态',
        ];
    }
}