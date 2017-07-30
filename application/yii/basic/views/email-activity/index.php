<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmailActivitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Email Activities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-activity-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Email Activity', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'email_activity_status:email',
            'email_activity_date:email',
            'emai_activity_time',
            'email_id:email',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
