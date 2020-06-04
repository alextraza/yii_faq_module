<?php

namespace common\modules\faq\frontend\widgets;

use yii\base\Widget;
use common\modules\faq\common\models\Faq;

class FaqWidget extends Widget
{
    public $model;
    public $header;

    private $_models;

    public function init()
    {
        parent::init();
        $this->_models = $this->model->faqContent;
    }

    public function run()
    {
        if (!$this->_models) {
            return null;
        }

        return $this->render('faq', [
            'models' => $this->_models,
            'header' => $this->header
        ]);
    }
}
