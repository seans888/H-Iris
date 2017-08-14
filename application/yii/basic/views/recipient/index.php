<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RecipientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recipients';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipient-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Recipient', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'recipient_type',
            'recipient_email:email',
            'recipient_fname',
            'recipient_mname',
            'recipient_lname',
            'recipient_contact_number',
           
            'customer.information',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
