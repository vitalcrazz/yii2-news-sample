<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $name
 * @property string $content
 * @property string $publication_date
 * @property integer $subject_id
 * @property integer $author_id
 * @property integer $created_at
 * @property integer $updated_at
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
        return '{{%news}}';
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

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new NewsQuery(get_called_class());
    }

    const COUNT_BY_SUBJECT_CACHE = 'news_count_by_subject';

    public static function countBySubjects()
    {
        $countArr = Yii::$app->cache->get(self::COUNT_BY_SUBJECT_CACHE);
        if($countArr !== false) {
            return $countArr;
        }

        $counts = (new \yii\db\Query())
            ->select(new Expression('subject_id, COUNT(*) AS count'))
            ->from(self::tableName())
            ->groupBy('subject_id')
            ->all();
        $countArr = ArrayHelper::map($counts, 'subject_id', 'count');

        Yii::$app->cache->set(self::COUNT_BY_SUBJECT_CACHE, $countArr, 0, new \yii\caching\DbDependency([
            'sql' => 'SELECT MAX(updated_at) FROM news',
        ]));

        return $countArr;
    }

    public static function getMonths()
    {
        $months = (new \yii\db\Query())
            ->select(new Expression('YEAR(publication_date) AS year, MONTH(publication_date) AS month, COUNT(*) AS count'))
            ->from(self::tableName())
            ->groupBy(new Expression('YEAR(publication_date), MONTH(publication_date)'))
            ->orderBy(['year' => SORT_DESC, 'month' => SORT_DESC])
            ->all();
        return $months;
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        parent::afterDelete();

        Yii::$app->cache->delete(self::COUNT_BY_SUBJECT_CACHE);
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
            $this->andWhere(new Expression('YEAR(publication_date) = :year', [':year' => $year]));

            if($month) {
                $this->andWhere(new Expression('MONTH(publication_date) = :month', [':month' => $month]));
            }
        }
        return $this;
    }
}