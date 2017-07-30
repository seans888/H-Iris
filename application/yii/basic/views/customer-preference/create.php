<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CustomerPreference */

$this->title = 'Create Customer Preference';
$this->params['breadcrumbs'][] = ['label' => 'Customer Preferences', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-preference-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
