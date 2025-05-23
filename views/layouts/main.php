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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php
    $session = Yii::$app->session;
    if ($session->has('refreshTime')) {
      $refreshTime = $session->get('refreshTime');
    } else {
      $refreshTime = 60;
      $session->set('refreshTime','60');          
    }
?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<p>'.Html::img('@web/VSA-IT_Services_New_Logo_Blue2_Rechts_PNG.png', 
                                  ['alt'=>Yii::$app->name,'width' => '100px', 'height' => '24px']) . '&nbsp;&nbsp;BaseLine</p>',
        'brandOptions' => ['width' => '250px', 'height' => '24px'],
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Auswertungen', 'items' => [['label' => 'Disk', 'url' => ['/server-view/over_disk']],
                                                  ['label' => 'Network', 'url' => ['/server-view/over_net']],
                                                  ['label' => 'Wartung', 'url' => ['/site/wartung']],
                                                  ]
            ],
            ['label' => 'Stammdaten', 'items' => [['label' => 'Server', 'url' => ['/server-data/index']],
                                                  ['label' => 'Config', 'url' => ['/config-data/index']],
                                                  ['label' => 'PerfMon-Defaults', 'url' => ['/perf-counter-default/index']],
                                                  ['label' => 'PerfMon-Defaults per Server', 'url' => ['/perf-counter-per-server/index']]                                                
                                                  ]
            ],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ?
                ['label' => 'Login', 'url' => ['/site/login']] :
                [
                    'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ],
        ],
    ]);
    NavBar::end();
    ?>


    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
<div class="row">        
  <div class="round-time-bar col-lg-10" data-style="smooth" style="--duration: <?=$refreshTime?>;">
    <div></div>
  </div>
  <div class="col-lg-1"><?=$refreshTime?> Sec. </div>
</div>
<style type="text/css">

.round-time-bar {
  margin: 1rem;
  overflow: hidden;
}
.round-time-bar div {
  height: 5px;
  animation: roundtime calc(var(--duration) * 1s) steps(var(--duration))
    forwards;
  transform-origin: left center;
  background: linear-gradient(to bottom, blue, #900);
}

.round-time-bar[data-style="smooth"] div {
  animation: roundtime calc(var(--duration) * 1s) linear forwards;
}

.round-time-bar[data-style="fixed"] div {
  width: calc(var(--duration) * 5%);
}

.round-time-bar[data-color="blue"] div {
  background: linear-gradient(to bottom, #64b5f6, #1565c0);
}

@keyframes roundtime {
  to {
    /* More performant than `width` */
    transform: scaleX(0);
  }
}

</style>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; IT Services <?= date('Y') ?><?= Yii::getVersion() ?></p>

        <p class="pull-right"><?= Yii::powered() ?> </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
