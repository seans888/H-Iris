<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EmailCustomer */

$this->title = 'Create Email Customer';
$this->params['breadcrumbs'][] = ['label' => 'Email Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-customer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
