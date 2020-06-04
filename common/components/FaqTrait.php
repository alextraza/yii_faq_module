<?php

namespace common\modules\faq\common\components;

use common\modules\faq\common\models\Faq;
use common\modules\faq\common\models\FaqModel;

trait FaqTrait
{
    protected $_faqIds;

    public function getModelName()
    {
        return get_class($this);
    }

    public function getFaqIds()
    {
        if ($this->_faqIds === null) {
            $this->_faqIds = $this->getFaqs();
        }
        return $this->_faqIds;
    }

    public function setFaqIds($value)
    {
        return $this->_faqIds = (array)$value;
    }

    public function getFaqs()
    {
        $result = FaqModel::find()
                          ->select(['faq_id'])
                          ->where([
                              'model_id' => $this->id,
                              'model' => $this->modelName,
                          ])
                          ->column();
        return $result;
    }

    public function getFaqContent()
    {
        $faqIds = $this->faqIds;

        $result = Faq::find()
                     ->where(['id' => $faqIds])
                     ->active()
                     ->orderBy(['pos' => SORT_ASC])
                     ->all();

        return $result;
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->updateFaqs();
        parent::afterSave($insert, $changedAttributes);
    }

    public function updateFaqs()
    {
        $current = $this->getFaqs();
        $new = $this->getFaqIds();

        foreach(array_filter(array_diff($new, $current)) as $faqId) {
            if($faq = Faq::findOne($faqId)) {
                $faqModel = new FaqModel();
                $faqModel->faq_id = $faqId;
                $faqModel->model_id = $this->id;
                $faqModel->model = $this->modelName;
                $faqModel->save();
            }
        }

        foreach(array_filter(array_diff($current, $new)) as $faqId) {
            if($faq = FaqModel::find()
                              ->where([
                                  'faq_id' => $faqId,
                                  'model' => $this->modelName,
                                  'model_id' => $this->id
                              ])
                              ->one()
            ) {
                $faq->delete();
            }
        }
    }
   
}
