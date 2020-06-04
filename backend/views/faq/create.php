<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\guestbook\models\Review */

$this->title = Yii::t('backend', 'Создать ЧаВо');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'ЧаВо'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
