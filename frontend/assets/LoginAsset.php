<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/19
 * Time: 11:39
 */

namespace frontend\assets;

use yii\web\AssetBundle;
class LoginAsset extends AssetBundle{
    public $basePath = '@webroot';//静态资源的硬盘路径
    public $baseUrl = '@web';//静态资源的url路径
    //需要加载的css文件
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/login.css',
        'style/footer.css',
    ];
    public $js = [
    ];
    //和其他静态资源管理器的依赖关系
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}