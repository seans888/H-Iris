<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Marketeer */

$this->title = 'Create Marketeer';
$this->params['breadcrumbs'][] = ['label' => 'Marketeers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marketeer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
