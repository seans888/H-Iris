<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProspectPreference */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Prospect Preferences', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prospect-preference-view">

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
            
           // array('label'=>$model->prospect->getAttributesLabel('prospect'),
                //'value'=>$model->prospect->name),

           // array('label'=>$model->preference->getAttributesLabel('preference'),
                //'value'=>$model->preference->information),
            'prospect.name',
            'preference.information',
        ],
    ]) ?>

</div>
