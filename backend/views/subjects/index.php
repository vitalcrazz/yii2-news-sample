<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Темы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subjects-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать тему', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php if($message) {
        echo yii\bootstrap\Alert::widget([
            'options' => [
                'class' => 'alert-warning',
            ],
            'body' => $message,
        ]);
    } ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
