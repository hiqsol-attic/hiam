<?php

/** @var yii\web\View $this */
/** @var yii\web\IdentityInterface $user */
/** @var string $confirmLink */
?>
<?= Yii::t('hiam', 'Hello {name},', ['name' => $user->name]) ?>

<?= Yii::t('hiam', 'Follow the link below to confirm your email:') ?>

<?= $confirmLink ?>
