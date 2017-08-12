<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\models\Prospect;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProspectEmailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Prospect Emails';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prospect-email-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Prospect Email', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          'id',
           [
            'attribute'=>'prospect_id',
            'value'=>'prospect.name'],
            ['attribute'=>'email_id',
            'value'=>'email.information'],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>