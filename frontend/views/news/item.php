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
    <div>
        <?= mb_strimwidth($model->content, 0, 256, '...', 'UTF-8'); ?>
        <?= Html::a('Читать далее', ['view', 'id' => $model->id]); ?>
    </div>
</div>