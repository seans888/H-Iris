<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\WebvisitHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Webvisit Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webvisit-history-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Webvisit History', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'wvh_date',
            //'wvh_time',
            //'wvh_ip_address',
            //'wvh_url:url',
            // 'wvh_cookie_information',
            //'customer_id',
           // 'prospect_id',
            
            ['attribute'=>'wvh_date', 'value'=> 'wvh_date'],
            ['attribute'=>'wvh_time', 'value'=> 'wvh_time'],
            ['attribute'=>'wvh_ip_address', 'value'=> 'wvh_ip_address'],
            ['attribute'=>'wvh_url', 'value'=> 'wvh_url'],
            ['attribute'=>'customer_id', 'value'=> 'customer.name'],
            ['attribute'=>'prospect_id', 'value'=> 'prospect.name'],
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
