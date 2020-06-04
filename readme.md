# Модуль Вопросов - ответов

## Установка

Склонировать ```git clone https://github.com/alextraza/yii_faq_module.git``` и
закинуть в common\modules.

В модулях перейти в "Доступные" и установить.
В настройках установленного модуля включить активный статус и выбрать Менеджера
в правах.

## Подключение в модели

Подключить трейт;

```php
<?php 

use common\modules\faq\common\components;

class SomeModelName
{
  use FaqTrait;
  ...

```

добавить в массив rules

```php

...
['faqIds', 'safe'],
...

```

## Добавление в форму редактирования

в фале _form.php соответсвующей модели подключить в нужном месте виджет

```php

<?php echo \common\modules\faq\backend\widgets\FaqFieldWidget::widget([
  'form' => $form,
  'model' => $model
]); ?>

```

## Вывод во фронт

```php

    <?php echo \common\modules\faq\frontend\widgets\FaqWidget::widget([
      'header' => 'Заголовок',
      'model' => $model,
    ])

```

где $model - экземпляр модели с привязанными вопросами
