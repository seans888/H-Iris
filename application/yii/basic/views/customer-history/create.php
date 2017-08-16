<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CustomerHistory */

$this->title = 'Create Customer History';
$this->params['breadcrumbs'][] = ['label' => 'Customer Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-history-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
