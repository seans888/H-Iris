<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProspectEmail */

$this->title = 'Create Prospect Email';
$this->params['breadcrumbs'][] = ['label' => 'Prospect Emails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prospect-email-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
