<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/18
 * Time: 11:07
 */
namespace backend\widgets;
use backend\models\Menu;
use yii\bootstrap\Widget;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use Yii;

class MenWidget extends Widget{
    public function init()
    {
        parent::init();
    }
    public function run()
    {
        NavBar::begin([
            'brandLabel' => '商城管理系统',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        $menuItems = [
            ['label' => '主页', 'url' => ['/user/index']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => '登录', 'url' =>\Yii::$app->user->loginUrl];
        } else {
            $menuItems[] = ['label' => '注销('.Yii::$app->user->identity->username.')', 'url' =>['user/logout']];
             $menus=Menu::findAll(['parent_id'=>0]);
             foreach ($menus as $menu){
                 $items=['label'=>$menu->label,'items'=>[]];
                 foreach ($menu->children as $child){
                     if(\Yii::$app->user->can($child->url)){
                         $items['items'][]=['label'=>$child->label,'url'=>[$child->url]];
                     }

                 }

                 if(!empty($items['items'])){
                   $menuItems[]=$items;
                 }

             }

        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
    }
}