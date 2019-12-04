<?php


namespace app\controllers;

use app\models\Product;
use Yii;

class ProductController extends AppController
{
    public function actionIndex() {

    }

    public function actionView() {
        $id = Yii::$app->request->get('id');
        $product = Product::findOne($id);
        if(empty($product))
            throw new \yii\web\HttpException(404, 'Выбранного товара не существует');

        $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();
        //Вариант для жадной загрузки
        //$product = Product::find()->with('category')->where(['id' => $id])->limit('1')->one();
        $this->setMeta('E-Shop | ' . $product->name, $product->keywords, $product->description);
        return $this->render('view', compact('product', 'hits'));
    }
}