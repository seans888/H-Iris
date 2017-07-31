<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WebvisitHistory */

$this->title = 'Update Webvisit History: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Webvisit Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="webvisit-history-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
