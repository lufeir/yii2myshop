<h1><?=$model->name?></h1>
<h5 ">创建时间：<?=date('Y-m-d H:i:s',$model->create_time)?>所属分类：<?=$model->category->name?></h5>

<?=$content->content?>