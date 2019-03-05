<?php

use app\models\Product;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php if (Yii::$app->getUser()->can('addProduct')) : ?>
            <?= Html::a(
                Yii::t('app', 'Create Product'),
                ['create'],
                ['class' => 'btn btn-success']
            ) ?>
        <?php endif; ?>
        <?php if (Yii::$app->getUser()->can('exportProducts')) : ?>
            <?= Html::a(
                Yii::t('app', 'Export to XLSX'),
                ['export'],
                ['class' => 'btn btn-primary']
            ) ?>
        <?php endif; ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'title',
            'price',
            [
                'attribute' => 'author_id',
                'label' => Yii::t('app', 'Author'),
                'value' => 'author.name'
            ],
            'created_at:datetime',
            'updated_at:datetime',

            [
                'class' => ActionColumn::class,
                'visibleButtons' => [
                    'view' => Yii::$app->getUser()->can('viewProduct'),
                    'update' => Yii::$app->getUser()->can('updateProduct'),
                    'delete' => function (Product $product) {
                        return Yii::$app->getUser()->can('deleteProduct') ||
                        Yii::$app->getUser()->can('deleteOwnProduct', [
                            'product' => $product
                        ]);
                    }
                ]
            ]
        ]
    ]); ?>
</div>
