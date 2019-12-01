<?php


namespace app\controllers;

use app\models\Category;
use app\models\Product;
use Yii;

class ProductController extends AppController
{
    public function actionIndex() {

    }

    public function actionView() {
        $id = Yii::$app->request->get('id');
        $product = Product::findOne($id);
        //Вариант для жадной загрузки
        //$product = Product::find()->with('category')->where(['id' => $id])->limit('1')->one();

        return $this->render('view', compact('product'));
    }
}