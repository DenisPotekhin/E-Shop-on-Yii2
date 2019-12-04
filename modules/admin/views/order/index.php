<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'email:email',
            'phone',
            'qty',
            'sum',
            [
                'attribute' => 'status',
                'value' => function($data) {
                    return !$data->status ? '<span class="text-danger">Активен</span>' : '<span class="text-success">Завершен</span>';
                },
                'format' => 'html',
            ],
            //'status',
            [
                'attribute' => 'created_at',
                'value' => function($data) {
                    $datetime = new DateTime("@$data->created_at");
                    return $datetime->format('d-m-Y H:i:s');
                },
            ],
            [
                'attribute' => 'updated_at',
                'value' => function($data) {
                    $datetime = new DateTime("@$data->updated_at");
                    return $datetime->format('d-m-Y H:i:s');
                },
            ],

            //'address',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
