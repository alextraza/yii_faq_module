<?php

namespace common\modules\faq\common\models;

use Yii;
use common\modules\faq\FaqModule;

/**
 * This is the model class for table "review".
 *
 */
class FaqModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%faq_model}}';
    }

    public function getFaqs()
    {
        return $this->hasMany(Faq::className(), ['faq_id' => 'id']);
    }
}
