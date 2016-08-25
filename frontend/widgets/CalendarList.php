<?php

namespace frontend\widgets;

use Yii;

/**
 * Renders a list group for the months and years list
 *
 * @package frontend\widgets
 */
class CalendarList extends \frontend\widgets\ListGroup
{
    /**
     * @inheritdoc
     */
    protected function renderModels()
    {
        $year = 0;
        $content = '';
        foreach ($this->models as $item) {
            if($year !== $item['year']) {
                $year = $item['year'];
                $content .= $this->renderItem($year, ['/news/index', 'year' => $year]);
            }

            $date = new \DateTime();
            $date->setDate($year, $item['month'], 1);
            $monthName = Yii::$app->formatter->asDate($date, 'LLLL');

            $url = $this->createUrl($item);
            $content .= $this->renderItem($monthName, $url, $item['count']);
        }

        return $content;
    }

    /**
     * @inheritdoc
     */
    protected function createUrl($model)
    {
        return ['/news/index', 'year' => $model['year'], 'month' => $model['month']];
    }
}
