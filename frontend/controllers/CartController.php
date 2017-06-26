<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/23
 * Time: 16:10
 */
namespace frontend\controllers;
use backend\models\Goods;
use frontend\models\Area;
use frontend\models\Cart;
use frontend\models\Locations;
use frontend\models\Order;
use frontend\models\OrderGoods;
use yii\base\Model;
use yii\web\Controller;
use Yii;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;
use yii\web\Request;

class CartController extends Controller{
    public $layout='cart';
    public function actionIndex(){
        $cookies = Yii::$app->request->cookies;
        $cookie = $cookies->get('cart');
        if ($cookie == null) {
            //cookie中没有购物车数据
            $cart = [];
        } else {
            $cart = unserialize($cookie->value);
        }
        if(\Yii::$app->user->isGuest){
            $models = [];
            foreach ($cart as $goods_id=>$amount){
                    $goods=Goods::findOne(['id'=>$goods_id])->attributes;
                    $goods['amount']=$amount;
                    $models[]=$goods;
            }
        }else{
            $member_id=\Yii::$app->user->getId();
            foreach ($cart as  $goods_id => $amount){
                //实例化购物车对象，判断数据表是否有同样的商品
                $cartshop=Cart::findOne(['goods_id'=>$goods_id,'member_id'=>$member_id]);
                if($cartshop){
//                   echo 1;exit;
                    $cartshop->amount+=$amount;
                    $cartshop->save();
                }else{

                    $model=new Cart();
                    $model->goods_id=$goods_id;
                    $model->member_id=$member_id;
                    $model->amount=$amount;
                    $model->save();
                }

            }
            $cookies = \Yii::$app->response->cookies;
            $cookies->get('cart');
            $cookies->remove('cart');
            $models=[];
            $carts=Cart::find()->where(['member_id'=>\Yii::$app->user->getId()])->all();
//            var_dump($carts);exit;
            foreach ($carts as $cart){
//                var_dump($cart->goods_id);exit;
                $goods=Goods::findOne(['id'=>$cart->goods_id])->attributes;
//                var_dump($goods);exit;
                $goods['amount']=$cart->amount;
                $models[] = $goods;

            }

        }
        return $this->render('cart',['models'=>$models]);
    }
    public function actionAddCart(){
        $goods_id=\Yii::$app->request->post('goods_id');
        $amount=\Yii::$app->request->post('amount');
        $goods=Goods::findOne(['id'=>$goods_id]);
        if($goods==null){
          throw  new NotFoundHttpException('商品不存在');
        }
        //如果未登陆将数据保存到cookie
        if(\Yii::$app->user->isGuest){
            $cookies=\Yii::$app->request->cookies;
            $cookie=$cookies->get('cart');

            //判断该cookie是否有值
            if($cookie==null){
                $cart=[];//没值就初始化。防止报错
            }else{
                $cart=unserialize($cookie->value);//将获取到的cookie反序列化变成数组
            }
            if(key_exists($goods_id,$cart)){//判断购物车是否有该商品，有的话只在原来的基础上添加数量
                $cart[$goods_id]+=$amount;
            }else{
                $cart[$goods_id]=$amount;//没有该商品就添加数据
            }
            //将信息添加到cookie
            $cookies = Yii::$app->response->cookies;
            $cookie=new Cookie(
                ['name'=>'cart','value'=>serialize($cart)]
            );
            $cookies->add($cookie);
        }
        else{
             $member_id=\Yii::$app->user->getId();
            $cart=Cart::findOne(['member_id'=>$member_id,'goods_id'=>$goods_id]);
            if($cart){
//                    echo 1;exit;
                $cart->amount+=$amount;
                $cart->save();
            }else{
//                    echo 2;exit;
                $model=new Cart();
                $model->goods_id=$goods_id;
                $model->member_id=$member_id;
                $model->amount=$amount;


                $model->save();
            }

        }
        return $this->redirect(['cart/index']);


    }
    public function actionUpdateCart(){
        $goods_id=\Yii::$app->request->post('goods_id');
        $amount=\Yii::$app->request->post('amount');
        $goods=Goods::findOne(['id'=>$goods_id]);
        if($goods==null){
            throw  new NotFoundHttpException('商品不存在');
        }
        if(\Yii::$app->user->isGuest){
            $cookies = Yii::$app->request->cookies;
            $cookie = $cookies->get('cart');
            if($cookie == null){
                //cookie中没有购物车数据
                $cart = [];
            }else{
                $cart = unserialize($cookie->value);

            }
            $cookies = Yii::$app->response->cookies;
            if($amount){
                $cart[$goods_id]=$amount;
            }else{
               if(key_exists($goods->id,$cart)) unset($cart[$goods_id]);
            }

            $cookie=new Cookie(
                ['name'=>'cart','value'=>serialize($cart)]
            );
            $cookies->add($cookie);

        }else{
            $member_id=\Yii::$app->user->getId();

            //操作数据库
            $cart=Cart::findOne(['member_id'=>$member_id,'goods_id'=>$goods_id]);
            if($amount==0){
                Cart::findOne(['goods_id'=>$goods_id])->delete();
            }
            $cart->amount=$amount;
            $cart->save();
        }
    }
    public function actionOrder(){
        $this->layout='order';
        if(\Yii::$app->user->isGuest){
          return $this->redirect(['user/login']);
        }else {
            $carts=Cart::findAll(['member_id'=>\Yii::$app->user->getId()]);
            $address=Area::findAll(['member_id'=>\Yii::$app->user->getId()]);
            $order=new Order();
            $models=[];
            foreach ($carts as $cart){
//                var_dump($cart->goods_id);exit;
                $goods=Goods::findOne(['id'=>$cart->goods_id])->attributes;
//                var_dump($goods);exit;
                $goods['amount']=$cart->amount;
                $models[] = $goods;

            }
            $request=new Request();
            if($request->isPost){
                $address_id=$request->post('address_id');
                $delivery_id=$request->post('delivery_id');
                $payment_id=$request->post('payment_id');
                $price=$request->post('price');
                $addresss=Area::findOne(['id'=>$address_id]);
                $deliverys=null;
                $payments=null;
                foreach (Order::$delivery as $delivere){
                    if($delivere['delivery_id']==$delivery_id){
                        $deliverys=$delivere;
                    }
                }
                foreach (Order::$payment as $paymen){
                    if($paymen['payment_id']==$payment_id){
                        $payments=$paymen;
                    }
                }
                $order->member_id=\Yii::$app->user->getId();
                $order->payment_id=$payment_id;
                $order->payment_name=$payments['payment_name'];
                $order->name=$addresss['user_name'];
                $order->province=Locations::getArea($addresss['province']);
                $order->city=Locations::getArea($addresss['city']);
                $order->area=Locations::getArea($addresss['district']);
                $order->address=$addresss['content'];
                $order->tel=$addresss['tel'];
                $order->delivery_id=$delivery_id;
                $order->delivery_name=$deliverys['delivery_name'];
                $order->delivery_price=$deliverys['delivery_price'];
                $order->total=$price;
                $order->status=1;
                $order->create_time=time();
                $order->save();
                foreach ($models as $model){
                    $order_goods=new OrderGoods();
                    $order_goods->order_id=$order->id;
                    $order_goods->goods_id=$model['id'];
                    $order_goods->goods_name=$model['name'];
                    $order_goods->logo=$model['logo'];
                    $order_goods->price=$model['shop_price'];
                    $order_goods->total=($model['shop_price']*$model['amount']);
                    $order_goods->save();
                }
                foreach ($carts as $cart){
                    $cart->delete();
                }

            }
            return $this->render('order',['models'=>$models,'address'=>$address]);
        }

    }
    public function actionOrderTrue(){
        $this->layout='true';
        return $this->render('true');
    }
    public function actionOrderList(){
        $this->layout='address';
        $orders=Order::findAll(['member_id'=>\Yii::$app->user->getId()]);

        return $this->render('list',['orders'=>$orders]);
    }

}