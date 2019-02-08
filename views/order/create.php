<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\order */
/* @var $form ActiveForm */
?>
<div class="order-create">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-12">
            <?php $form = ActiveForm::begin(); ?>
                <h1>
                    Banana Pack Calculator<br>
                    <small>Enter the number of bananas ordered in the field below</small>
                </h1>
                <hr>
                <br>


                <?= $form->field($model, 'volume')->input('number') ?>            
                <div class="form-group">
                    <?= Html::submitButton('Calculate Required Packs', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div><!-- order-create -->
