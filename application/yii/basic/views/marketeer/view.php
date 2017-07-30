<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Marketeer */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Marketeers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marketeer-view">

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
            'marketeer_fname',
            'marketeer_mname',
            'marketeer_lname',
            'marketeer_birthdate',
            'marketeer_contact_number',
        ],
    ]) ?>

</div>
