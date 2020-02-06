<?php
/**
 * @var $this \yii\web\View
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

use yii\grid\GridView;
use yii\helpers\Html; ?>

	<h3>Сохраненные</h3>

<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'columns'      => [
		'inn',
		'name',
		[
			'format' => 'raw',
			'value'  => function ($item) {
				/** @var $item \common\models\Debtor */
				return Html::a(
					Html::tag('span', '', ['class' => 'glyphicon glyphicon-eye-open']),
					['parser/view-saved', 'id' => $item->id]
				);
			}
		],
	],
]);
