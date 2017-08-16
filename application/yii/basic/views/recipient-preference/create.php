<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RecipientPreference */

$this->title = 'Create Recipient Preference';
$this->params['breadcrumbs'][] = ['label' => 'Recipient Preferences', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipient-preference-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
