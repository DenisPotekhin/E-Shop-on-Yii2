<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Order */

$this->title = 'Заказ №: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

    <h1>Просмотр <?= Html::encode($this->title) ?></h1>

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
            'created_at',
            'updated_at',
 /*           [
                'attribute' => 'updated_at',
                'value' => function($model) {
                    $datetime = new DateTime("@$model->updated_at");
                    return $datetime->format('d-m-Y H:i:s');
                },
            ],
 */
            'qty',
            'sum',
            [
                'attribute' => 'status',
                'value' => !$model->status ? '<span class="text-danger">Активен</span>' : '<span class="text-success">Завершен</span>'
                ,
                'format' => 'html',
            ],
            //    'status',
            'name',
            'email:email',
            'phone',
            'address',
        ],
    ]) ?>

    <?php $items = $model->orderItems; ?>
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <td>Наименование</td>
                <td>Количество</td>
                <td>Цена</td>
                <td>Стоимость</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><a href="<?= Url::to(['/product/view', 'id' => $item->product_id]) ?>" ><?= $item['name'] ?></a></td>
                    <td><?= $item['qty_item'] ?></td>
                    <td><?= $item['price'] ?></td>
                    <td><?= $item['sum_item'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
