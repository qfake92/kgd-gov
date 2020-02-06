<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\widgets\DetailView;

/**
 * @var $this \yii\web\View
 * @var $debtor \common\models\Debtor
 */

echo DetailView::widget([
	'model'      => $debtor,
	'attributes' => [
		[
			'attribute' => 'inn',
			'label'     => 'ИНН'
		],
		[
			'attribute' => 'name',
			'label'     => 'ФИО'
		],
		[
			'attribute' => 'arrears',
			'label'     => 'Всего задолженности (тенге)',
			'value'     => function ($item) {
				/** @var  $item \common\models\Debtor */
				$sum = 0;
				foreach ($item->arrears as $arrear) {
					$sum += $arrear->total;
				}
				return $sum;
			}
		],
	],
]);

echo GridView::widget([
	'dataProvider' => new ArrayDataProvider([
		'models'     => $debtor->arrears,
		'totalCount' => count($debtor->arrears),
	]),
	'columns'      => [
		[
			'attribute'      => 'department.name',
			'contentOptions' => ['style' => 'white-space: pre-line'],
			'label'          => 'Орган государственных доходов',
		],
		[
			'attribute' => 'type.name',
			'label'     => 'Вид задолженности',
		],
		[
			'attribute' => 'tax',
			'label'     => 'Органы гос. доходов'
		],
		[
			'attribute' => 'poena',
			'label'     => 'Пеня',
		],
		[
			'attribute' => 'percent',
			'label'     => 'Проценты',
		],
		[
			'attribute' => 'fine',
			'label'     => 'Штраф',
		],
		[
			'attribute' => 'total',
			'label'     => 'Всего',
		],
	]
]);