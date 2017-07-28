<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MarketeerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Marketeers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marketeer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Marketeer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'marketeer_fname',
            'marketeer_mname',
            'marketeer_lname',
            'marketeer_birthdate',
            'marketeer_contact_number',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
