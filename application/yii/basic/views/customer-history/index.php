<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CustomerHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customer Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-history-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Customer History', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'ch_checkin',
            'ch_checkout',
            'ch_numberdays',
            'customer.name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
