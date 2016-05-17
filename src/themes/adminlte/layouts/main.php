<?php

/**
 * Theme main layout.
 *
 * @var components\View View
 * @var string $content Content
 */
use yii\helpers\Html;

$this->registerJs(<<<'JS'
$(function () {
    $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
JS
, \yii\web\View::POS_READY);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->render('//layouts/head') ?>
</head>
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->

<?php if (isset($this->blocks['bodyClass'])): ?>
    <?= '<body class="' . $this->blocks['bodyClass'] . '">'; ?>
<?php else: ?>
<body>
<?php endif; ?>


<?php $this->beginBody(); ?>
<body class="login-page">
<div class="login-box">
    <div class="login-logo">
        <?= Html::a('<b>AH</b>names', ['/']); ?>
    </div>
    <!-- /.login-logo -->
    <?= $content; ?>
</div>
<!-- /.login-box -->
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
