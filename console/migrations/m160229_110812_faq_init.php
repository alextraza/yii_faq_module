<?php

use yii\db\Migration;
use common\models\Module;

class m160229_110812_faq_init extends Migration
{
    public function up()
    {
        $this->insert(Module::tableName(), [
            'id' => 'faq',
            'class' => 'common\modules\faq\FaqModule',
            'title' => 'ЧаВо',
            'icon' => 'ion-android-textsms',
            'version' => '0.1',
            'is_installed' => Module::STATE_INSTALLED
        ]);
    }

    public function down()
    {
        $this->delete(Module::tableName(), ['id' => 'faq']);
    }
}
