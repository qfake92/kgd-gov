<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this \yii\web\View
 * @var $debtor \common\models\Debtor
 * @var $formModel \app\forms\parser\InnRequestForm
 */
?>

	<h3>Информация о задолженностях</h3>

<?php
echo $this->render('_debtor-details', ['debtor' => $debtor]);

$form = ActiveForm::begin();
echo Html::activeInput('hidden', $formModel, 'inn');
echo Html::activeInput('hidden', $formModel, 'save');
echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']);
$form::end();
