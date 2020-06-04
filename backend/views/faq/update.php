<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $model common\modules\guestbook\models\Review */

$this->title = Yii::t('backend', 'Обновить ЧаВо: ', [
    'modelClass' => 'ЧаВо',
]) . ' ' . StringHelper::truncate(strip_tags($model->question), 20);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'ЧаВо'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Обновить');
?>
<div class="review-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
