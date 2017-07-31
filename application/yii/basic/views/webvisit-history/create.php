<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\WebvisitHistory */

$this->title = 'Create Webvisit History';
$this->params['breadcrumbs'][] = ['label' => 'Webvisit Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webvisit-history-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
