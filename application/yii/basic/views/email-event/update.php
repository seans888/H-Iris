<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EmailEvent */

$this->title = 'Update Email Event: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Email Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="email-event-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
