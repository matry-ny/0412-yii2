<?php

namespace app\models;

use lajax\translatemanager\helpers\Language;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $title
 * @property string $price
 * @property int $author_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 *
 * @property Author $author
 */
class Product extends ActiveRecord
{
    /**
     * @var string
     */
    public $title_t;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'products';
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['price'], 'number'],
            [['author_id', 'created_at', 'updated_at', 'created_by'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [
                ['author_id'],
                'exist',
                'targetClass' => Author::class,
                'targetAttribute' => ['author_id' => 'id']
            ],
            [
                ['created_by'],
                'exist',
                'targetClass' => User::class,
                'targetAttribute' => ['created_by' => 'id']
            ]
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('product', 'ID'),
            'title' => Yii::t('product', 'Title'),
            'price' => Yii::t('product', 'Price'),
            'author_id' => Yii::t('product', 'Author ID'),
            'created_at' => Yii::t('product', 'Created At'),
            'updated_at' => Yii::t('product', 'Updated At'),
            'created_by' => Yii::t('product', 'Created By')
        ];
    }

    public function afterFind() {
        $this->title_t = Language::d($this->title);
        parent::afterFind();
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            Language::saveMessage($this->title);

            return true;
        }

        return false;
    }

    /**
     * @return ActiveQuery
     */
    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }
}
