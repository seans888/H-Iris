<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProspectPreference */

$this->title = 'Create Prospect Preference';
$this->params['breadcrumbs'][] = ['label' => 'Prospect Preferences', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prospect-preference-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
