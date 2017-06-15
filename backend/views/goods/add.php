<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/12
 * Time: 11:27
 *  * @var $this \yii\web\View
 */
use yii\web\JsExpression;
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'market_price');
echo $form->field($model,'goods_category_id')->hiddenInput(['id'=>'category_Node']);
echo '<ul id="treeDemo" class="ztree"></ul>';
echo $form->field($model,'shop_price');
echo $form->field($model,'stock');
echo $form->field($model,'brand_id')->dropDownList(\yii\helpers\ArrayHelper::map($brand,'id','name'),['prompt' => '请选择品牌']);

echo $form->field($model,'is_on_sale',['inline'=>true])->radioList([1=>'在售',0=>'下架']);
echo $form->field($model,'status',['inline'=>true])->radioList(['1'=>'正常',0=>'回收站']);
echo $form->field($model,'sort')->textInput();
echo $form->field($model,'logo')->hiddenInput(['id'=>'logo_id']);
echo \yii\bootstrap\Html::fileInput('test', NULL, ['id' => 'test']);

echo \xj\uploadify\Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 120,
        'height' => 40,
        'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        console.log(data.fileUrl);
        $('#img_logo').attr('src',data.fileUrl).show();
        $('#logo_id').val(data.fileUrl);
    }
}
EOF
        ),
    ]
]);
if($model->logo){
    echo \yii\helpers\Html::img($model->logo,['id'=>'logo','width'=>50]);
}else{
    echo \yii\helpers\Html::img('',['style'=>'display:none','id'=>'img_logo','width'=>50]);
}
echo '<ul id="treeDemo" class="ztree"></ul>';
echo $form->field($content,'content')->widget(\crazyfd\ueditor\Ueditor::className(),[]);
echo \yii\helpers\Html::submitButton('提交',['class'=>'btn  btn-info']);

\yii\bootstrap\ActiveForm::end();
$this->registerCssFile('@web/zTree/css/zTreeStyle/zTreeStyle.css');
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
$zNode=\yii\helpers\Json::encode($GoodsCategory);
$js=new \yii\web\JsExpression(
     <<<JS
    var zTreeObj;
   // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
   var setting = {
        data: {
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "parent_id",
                rootPId: 0
            }
        },
        callback:{
            onClick:function(event, treeId, treeNode) {
              $('#category_Node').val(treeNode.id);
              console.debug(treeNode.id);
            }
        }
   };
   // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
   var zNodes = {$zNode};
   zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
   //展开所有节点
   zTreeObj.expandAll(true);
   //获取当前id的父节点
   var node=zTreeObj.getNodeByParam("id",$("#category_Node").val(),null);

   //选择当前节点的父节点
   zTreeObj.selectNode(node);
   
   

JS

);
$this->registerJs($js);