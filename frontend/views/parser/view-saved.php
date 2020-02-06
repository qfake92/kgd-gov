<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $debtor \common\models\Debtor */

$this->title = 'Информация о должнике';
echo Html::tag('h3', $this->title);

echo $this->render('_debtor-details', ['debtor' => $debtor]);
