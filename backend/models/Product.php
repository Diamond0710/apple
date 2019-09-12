<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "apple_products".
 *
 * @property int $id
 * @property string $color
 * @property int $created_at
 * @property int $fall_at
 * @property int $status
 * @property int $eating_percent
 */
class Product extends \yii\db\ActiveRecord
{
    const FALL_TIME = '+1 minutes';
    const MAX_APPLE_COUNT = 50;
    const MIN_APPLE_COUNT = 5;
    const STATUS_NEW = 1;
    const STATUS_FALL = 2;
    const STATUS_ROTTEN = 3;


    /**
     * {@inheritdoc}
     */

    public $eating_percent;
    public $fall;

    public static function tableName()
    {
        return 'apple_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['eating_percent'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Color',
            'created_at' => 'Created At',
            'rotten_at' => 'Rotten At',
            'status' => 'Status',
            'eating_percent' => 'Eating Percent',
            'fall' => 'Упасть'
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $created_at = strtotime(date('Y-m-d H:i:s'));
                $this->created_at = $created_at;
                $this->color = $this->generateColor();
            }
            return true;
        } else {
            return false;
        }
    }

    public static function createProducts() {
        for ($i = 1; $i <= self::randProductCount(); $i++) {
            $product = new Product();
            $product->save();
        }
        return self::find()->all();
    }

    public static function getStatusList(){
        return [
            self::STATUS_NEW => 'висит на дереве',
            self::STATUS_FALL => 'упало',
            self::STATUS_ROTTEN => 'гнилое яблоко'
        ];
    }

    public function getStatus() {
        $statusList = self::getStatusList();
        if($this->notRotten()) {
            return $statusList[$this->status];
        }
        return $statusList[self::STATUS_ROTTEN];
    }

    public function notRotten(){
        if (($this->status == self::STATUS_FALL) && strtotime(date('Y-m-d H:i:s')) > $this->rotten_at) {
            return false;
        }
        return true;
    }

    private static function randProductCount() {
        return rand( self::MIN_APPLE_COUNT, self::MAX_APPLE_COUNT);
    }

    protected function generateColor() {
        return substr(md5(mt_rand()), 0, 6);
    }
}
