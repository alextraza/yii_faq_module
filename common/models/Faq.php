<?php

namespace common\modules\faq\common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\Language;
use common\modules\faq\FaqModule;
use creocoder\translateable\TranslateableBehavior;

/**
 * This is the model class for table "review".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $pos
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Faq extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%faq}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'translateable' => [
                'class' => TranslateableBehavior::className(),
                'translationAttributes' => ['question', 'answer']
            ],

        ];
    }

    public function rules()
    {

            return [
                [['status', 'pos'], 'integer'],
            ];

    }

    public function getModel()
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend/faq', 'ID'),
            'status' => FaqModule::t('backend', 'Status'),
            'onmain' => FaqModule::t('backend', 'Onmain'),
            'pos' => FaqModule::t('backend', 'Pos'),
            'created_at' => Yii::t('backend/faq', 'Created at'),
            'updated_at' => Yii::t('backend/faq', 'Updated at'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\modules\guestbook\common\models\query\ReviewQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new query\FaqQuery(get_called_class());
    }

    public function getUrl()
    {
        return '/faq/' . $this->id;
    }
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(FaqTranslation::className(), ['faq_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasMany(Language::className(), ['code' => 'language'])->viaTable('{{%faq_translation}}', ['faq_id' => 'id']);
    }

    public static function getList()
    {
        return self::find()
            ->select(['question', 'id'])
            ->joinWith(['translations'])
            ->indexBy('id')
            ->column();
    }


}
