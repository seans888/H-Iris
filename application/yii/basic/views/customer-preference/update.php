<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CustomerPreference */

$this->title = 'Update Customer Preference: ' . $model->customer_id;
$this->params['breadcrumbs'][] = ['label' => 'Customer Preferences', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->customer_id, 'url' => ['view', 'customer_id' => $model->customer_id, 'preference_id' => $model->preference_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="customer-preference-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
