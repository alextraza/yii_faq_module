<?php

namespace common\modules\faq\backend\widgets;

use yii\base\Widget;

class FaqFieldWidget extends Widget
{
    public $form;
    public $model;

    public function init()
    {
    }

    public function run()
    {
        return $this->render('faq_field', [
            'form' => $this->form,
            'model' => $this->model,
        ]);
    }
}
