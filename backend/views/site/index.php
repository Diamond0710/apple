<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

use backend\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm; ?>

<div class="site-index">

    <div class="body-content">

        <div class="pt-2">
            <?= Html::a('generate apples', ['product/generate'], ['class' => 'btn btn-success']) ?>
        </div>

        <?php $form = ActiveForm::begin(['action' => Url::to(['product/update'])]); ?>

        <div class="row">

            <?php foreach($products as $key => $model): ?>

                <div class="col-lg-2 text-center p-5">

                    <div class="fa fa-apple-alt fa-5x" style="color: <?='#'.$model->color?>"></div>

                    <div>Size: <?=$model->size.'&percnt;'?></div>
                    <div>Status: <?=$model->getStatus()?></div>

                    <?= $form->field($model, "[{$key}]id")->hiddenInput()->label(false) ?>

                    <?php if($model->notRotten()): ?>

                        <?php if ($model->status == Product::STATUS_NEW): ?>
                            <?= $form->field($model, "[{$key}]fall")->checkbox(['class' => 'select-status']) ?>
                        <?php endif; ?>

                        <span style="<?=($model->status == Product::STATUS_FALL)?'':'display:none'?>">
                            <?= $form->field($model, "[{$key}]eating_percent")->textInput(['type' => 'number']) ?>
                        </span>

                    <?php endif; ?>

                </div>
            <?php endforeach;?>

        </div>

        <div class="form-group text-center">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>

<style>
    .row {
        display: flex;
        flex-wrap: wrap;
    }
    .pt-2 {
        padding-bottom: 20px;
    }
</style>
