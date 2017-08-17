
<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

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
    
      'brandLabel' => '<img src="uploads/sm.jpg" class="pull-left"/>SM Hotels and Convention',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About Us', 'url' => ['/site/about']],


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
         
 ['label' => 'Offers & activities',
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
 ['label' => 'Forms', 
  'items' => [
                ['label' => 'Employees', 'url' => ['/employee/index']],

                 '<li class="dropdown-header"> </li>',
                 '<li class="dropdown-header">Email</li>',
                
                 ['label' => 'Email', 'url' => ['/email/index']],
                 
                 ['label' => 'Event', 'url' => ['/event/index']],
             
                 ['label' => 'Template', 'url' => ['/template/index']],

                 ['label' => 'Activity', 'url' => ['/activity/index']],

                '<li class="dropdown-header"> </li>',
                 '<li class="dropdown-header">Customers</li>',

                   ['label' => 'Customer', 'url' => ['customer/index']],
                   ['label' => 'Customer History', 'url' => ['/customer-history/index']],
                    ['label' => 'Preference', 'url' => ['/preference/index']],

                
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
          //  ['label' => 'Email', 'url' => ['/email/index']],
            
            // Yii::$app->user->isAdmin ? (
           /** [
            'label' => 'Forms',
            'items' => [
                 ['label' => 'Email', 'url' => ['/email/index']],
                 '<li class="divider"></li>',
                 //'<li class="dropdown-header">Dropdown Header</li>',
                 ['label' => 'Marketeer', 'url' => ['/marketeer/index']],
                  '<li class="divider"></li>',
                 ['label' => 'Activity', 'url' => ['/activity/index']],
                 '<li class="divider"></li>',
                 ['label' => 'Customer', 'url' => ['/customer/index']],
                 '<li class="divider"></li>',
                 ['label' => 'Customer History', 'url' => ['/customer-history/index']]

                 
            ],
        ], **/
        //)


            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?> 

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container1">
        <p class="pull-left">&copy; SM Hotels and Convention Corporation <?= date('Y') ?></p>
 <img src="uploads/fb.png" style="width: 45px; height: 45px;">
 <img src="uploads/twitter.png" style="width: 45px; height: 45px;">
 <img src="uploads/insta.png" style="width: 45px; height: 45px;">
 <a href="">
       
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
