<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EmailActivity */

$this->title = 'Create Email Activity';
$this->params['breadcrumbs'][] = ['label' => 'Email Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-activity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
