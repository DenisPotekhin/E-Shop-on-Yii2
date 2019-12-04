<?php


namespace app\controllers;

use app\models\Cart;
use app\models\Order;
use app\models\OrderItems;
use app\models\Product;
use Yii;

class CartController extends AppController
{
    public function actionAdd() {
       $id = Yii::$app->request->get('id');
       $qty = (int)Yii::$app->request->get('qty');
       $qty = !$qty ? 1 : $qty;
       $product = Product::findOne($id);
       if (empty($product)) return false;
       $session = Yii::$app->session;
       $session->open();
       $cart = new Cart();
       $cart->addToCart($product, $qty);
       if (! Yii::$app->request->isAjax) {
           return $this->redirect(Yii::$app->request->referrer);
       }
       $this->layout = false;
       return $this->render('cart-modal', compact('session'));
    }

    public function actionClear() {
        $session = Yii::$app->session;
        $session->open();
        $session->remove('cart');
        $session->remove('cart.qty');
        $session->remove('cart.sum');
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionDelItem() {
        $id = Yii::$app->request->get('id');
        $session = Yii::$app->session;
        $session->open();
        $cart = new Cart();
        $cart->recalc($id);
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionShow() {
        $session = Yii::$app->session;
        $session->open();
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionView() {
        $session = Yii::$app->session;
        $session->open();
        $this->setMeta('Cart');
        $order = new Order();
        if ( $order->load(Yii::$app->request->post())) {
            $order->qty = $session['cart.qty'];
            $order->sum = $session['cart.sum'];
            if ($order->save()) {
                $this->saveOrderItems($session['cart'], $order->id);
                Yii::$app->session->setFlash('success', 'Ваш заказ сохранен!');
                Yii::$app->mailer->compose('order', ['session' => $session])
                    ->setFrom(['eshop-test@mail.ru' => 'E-Shop'])
                    ->setTo($order->email)
                    ->setSubject('Заказ с сайта E-Shop')
                    ->send();
                Yii::$app->mailer->compose('order', ['session' => $session])
                    ->setFrom(['eshop-test@mail.ru' => 'E-Shop'])
                    ->setTo(Yii::$app->params['adminEmail'])
                    ->setSubject('Заказ клиента!')
                    ->send();
                $session->remove('cart');
                $session->remove('cart.qty');
                $session->remove('cart.sum');
                return Yii::$app->getResponse()->refresh(); // instead $this->>refresh();
            } else {
                Yii::$app->session->setFlash('error', 'Что-то пошло не так!');
            }
        }
        return $this->render('view', compact('session', 'order'));
    }

    protected function saveOrderItems($items, $orderId) {
        foreach ($items as $id => $item) {
            $orderItems = new OrderItems();
            $orderItems->order_id = $orderId;
            $orderItems->product_id = $id;
            $orderItems->name = $item['name'];
            $orderItems->price = $item['price'];
            $orderItems->qty_item = $item['qty'];
            $orderItems->sum_item = $item['price'] * $item['qty'];
            $orderItems->save();
        }
    }
}