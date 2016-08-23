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
        <?= Html::a(Html::encode($model->name), ['view', 'id' => $model->id]); ?>
    </h3>
    <div>
        <?= $model->content; ?>
    </div>
</div>