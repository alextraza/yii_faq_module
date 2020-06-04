<?php

namespace common\modules\faq;

use Yii;
use yii\base\Module;
use yii\web\Application;
use backend\components\BackendApplication;

class FaqModule extends Module
{
    public $controllerNamespace = 'common\modules\faq\frontend\controllers';

    public function init()
    {
        parent::init();
        if (Yii::$app instanceof BackendApplication) {
            $this->controllerNamespace = 'common\modules\faq\backend\controllers';
            $this->viewPath = '@common/modules/faq/backend/views';
            $this->defaultRoute = 'faq/index';
        } else if(Yii::$app instanceof Application) {
            $this->viewPath = '@common/modules/faq/frontend/views';
        }

        $this->registerTranslations();
    }

    public function registerTranslations()
    {
        Yii::$app->i18n->translations['modules/faq/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'basePath' => '@common/modules/faq/common/messages',
            'fileMap' => [
                'modules/faq/backend' => 'backend.php',
                'modules/faq/frontend' => 'frontend.php',
            ],
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/faq/' . $category, $message, $params, $language);
    }

}
