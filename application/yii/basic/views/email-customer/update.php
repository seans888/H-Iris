<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EmailCustomer */

$this->title = 'Update Email Customer: ' . $model->email_id;
$this->params['breadcrumbs'][] = ['label' => 'Email Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->email_id, 'url' => ['view', 'email_id' => $model->email_id, 'customer_id' => $model->customer_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="email-customer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
