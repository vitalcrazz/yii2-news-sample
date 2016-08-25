<?php

namespace frontend\widgets;

use Yii;
use yii\helpers\Html;

/**
 * Renders the Bootstrap's component `List group` with badges and linked items
 *
 * @package frontend\widgets
 */
class ListGroup extends \yii\base\Widget
{
    /**
     * @var array input data to be rendered in the list group
     */
    public $models;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if(count($this->models) > 0) {
            $content = $this->renderModels();
            echo Html::tag('div', $content, ['class' => 'list-group']);
        }
        else {
            $this->renderEmpty();
        }
    }

    /**
     * Processing input data to render all items of a list group
     *
     * @return string
     */
    protected function renderModels()
    {
        $content = '';
        foreach ($this->models as $model) {
            $url = $this->createUrl($model);
            $content .= $this->renderItem($model['name'], $url, $model['count']);
        }

        return $content;
    }

    /**
     * Creates a URL for linked item from input data
     *
     * @param $model
     * @return string
     */
    protected function createUrl($model)
    {
        return '#';
    }

    /**
     * Renders one linked item of a list group
     *
     * @param $name text to be displayed
     * @param $url URL for the item
     * @param bool|integer $badge a number to be displayed in a badge
     * @param string $class additional class for the item
     * @return string
     */
    protected function renderItem($name, $url, $badge = false, $class = '')
    {
        $badgeContent = '';
        if($badge !== false) {
            $badgeContent = Html::tag('span', $badge, ['class' => 'badge']);
        }

        $itemContent = $badgeContent . $name;

        $itemClass = 'list-group-item';
        if(!empty($class)) {
            $itemClass .= ' ' . $class;
        }
        return Html::a($itemContent, $url, ['class' => $itemClass]);
    }

    /**
     * Renders template when no data is provided
     */
    protected function renderEmpty()
    {
        echo '(Нет данных)';
    }
}
