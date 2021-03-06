<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if(Yii::$app->getUser()->can('updateProduct')) : ?>
            <?= Html::a(
                Yii::t('app', 'Update'),
                ['update', 'id' => $model->id],
                ['class' => 'btn btn-primary']
            ) ?>
        <?php endif; ?>
        <?php if(
            Yii::$app->getUser()->can('deleteProduct') ||
            Yii::$app->getUser()->can('deleteOwnProduct', [
                'product' => $model
            ])
        ) : ?>
            <?= Html::a(
                Yii::t('app', 'Delete'),
                ['delete', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ]
                ]
            ) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'price',
            'author_id',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
