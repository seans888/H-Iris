<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CustomerPreference */

$this->title = $model->customer_id;
$this->params['breadcrumbs'][] = ['label' => 'Customer Preferences', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-preference-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'customer_id' => $model->customer_id, 'preference_id' => $model->preference_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'customer_id' => $model->customer_id, 'preference_id' => $model->preference_id], [
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
            'customer_id',
            'preference_id',
        ],
    ]) ?>

</div>
