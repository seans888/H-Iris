<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmailCustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Email Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-customer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Email Customer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [  
            'attribute' => 'email_id', 
            'value'=>'email.information' 
             ],
             [  
            'attribute' => 'customer_id', 
            'value'=>'customer.name' 
             ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
