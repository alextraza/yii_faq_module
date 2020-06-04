<?php

use yii\db\Migration;
use common\modules\faq\common\models\Faq;
use common\modules\faq\common\models\FaqTranslation;

class m160229_110822_faq_shchema extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(Faq::tableName(), [
            'id' => $this->primaryKey(),
            'status' => $this->boolean()->notNull()->defaultValue(0),
            'onmain' => $this->boolean()->notNull()->defaultValue(0),
            'pos' => $this->smallInteger(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);

        $this->createTable(FaqTranslation::tableName(), [
            'faq_id' => $this->integer()->notNull(),
            'language' => $this->string(8)->notNull(),
            'question' => $this->text(),
            'answer' => $this->text(),
        ], $tableOptions);

        $this->addPrimaryKey('faq_translation_pk', FaqTranslation::tableName(), ['faq_id', 'language']);
        $this->addForeignKey('fk_faq_translation', FaqTranslation::tableName(), 'faq_id', Faq::tableName(), 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_faq_translation_language', FaqTranslation::tableName(), 'language', '{{%language}}', 'code', 'cascade', 'cascade');

        $this->createTable('faq_model', [
            'faq_id' => $this->integer(),
            'model_id' => $this->integer(),
            'model' => $this->string(150),
        ], $tableOptions);

        $this->addPrimaryKey('faq_model_pk', 'faq_model', ['faq_id', 'model', 'model_id']);
        $this->addForeignKey('fk_faq_model', 'faq_model', 'faq_id', Faq::tableName(), 'id', 'cascade', 'cascade');
    }

    public function down()
    {
        $this->dropTable('faq_model');
        $this->dropTable(FaqTranslation::tableName());
        $this->dropTable(Faq::tableName());
    }
}
