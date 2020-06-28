<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'layout' => 'horizontal',

]); ?>

<?= $form->field($model, 'date')->textInput(['type' => 'date']) ?>

<?= $form->field($model, 'numberMonths')->input('number', ['min' => 0, 'max' => 36]) ?>

<?= $form->field($model, 'amount')->input('number', ['min' => 1000, 'max' => 10000000]) ?>

<?= $form->field($model, 'interestRate')->input('number', ['min' => 0, 'max' => 100]) ?>


    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('generate', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

<?php foreach ($charts as $chart): ?>
    <a href="http://generator/web/index.php?id=<?=$chart['id']?>"><?=$chart['title']?></a><br>
<?php endforeach; ?>

<?php ActiveForm::end(); ?>