<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Prospect */

$this->title = 'Create Prospect';
$this->params['breadcrumbs'][] = ['label' => 'Prospects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prospect-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
