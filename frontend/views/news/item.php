<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $index integer */
/* @var $widget yii\widgets\ListView */

?>

<div>
    <h3>
        <?= Html::encode($model->name); ?>
    </h3>
    <div class="panel panel-default">
        <div class="panel-heading">
            <?= \Yii::$app->formatter->asDate($model->publication_date); ?>
            <?= $model->subject->name; ?>
        </div>
        <div class="panel-body">
            <?= mb_strimwidth($model->content, 0, 256, '...', 'UTF-8'); ?>
            <?= Html::a('Читать далее', ['view', 'id' => $model->id]); ?>
        </div>
    </div>
</div>