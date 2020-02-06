<?php

/* @var $this \yii\web\View */
/* @var $model \app\forms\parser\InnRequestForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Парсинг ИНН';

use yii\helpers\Html;
use yii\widgets\ActiveForm; ?>

<h3>Введите ИНН, по которому нужно сделать запрос</h3>
<br>
<br>
<div class="input-part">
	<?php $form = ActiveForm::begin([
		'id'      => 'inn-input',
		'options' => [
			'style' => 'width: 50%'
		]
	]) ?>
	<?= $form->field($model, 'inn') ?>

	<div class="form-group">
		<div class="button">
			<?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
		</div>
	</div>
	<?php ActiveForm::end() ?>
</div>
