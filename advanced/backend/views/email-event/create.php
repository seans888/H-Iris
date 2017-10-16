<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EmailEvent */

$this->title = 'Create Email Event';
$this->params['breadcrumbs'][] = ['label' => 'Email Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-event-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
