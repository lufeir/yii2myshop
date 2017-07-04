<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/7/3
 * Time: 14:55
 */
namespace frontend\controllers;
use backend\models\Goods;
use EasyWeChat\Message\News;
use frontend\models\Member;
use frontend\models\Order;
use yii\helpers\Url;
use yii\web\Controller;
use EasyWeChat\Foundation\Application;

class  WechatController extends Controller{
    public $enableCsrfValidation = false;
    public function actionIndex(){

        $app = new Application(\Yii::$app->params['wechat']);
        $app->server->setMessageHandler(function ($message){
            $weathers=simplexml_load_file('http://flash.weather.com.cn/wmaps/xml/sichuan.xml');
            foreach ($weathers as $weather){
                if($weather['cityname']=='成都'){
                    $weathercontent=file_get_contents('https://free-api.heweather.com/v5/weather?city='.$weather['cityname'].'&key=27f142c62c224ba2b17923b563dff560');
                    $Arr=json_decode($weathercontent,true);
                    $chuanyi=$Arr['HeWeather5'][0]['suggestion']['drsg']['txt'];
                    $code=$Arr['HeWeather5'][0]['now']['cond']['code'];
                    $Content= $weather['cityname'].'天气情况：'.$weather['stateDetailed'].',   '.'最低温度：'.$weather['tem1'].'度,   '.'最高温度：'.$weather['tem2'].'度,   '.'实时温度:'.$weather['temNow'].'度,   '.'  穿衣指数：'.$chuanyi;
                }

            }
            switch ($message->MsgType){
                case 'text':
                    switch ($message->Content){
                        case '成都':
                            $news1 = new News([
                                'title'       => '成都天气情况',
                                'description' =>$Content,
                                'url'         => 'https://www.baidu.com/link?url=Zku0f6LC3-k83jm9wp7m99Ifsj21ZfZyXaepdTeO8hwaaEWixNMhAHDETvBSAl4AEpdYU5dGHu5VXdDNVb9Yba&wd=&eqid=9e1aafd20000349d00000006595a1bf2',//
                                'image'       => 'https://cdn.heweather.com/cond_icon/'.$code.'.png',
                            ]);
                            return $news1;
                            break;
                        case '注册':
                            $url=Url::to(['user/register'],true);
                            return '点此注册'.$url;
                            break;
                        case '活动':
                            $news1 = new News([
                                'title'       => '双十一大促销',
                                'description' =>'双十一大促销，不买不是人',
                                'url'         => 'https://www.baidu.com/link?url=Zku0f6LC3-k83jm9wp7m99Ifsj21ZfZyXaepdTeO8hwaaEWixNMhAHDETvBSAl4AEpdYU5dGHu5VXdDNVb9Yba&wd=&eqid=9e1aafd20000349d00000006595a1bf2',//
                                'image'       => 'http://img4.imgtn.bdimg.com/it/u=1237874748,988916812&fm=26&gp=0.jpg',
                            ]);
                            $news2 = new News([
                                'title'       => '王者荣耀皮肤大降价',
                                'description' =>'王者荣耀皮肤大降价，不买不是人',
                                'url'         => 'https://www.baidu.com/link?url=Zku0f6LC3-k83jm9wp7m99Ifsj21ZfZyXaepdTeO8hwaaEWixNMhAHDETvBSAl4AEpdYU5dGHu5VXdDNVb9Yba&wd=&eqid=9e1aafd20000349d00000006595a1bf2',//
                                'image'       => 'http://img3.imgtn.bdimg.com/it/u=3859233699,3282498598&fm=26&gp=0.jpg',
                            ]);
                            $news3 = new News([
                                'title'       => '成都天气情况',
                                'description' =>'成都天气看心情',
                                'url'         => 'https://www.baidu.com/link?url=Zku0f6LC3-k83jm9wp7m99Ifsj21ZfZyXaepdTeO8hwaaEWixNMhAHDETvBSAl4AEpdYU5dGHu5VXdDNVb9Yba&wd=&eqid=9e1aafd20000349d00000006595a1bf2',//
                                'image'       => 'http://img2.imgtn.bdimg.com/it/u=2707423053,1088453999&fm=26&gp=0.jpg',
                            ]);
                            return [$news1,$news2,$news3];
                            break;
                    }
                case 'event':
                    if($message->Event == 'CLICK'){
                        if($message->EventKey='zxhd'){
                            $news1 = new News([
                                'title'       => '新飞冰箱大降价',
                                'description' =>'新飞冰箱大降价',
                                'url'         => 'http://www.lizhengyu.xin/address/content.html?id=21',//
                                'image'       => 'http://www.lizhengyu.xin/images/relate_view1.jpg',
                            ]);
                            $news2 = new News([
                                'title'       => '海尔11111111冰箱大降价',
                                'description' =>'海尔11111111冰箱大降价',
                                'url'         => 'http://www.lizhengyu.xin/address/content.html?id=20',//
                                'image'       => 'http://www.lizhengyu.xin/images/relate_view2.jpg',
                            ]);
                            $news3 = new News([
                                'title'       => '海澜之家衬衣大降价',
                                'description' =>'海澜之家衬衣大降价',
                                'url'         => 'http://www.lizhengyu.xin/address/content.html?id=22',//
                                'image'       => 'http://www.lizhengyu.xin/images/relate_view3.jpg',
                            ]);
                            $news4 = new News([
                                'title'       => '新飞冰箱大降价',
                                'description' =>'新飞冰箱大降价',
                                'url'         => 'http://www.lizhengyu.xin/address/content.html?id=21',//
                                'image'       => 'http://www.lizhengyu.xin/images/relate_view1.jpg',
                            ]);
                            $news5 = new News([
                                'title'       => '新飞冰箱大降价',
                                'description' =>'新飞冰箱大降价',
                                'url'         => 'http://www.lizhengyu.xin/address/content.html?id=21',//
                                'image'       => 'http://www.lizhengyu.xin/images/relate_view1.jpg',
                            ]);
                            return [$news1,$news2,$news3,$news4,$news5];
                            break;
                        }
                    }



            }
        });
// 将响应输出
        $response = $app->server->serve();
        $response->send(); // Laravel 里请使用：return $response;
    }
    public function actionSetMenu(){
        $app = new Application(\Yii::$app->params['wechat']);
        $menu = $app->menu;
        $buttons = [
            [
                "type" => "click",
                "name" => "促销商品",
                "key"  => "zxhd"
            ],
            [
                "type" => "view",
                "name" => "在线商城",
                "url"  => Url::to(['goods/index'],true)
            ],
            [
                "name"       => "个人中心",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "收货地址",
                        "url"  => Url::to(['wechat/user'],true)
                    ],
                    [
                        "type" => "view",
                        "name" => "我的订单",
                        "url"  => Url::to(['wechat/order'],true)
                    ],
                    [
                        "type" => "view",
                        "name" => "绑定账户",
                        "url" => Url::to(['wechat/login'],true)
                    ],
                    [
                        "type" => "view",
                        "name" => "修改密码",
                        "url" => Url::to(['wechat/upwd'],true)
                    ],
                ],
            ],
        ];
        $menu->add($buttons);
        //获取已设置的菜单（查询菜单）
        $menus = $menu->all();
        var_dump($menus);

    }
    public function actionOrder(){
        $openid=\Yii::$app->session->get('openid');//获取session的openid
        if($openid==null){
            //如果不存在。发起授权
            \Yii::$app->session->set('redirect',\Yii::$app->controller->action->uniqueId);
            $app = new Application(\Yii::$app->params['wechat']);
            $response=$app->oauth->scopes(['snsapi_base'])
                ->redirect();
            $response->send();
        }
        $member = Member::findOne(['openid'=>$openid]);
        if($member == null){
            //该openid没有绑定任何账户
            //引导用户绑定账户
            return $this->redirect(['wechat/login']);
        }else{
            $orders=Order::findAll(['member_id'=>$member->id]);
            if($orders==null){
                echo '没有该订单信息';exit;
            }
            return $this->renderPartial('order',['orders'=>$orders]);

        }
    }
    public function actionCallback(){
        $app = new Application(\Yii::$app->params['wechat']);
        $user=$app->oauth->user();
        \Yii::$app->session->set('openid',$user->getId());
        return $this->redirect([\Yii::$app->session->get('redirect')]);
    }
    public function actionLogin(){
      $openid=\Yii::$app->session->get('openid');//获取session的openid
      if($openid==null){
          //如果不存在。发起授权
          \Yii::$app->session->set('redirect',\Yii::$app->controller->action->uniqueId);
          $app = new Application(\Yii::$app->params['wechat']);
          $response=$app->oauth->scopes(['snsapi_base'])
              ->redirect();
          $response->send();
      }
      $request=\Yii::$app->request;
      if($request->isPost){
          $user=Member::findOne(['username'=>$request->post('username')]);
          if($user && \Yii::$app->security->validatePassword($request->post('password'),$user->password_hash)){
              //如果用户登录成功，将openid写入用户信息中
              \Yii::$app->user->login($user);
              Member::updateAll(['openid'=>$openid],'id='.$user->id);
//              if(\Yii::$app->session->get('redirect')) return $this->redirect(\Yii::$app->session->get('redirect'));
              echo '绑定成功';exit;
          }
          else{
              echo '绑定失败';exit;
          }
      }
      return $this->renderPartial('login');
    }
}

