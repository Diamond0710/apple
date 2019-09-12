<?php

namespace backend\controllers;

use Yii;
use backend\models\Product;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ProductController implements the CRUD actions for Products model.
 */
class ProductController extends Controller
{

    public function actionUpdate()
    {
        $request = Yii::$app->request->post();

        foreach ($request['Product'] as $product) {
            $model = $this->findModel($product['id']);
            if($model->notRotten()) {
                if($product['fall'] && ($model->status ==  Product::STATUS_NEW)) {
                    $model->status = Product::STATUS_FALL;
                    $rotten_at = strtotime(Product::FALL_TIME, strtotime(date('Y-m-d H:i:s')));
                    $model->rotten_at = $rotten_at;
                }
                if($model->status == Product::STATUS_FALL) {
                    $size = $this->getSize($product['eating_percent']);
                    if($size < $model->size) {
                        $model->size = $size;
                    }
                }
                $model->save();
            }
        }

        return $this->redirect(['site/index']);
    }
    public function actionGenerate()
    {
        Product::deleteAll();
        Product::createProducts();
        return $this->redirect(['site/index']);
    }

    protected function getSize($eating) {
        return 100 - (int)$eating;
    }

    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
