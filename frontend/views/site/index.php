<?php

/* @var $this yii\web\View */

$this->title = 'Задолженности';

use yii\helpers\Url; ?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Информация о задолженностях</h1>
        <p class="lead">Для получения новых данных перейдите в раздел <a href="<?= Url::to(['parser/parsing']) ?>">Новый запрос</a></p>
        <p class="lead">Для просмотра сохраненных данных перейдите в раздел <a href="<?= Url::to(['parser/list-saved']) ?>">Сохраненные</a></p>
    </div>
</div>
