<?php


namespace app\controllers;

use app\models\Category;
use app\models\Product;
use Yii;
use yii\data\Pagination;
use yii\web\HttpException;

class CategoryController extends AppController
{
    public function actionIndex() {
        $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();
        $this->setMeta('E-Shop');
        return $this->render('index', compact('hits'));
    }

    public function actionView() {
        $id = Yii::$app->request->get('id');
        $category = Category::findOne($id);
        if(empty($category))
            throw new HttpException(404, 'The selected category does not exist!');
        $query = Product::find()->where(['category_id' => $id]);
        $pages = new Pagination(['totalCount' => $query->count(),
            'pageSize' => 2,
            'forcePageParam' => FALSE,
            'pageSizeParam' => FALSE]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        $this->setMeta('E-Shop | ' . $category->name, $category->keywords, $category->description);
        return $this->render('view', compact('products', 'pages', 'category'));
    }

    public function actionSearch() {
        $q = trim(Yii::$app->request->get('q'));
        $this->setMeta('E-Shop | Search: ' . $q);
        if (!$q)
            return $this->render('search');
        $query = Product::find()->where(['like', 'name', $q]);
        $pages = new Pagination(['totalCount' => $query->count(),
            'pageSize' => 2,
            'forcePageParam' => FALSE,
            'pageSizeParam' => FALSE]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('search', compact('products', 'pages', 'q'));
    }
}