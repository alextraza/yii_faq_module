<section class="faq__wrapper">
    <div class="h2-header"><?php echo $header; ?></div>
    <div class="container">
        <div class="faq__container" itemscope="" itemtype="https://schema.org/FAQPage">
            <?php foreach ($models as $model) : ?>
                <div class="faq__item"  itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
                    <div class="question" itemprop="name">
                        <?php echo $model->question; ?>
                    </div>
                    <div class="answer"  itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
                        <div itemprop="text">
                            <?php echo $model->answer; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php

$this->registerJs( <<< EOT_JS_CODE

    $('.question').on('click', function() {
        if ($(this).hasClass('expanded')) {
            $(this).removeClass('expanded');
            return false;
        }

        $('.question.expanded').removeClass('expanded');
        $(this).addClass('expanded');
    })

EOT_JS_CODE
);

$this->registerCss( <<< EOT_CSS_CODE

 .faq__item {
      margin-bottom: 10px;
 }

.faq__item .question {
      border: 1px solid #2e77a3;
      padding: 10px 15px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: bold;
      font-size: 18px;
      cursor: pointer;
 }

.faq__item .question:after {
      content: 'E';
      font-family: Glypher;
      transition: .2s;

 }

.faq__item .answer {
      overflow: hidden;
      padding: 0px;
      height: 0px;
      visibility: hidden;
      opacity: 0;
      transition: .2s;
 }

.faq__item .question.expanded + .answer {
      visibility: visible;
      opacity: 1;
      padding: 10px 15px;
      height: auto;
 }

.faq__item .question.expanded:after {
      transform: rotate(180deg);
 }

EOT_CSS_CODE
);
?>
