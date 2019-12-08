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
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php $img = $model->getImage(); ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'category_id',
                'value' => $model->category->name,
            ],
            'name',
            'content:html',
            'price',
            'keywords',
            'description',
            [
                'attribute' => 'image',
                'value' => $img->getUrl() ? "<img src='{$img->getUrl()}'>" : '<span class="text-danger">Нет фото</span>',
                'format' => 'html',
            ],
            [
                'attribute' => 'hit',
                'value' => $model->hit ? '<span class="text-success">Да</span>' : '<span class="text-danger">Нет</span>',
                'format' => 'html',
            ],
            [
                'attribute' => 'new',
                'value' => $model->new ? '<span class="text-success">Да</span>' : '<span class="text-danger">Нет</span>',
                'format' => 'html',
            ],
            [
                'attribute' => 'sale',
                'value' => $model->sale ? '<span class="text-success">Да</span>' : '<span class="text-danger">Нет</span>',
                'format' => 'html',
            ],
        ],
    ]) ?>

</div>
