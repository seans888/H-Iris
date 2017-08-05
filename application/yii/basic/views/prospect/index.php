<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProspectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Prospects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prospect-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Prospect', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'prospect_email:email',
            'prospect_fname',
            'prospect_mname',
            'prospect_lname',
             'prospect_contact_number',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
