<?php

namespace common\modules\faq\common\models;

use Yii;
use common\models\Language;
use common\modules\faq\FaqModule;

class FaqTranslation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%faq_translation}}';
    }

    public function attributeLabels()
    {
        return [
            'question' => FaqModule::t('backend', 'Question'),
            'answer' => FaqModule::t('backend', 'Answer'),
        ];
    }

    public function getFaq()
    {
        return $this->hasOne(Faq::className(), ['id' => 'faq_id']);
    }
}
