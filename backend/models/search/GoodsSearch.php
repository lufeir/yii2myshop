<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/12
 * Time: 19:35
 */
namespace backend\models\search;
use backend\models\Goods;
use backend\models\GoodsCategory;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class GoodsSearch extends Goods
{
    //public $cname;//文章类别名

    /**
     * @inheritdoc
     */
    public function getCategory(){
        return $this->hasOne(GoodsCategory::className(),['id'=>'goods_category_id']);
    }
    public function rules()
    {
        return [
            [['goods_category_id', 'stock', 'brand_id', 'is_on_sale', 'sort', 'create_time', 'status'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
            [['name'], 'string', 'max' => 20],
            [['sn', 'logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    //搜索
    public function search($params)
    {
        $query = Goods::find();
        // $query->joinWith(['cate']);//关联文章类别表
        // $query->joinWith(['author' => function($query) { $query->from(['author' => 'users']); }]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 2,
            ],
        ]);
        // 从参数的数据中加载过滤条件，并验证
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // 增加过滤条件来调整查询对象
//        $query->andFilterWhere([
//            // 'cname' => $this->cate.cname,
//            'name' => $this->name,
//           'sn' => $this->sn,
//        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'sn', $this->sn]) ;
        $query->andFilterWhere(['>=', 'market_prcie', $this->market_price]) ;
        $query->andFilterWhere(['<=', 'shop_prcie', $this->shop_price]) ;

        return $dataProvider;
    }
}

