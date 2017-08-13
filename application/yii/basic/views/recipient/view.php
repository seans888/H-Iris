<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Recipient */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Recipients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipient-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'recipient_type',
            'recipient_email:email',
            'recipient_fname',
            'recipient_mname',
            'recipient_lname',
            'recipient_contact_number',
            'customer_id',
        ],
    ]) ?>

</div>
