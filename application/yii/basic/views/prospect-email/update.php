<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProspectEmail */

$this->title = 'Update Prospect Email: ' . $model->prospect_id;
$this->params['breadcrumbs'][] = ['label' => 'Prospect Emails', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->prospect_id, 'url' => ['view', 'prospect_id' => $model->prospect_id, 'email_id' => $model->email_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="prospect-email-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
