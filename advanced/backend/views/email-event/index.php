<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EmailEventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Email Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-event-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Email Event', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'event_id',
            'email_id:email',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
