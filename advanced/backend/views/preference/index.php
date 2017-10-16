<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PreferenceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Preferences';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preference-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Preference', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'preference_category',
            'preference_description',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
