<?php

namespace frontend\widgets;

use common\models\News;
use common\models\Subjects;
use Yii;
use yii\helpers\Html;

class SubjectsList extends \yii\base\Widget
{
    public function init()
    {
        parent::init();

        $models = Subjects::find()
            ->orderBy('name')
            ->all();

        if(count($models) > 0) {
            $this->renderModels($models);
        }
        else {
            $this->renderEmpty();
        }
    }

    protected function renderModels($models)
    {
        $content = '';
        foreach ($models as $model) {
            $count = News::find()
                ->where(['subject_id' => $model->id])
                ->count();

            $itemContent = Html::tag('span', $count, ['class' => 'badge']) . $model->name;
            $content .= Html::a($itemContent, ['/news/index', 'subject' => $model->id], ['class' => 'list-group-item']);
        }

        echo Html::tag('div', $content, ['class' => 'list-group']);
    }

    protected function renderEmpty()
    {
        echo '(Нет тем)';
    }
}
