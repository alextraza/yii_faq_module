<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use yii\grid\GridView;
use common\helpers\Image;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\guestbook\backend\models\ReviewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'ЧаВо');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-index">

    <p class="pull-right">
        <?= Html::a(Yii::t('backend', 'Создать ЧаВо'), ['create'], ['class' => 'btn btn-sm btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'data-table table-striped'],
        'layout' => "{items}\n{pager}\n{summary}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'options' => ['width' => '10%']
            ],
            [
                'attribute' => 'pos',
                'value' => function ($model) {
                    return Html::textInput(
                        'pos',
                        $model->pos,
                        [
                            'class' => 'form-control input-edit',
                            'data-id' => $model->id,
                            'placeholder' => 'Не задана',
                            'data-action' => Url::to([Yii::$app->controller->id.'/change-pos', 'id' => $model->id]),
                        ]
                    );
                },
                'format' => 'raw',
                'options' => ['width' => '10%']
            ],
            [
                'attribute' => 'question',
                'value' => function($model) {
                    return StringHelper::truncate(strip_tags($model->question), 35);
                }
            ],
            [
                'attribute' => 'answer',
                'value' => function($model) {
                    return StringHelper::truncate(strip_tags($model->answer), 50);
                }
            ],
            [
                'class' => 'backend\grid\SwitchStatusColumn',
                'checked' => function($model) {
                    return $model->status;
                }
            ],
            ['class' => 'backend\grid\ActionColumn'],
        ],
    ]); ?>

</div>

<?php

$this->registerCss( <<< EOT_CSS_CODE

                   .input-edit[name="pos"] {
                       border: none;
                       padding: 2px 0px;
                       box-shadow: none;
                       transition: .3s;
                   }

                    .input-edit[name="pos"]:focus {
                        border: 1px solid #ccc;
                        padding: 2px 12px;
                        box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, 0.6);
                    }

EOT_CSS_CODE
);

$this->registerJs( <<< EOT_JS_CODE

        $(document).on('change', 'input.input-edit', function(e){
        var new_value = $(this).val();
        var input_id = $(this).data('id');
        $.ajax({
            type: "POST",
            url: $(this).data('action'),
            data: {pos: new_value, id: input_id},
            success: function(msg){
                $('.logo').after('<div class="alert alert-success" data-id="alert">Материал‚ ' + msg.success + ' обновлен!</div>');
                $('div[data-id=alert]').delay(1500).fadeOut();
            }
        });
        return false;
    });

    $(document).on('click', 'input.input-edit', function(e){
        $(this).select();
    });

EOT_JS_CODE
);

?>
