<?php
/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
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
                <title>
                    <?= Html::encode($this->title) ?>
                </title>
                <?php $this->head() ?>
        </head>

        <body>
            <?php $this->beginBody() ?>

                <div class="wrap">
                    <?php
    NavBar::begin([
      'brandLabel' => '<img src="uploads/sm.jpg" class="pull-left"/>SM Hotels and Conventions',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
 ['label' => 'Home', 'url' => ['/site/index']],
 ['label' => 'About', 'url' => ['/site/about']],
['label' => 'Room',
 'items' => [
                 ['label' => 'Overview' , 'url' => ['website/roomoverview']],

                 '<li class="dropdown-header"><a href="http://localhost/yii/web/index.php?r=website%2Flagoon">Lagoon View</a> </li>',
                 '<li class="dropdown-header"> </li>',
                 '<li class="dropdown-header"> </li>',
                 ['label' => 'Superior Room', 'url' => ['/website/superior']],
                 ['label' => 'Deluxe Room', 'url' => ['/website/deluxe']],
                 ['label' => 'Premier Room', 'url' => ['/website/premier']],
                 ['label' => 'Corner Deluxe Rooms', 'url' => ['/website/cornerdeluxe']],
                 ['label' => 'Penthouse Loft Rooms', 'url' => ['/website/penthouse']],
                '<li class="dropdown-header"> </li>',
                  '<li class="dropdown-header"><a href="http://localhost/yii/web/index.php?r=website%2Fmountain">Mountain View</a> </li>',
                 ['label' => 'Standard Room', 'url' => ['/website/standard']],
                 ['label' => 'Superior Room', 'url' => ['/website/msuperior']],
                 ['label' => 'Premier Room', 'url' => ['/website/mpremier']],
            ],],
['label' => 'Dining', 
'items' => [
                 ['label' => 'Pico Restaurant and Bar' , 'url' => ['/website/randb']],

                 ['label' => 'Reef Bar', 'url' => ['/website/reefbar']],
                 ['label' => 'B&B', 'url' => ['/website/bandb']],
                 ['label' => 'Lagoa', 'url' => ['/website/lagoa']],
                 ], ],

 ['label' => 'Spa', 
 'items' => [
                 ['label' => 'Overview' , 'url' => ['/website/spa']],
                 ['label' => 'Booking Guidelines', 'url' => ['/website/spabookguide']],
                 ], ],

 ['label' => 'Offers & Activities',
'items' => [
                 ['label' => 'Room Offers' , 'url' => ['/website/roomoffer']],
                 ['label' => 'Club Activities', 'url' => ['/website/clubactivity']],
                  ['label' => 'Promotions', 'url' => ['/website/promotions']],
                 ], ],
 ['label' => 'Events', 
  'items' => [

                 '<li class="dropdown-header"> </li>',
                 '<li class="dropdown-header">Weddings</li>',

                 ['label' => 'Pre-Wedding Activities', 'url' => ['/website/prewedding']],

                 ['label' => 'Wedding Packages', 'url' => ['/website/weddingpackage']],

                 ['label' => 'Ceremony Venues', 'url' => ['/website/ceremonyvenue']],
                 ['label' => 'Reception Venues', 'url' => ['/website/reception']],
                '<li class="dropdown-header"> </li>',
                 '<li class="dropdown-header">Corporate Meetings</li>',
                   ['label' => 'Team building Activities', 'url' => ['/website/teambuild']],

],
],
   ['label' => 'Gallery', 
    'items' => [

                  '<li class="dropdown-header"> </li>',
                 '<li class="dropdown-header">Photos</li>',

                 ['label' => 'Rooms', 'url' => ['/website/room']],

                  ['label' => 'Dining', 'url' => ['/website/dining']],

                  ['label' => 'Leisure', 'url' => ['/website/leisure']],

                 ['label' => 'Events', 'url' => ['/website/event']],

                 '<li class="dropdown-header"> </li>',
                  '<li class="dropdown-header">Videos</li>',     

 ],
 ],
   ['label' => 'Location', 'url' => ['/website/location']],

 ['label' => 'Contact', 'url' => ['/site/contact']],

    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
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
                        <p class="pull-left">&copy; My Company
                            <?= date('Y') ?>
                        </p>

                        <p class="pull-right">
                            <?= Yii::powered() ?>
                        </p>
                    </div>
                </footer>

                <?php $this->endBody() ?>
        </body>

        </html>
        <?php $this->endPage() ?>