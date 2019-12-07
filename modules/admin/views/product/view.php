<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'category_id',
                'value' => $model->category->name,
            ],
            'name',
            'content:ntext',
            'price',
            'keywords',
            'description',
            'img',
            [
                'attribute' => 'hit',
                'value' => $model->hit ? '<span class="text-danger">Да</span>' : '<span class="text-success">Нет</span>',
                'format' => 'html',
            ],
            [
                'attribute' => 'new',
                'value' => $model->new ? '<span class="text-danger">Да</span>' : '<span class="text-success">Нет</span>',
                'format' => 'html',
            ],
            [
                'attribute' => 'sale',
                'value' => $model->sale ? '<span class="text-danger">Да</span>' : '<span class="text-success">Нет</span>',
                'format' => 'html',
            ],
        ],
    ]) ?>

</div>
