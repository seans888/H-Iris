<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProspectPreference */

$this->title = $model->prospect_id;
$this->params['breadcrumbs'][] = ['label' => 'Prospect Preferences', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prospect-preference-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'prospect_id' => $model->prospect_id, 'preference_id' => $model->preference_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'prospect_id' => $model->prospect_id, 'preference_id' => $model->preference_id], [
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
            'prospect_id',
            'preference_id',
        ],
    ]) ?>

</div>
