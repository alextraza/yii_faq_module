<?php

namespace common\modules\faq\common\models\query;

use common\modules\faq\common\models\Faq;

/**
 * This is the ActiveQuery class for [[\common\modules\guestbook\common\models\Review]].
 *
 * @see \common\modules\guestbook\common\models\Review
 */
class FaqQuery extends \yii\db\ActiveQuery
{

    public function active()
    {
        $this->andWhere(['status' => Faq::STATUS_ACTIVE]);
        return $this;
    }

    /**
     * @return $this
     */
    public function inactive()
    {
        $this->andWhere(['status' => Faq::STATUS_INACTIVE]);
        return $this;
    }
}
