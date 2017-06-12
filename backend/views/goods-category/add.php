<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/11
 * Time: 14:17
 * /**
 * @var $this \yii\web\View
 */

$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'parent_id')->hiddenInput(['id'=>'partent_Node']);
echo '<ul id="treeDemo" class="ztree"></ul>';
echo $form->field($model,'intro')->textarea();

echo \yii\helpers\Html::submitButton('添加分类',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
$this->registerCssFile('@web/zTree/css/zTreeStyle/zTreeStyle.css');
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
$zNode=\yii\helpers\Json::encode($categories);
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
              $('#partent_Node').val(treeNode.id);
            }
        }
   };
   // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
   var zNodes = {$zNode};
   zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
   //展开所有节点
   zTreeObj.expandAll(true);
   //获取当前id的父节点
   var node=zTreeObj.getNodeByParam("id",$("#partent_Node").val(),null);

   //选择当前节点的父节点
   zTreeObj.selectNode(node);
   
   

JS

);
$this->registerJs($js);
?>
