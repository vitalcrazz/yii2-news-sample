<?php

namespace frontend\widgets;

use Yii;

/**
 * Renders a list group for the subjects list
 *
 * @package frontend\widgets
 */
class SubjectsList extends \frontend\widgets\ListGroup
{
    /**
     * @inheritdoc
     */
    protected function createUrl($model)
    {
        return ['/news/index', 'subject' => $model['id']];
    }
}
