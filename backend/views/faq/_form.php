<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\Image;
use kartik\form\ActiveForm;
use common\modules\faq\common\models\Faq;
use backend\widgets\TinyMce;
use common\models\Language;

/* @var $this yii\web\View */
/* @var $model common\modules\guestbook\models\Review */
/* @var $form kartik\form\ActiveForm */

$languages = Language::findAllActive();
$lang = Yii::$app->config->get('materialsLanguage');

?>

<div class="review-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-9">
            <ul class="nav nav-tabs" role="tablist">
                <?php $i = 0; foreach ($languages as $language): ?>
                    <li role="presentation" class="<?= $language->code == $lang ? 'active' : '' ?>">
                        <a href="#lang-<?= $language->code?>" aria-controls="lang-<?= $language->code?>" role="tab" data-toggle="tab">
                            <?=Html::tag('i', '', ['class' => $language->code, 'style' => 'margin-right: 5px;'])?>
                            <?=Yii::t('common/language', $language->title) ?>
                        </a>
                    </li>
                <?php $i++; endforeach ?>
            </ul>

            <div class="tab-content">

                <?php $j = 0; foreach ($languages as $language): ?>

                    <div class="tab-pane <?= $language->code == $lang ? 'active' : '' ?>" role="tabpanel"  id="lang-<?= $language->code?>">

                        <?= $form->field($model->translate($language->code), '[' . $language->code . ']question')->textarea(); ?>

                        <?= $form->field($model->translate($language->code), '[' . $language->code . ']answer')->widget(\mihaildev\ckeditor\CKEditor::className(), [
                            'editorOptions' => \mihaildev\elfinder\ElFinder::ckeditorOptions('elfinder', [
                                'preset' => 'small',
                                'language' => Yii::$app->language
                            ]),
                        ]) ?>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-md-3">

            <?= $form->field($model, 'status', [
                'horizontalCssClasses' => [
                    'wrapper' => 'switcher',
                ]
            ])->checkbox([
                'template' => '{input}{label}',
                'class' => 'switch',
            ]); ?>

            <?= $form->field($model, 'onmain', [
                'horizontalCssClasses' => [
                    'wrapper' => 'switcher',
                ]
            ])->checkbox([
                'template' => '{input}{label}',
                'class' => 'switch',
            ]); ?>

            <?php echo $form->field($model, 'pos')->textInput(); ?>

        </div>
    </div>



    <div class="well">
        <div class="pull-right">
            <?= Html::submitButton(Yii::t('backend', 'Apply'), ['class' => 'btn btn-warning']) ?>
            <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
        </div>
        <?= Html::a('Отмена', Url::previous(), [
            'class' => 'btn btn-danger',
            'id' => 'return',
            'rel' => 'tooltip',
            'data-original-title' => 'Отмена'
        ])?>
        <div class="clearfix"></div>
    </div>


    <?php ActiveForm::end(); ?>

</div>

<?php

$this->registerCss( <<< EOT_CSS_CODE

                    .switcher {
                        margin-left: 15px;
                        display: flex;
                        justify-content: flex-start;
                    }

                    input.switch {
                        z-index: -1;
                        opacity: 0;
                        margin: 10px 0 0;
                    }

                    .switch + label {
                        position: relative;
                        padding: 0 0 0 60px;
                        cursor: pointer;
                        font-weight: bold;
                    }

                    .switch + label:before {
                        content: '';
                        position: absolute;
                        top: -4px;
                        left: 0;
                        width: 50px;
                        height: 26px;
                        border-radius: 13px;
                        background: #eee;
                        box-shadow: inset 0 2px 3px rgba(0,0,0,.2);
                        transition: .1s;
                    }

                    .switch:checked + label:before {
                        background: #69abee;
                    }

                    .switch + label:after {
                        content: '';
                        position: absolute;
                        top: -2px;
                        left: 2px;
                        width: 22px;
                        height: 22px;
                        border-radius: 50%;
                        background: #fff;
                        box-shadow: 0 2px 5px rgba(0,0,0,.3);
                        transition: .1s;
                    }

                    .switch:checked + label:after {
                        left: 26px;
                    }

EOT_CSS_CODE
);

?>
