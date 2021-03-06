<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "subjects".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property News[] $news
 */
class Subjects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subjects}}';
    }

    public static function getSubjectsWithNewsCount()
    {
        $subjects = (new \yii\db\Query())
            ->select(['id', 'name'])
            ->from(self::tableName())
            ->orderBy('name')
            ->all();

        $countArr = \common\models\News::countBySubjects();
        foreach ($subjects as &$subject) {
            $key = $subject['id'];
            $subject['count'] = array_key_exists($key, $countArr) ? $countArr[$key] : 0;
        }

        return $subjects;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function Items()
    {
        $items = self::find()
            ->orderBy('name')
            ->all();

        return ArrayHelper::map($items, 'id', 'name');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Тема',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['subject_id' => 'id']);
    }
}
