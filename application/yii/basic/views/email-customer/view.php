<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EmailCustomer */

$this->title = $model->email_id;
$this->params['breadcrumbs'][] = ['label' => 'Email Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-customer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'email_id' => $model->email_id, 'customer_id' => $model->customer_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'email_id' => $model->email_id, 'customer_id' => $model->customer_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
             array(
                    'label' => $model->email->getAttributeLabel('email'),
                    'value' => $model->email->information),
             array(
                    'label' => $model->customer->getAttributeLabel('customer'),
                    'value' => $model->customer->name),
           
        ],
    ]) ?>

</div>
