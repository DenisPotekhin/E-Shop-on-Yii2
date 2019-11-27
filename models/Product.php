<?php

namespace app\models;

use yii\db\ActiveRecord;

class Product extends ActiveRecord
{
  public function getCategory() {
    return $this->hasOne(Category::className(), ['id' => 'category_id']);
  }
}
