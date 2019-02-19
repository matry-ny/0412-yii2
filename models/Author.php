<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "authors".
 *
 * @property int $id
 * @property string $name
 *
 * @property Product[] $products
 */
class Author extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'authors';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getProducts(): ActiveQuery
    {
        return $this->hasMany(Product::class, ['author_id' => 'id']);
    }
}
