<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $name
 * @property string $content
 * @property string $publication_date
 * @property integer $subject_id
 * @property integer $author_id
 *
 * @property User $author
 * @property Subjects $subject
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    public static function find()
    {
        return new NewsQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'content', 'publication_date'], 'required'],
            [['content'], 'string'],
            [['publication_date'], 'safe'],
            [['subject_id', 'author_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subjects::className(), 'targetAttribute' => ['subject_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'content' => 'Текст новости',
            'publication_date' => 'Дата публикации',
            'subject_id' => 'Тема',
            'author_id' => 'Автор',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subjects::className(), ['id' => 'subject_id']);
    }
}


/**
 * NewsQuery represents an ActiveQuery for the News model
 *
 * @package common\models
 *
 */
class NewsQuery extends ActiveQuery
{
    /**
     * Adds WHERE condition for filtering by subject, checks if parameters are empty
     *
     * @param $subject
     * @return $this
     */
    public function andWhereSubject($subject)
    {
        if($subject) {
            $this->andWhere(['subject_id' => $subject]);
        }
        return $this;
    }

    /**
     * Adds WHERE condition for filtering by year and month, checks if parameters are empty
     *
     * @param $year
     * @param $month
     * @return $this
     */
    public function andWhereYearAndMonth($year, $month)
    {
        if($year) {
            $this->andWhere(new \yii\db\Expression('YEAR(publication_date) = :year', [':year' => $year]));

            if($month) {
                $this->andWhere(new \yii\db\Expression('MONTH(publication_date) = :month', [':month' => $month]));
            }
        }
        return $this;
    }
}