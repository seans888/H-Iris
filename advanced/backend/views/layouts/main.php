<?php
/* @var $this \yii\web\View */
/* @var $content string */
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
                    <?php
    NavBar::begin([
      'brandLabel' => 'SM Hotels and Conventions',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'Reports', 'url' => ['/site/reports']],
        ['label' => 'Mailer', 'url' => ['/edm/frontend/web/index.php']],



    [

             'label' => 'Forms', 
                'items' => [
                ['label' => 'Employees', 'url' => ['/employee/index']],

                 '<li class="dropdown-header"> </li>',
                 '<li class="dropdown-header">Email</li>',
                
                 ['label' => 'Email', 'url' => ['/email/index']],
                 
                 ['label' => 'Event', 'url' => ['/event/index']],

                 ['label' => 'Email Event', 'url' => ['/email-event/index']],
             
                 ['label' => 'Template', 'url' => ['/template/index']],

                 ['label' => 'Activity', 'url' => ['/activity/index']],

                '<li class="dropdown-header"> </li>',
                '<li class="dropdown-header">Customers</li>',

                 ['label' => 'Customer', 'url' => ['customer/index']],

                 ['label' => 'Customer History', 'url' => ['/customer-history/index']],

                 ['label' => 'Web-visit History', 'url' => ['/webvisit-history/index']],

                 ['label' => 'Preference', 'url' => ['/preference/index']],

                 ['label' => 'Customer Preference', 'url' => ['/customer-preference/index']],

                
],
],
        ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; SM Hotels and Convention Corporation <?= date('Y') ?></p>

    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>