<?php

namespace frontend\widgets;

use Yii;
use yii\helpers\Html;
use yii\db\Expression;

class CalendarList extends \yii\base\Widget
{
    public function init()
    {
        parent::init();

        $months = (new \yii\db\Query())
            ->select(new Expression('YEAR(publication_date) AS year, MONTH(publication_date) AS month, COUNT(*) AS count'))
            ->from('{{%news}}')
            ->groupBy(new Expression('YEAR(publication_date), MONTH(publication_date)'))
            ->orderBy(['year' => SORT_DESC, 'month' => SORT_DESC])
            ->all();

        if(count($months) > 0) {
            $this->renderModels($months);
        }
        else {
            $this->renderEmpty();
        }
    }

    protected function renderModels($models)
    {
        $year = 0;
        $content = '';
        foreach ($models as $item) {
            if($year !== $item['year']) {
                $year = $item['year'];
                $content .= Html::a($year, ['/news/index', 'year' => $year], ['class' => 'list-group-item year-group-item']);
            }

            $date = new \DateTime();
            $date->setDate($year, $item['month'], 1);
            $monthName = Yii::$app->formatter->asDate($date, 'LLLL');

            $badge = Html::tag('span', $item['count'], ['class' => 'badge']);
            $itemContent = $badge . $monthName;

            $url = ['/news/index', 'year' => $year, 'month' => $item['month']];
            $content .= Html::a($itemContent, $url, ['class' => 'list-group-item month-group-item']);
        }

        echo Html::tag('div', $content, ['class' => 'list-group']);
    }

    protected function renderEmpty()
    {
        echo '(Нет новостей)';
    }
}
