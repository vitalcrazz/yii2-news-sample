<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\News */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="panel panel-default">
        <div class="panel-heading">
            <?= \Yii::$app->formatter->asDate($model->publication_date); ?>
            <?= $model->subject->name; ?>
        </div>
        <div class="panel-body">
            <?= \Yii::$app->formatter->asNtext($model->content); ?>
        </div>
    </div>
    <div class="pull-right">
        <?= Html::a('Все новости', ['/news/index']); ?>
    </div>

</div>
