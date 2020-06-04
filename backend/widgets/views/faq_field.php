<?php

use common\modules\faq\common\models\Faq;
use kartik\select2\Select2;

?>

<?php echo $form->field($model, 'faqIds')->widget(Select2::classname(), [
    'data' => Faq::getList(),
    'name' => 'MaterialItems[]',
    'options' => ['multiple' => true, 'placeholder' => 'Выбрать вопрос'],
    'pluginOptions' => [
        'allowClear' => true,
    ],
])->label('Вопросы');
?>
