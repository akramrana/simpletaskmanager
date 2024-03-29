<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\BaseUrl;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <script type="application/javascript">
            var baseUrl = '<?php echo BaseUrl::home(); ?>';
            var _csrf = '<?php echo Yii::$app->request->getCsrfToken() ?>';
            var _system_date = '<?php echo date('Y-m-d') ?>';
        </script>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->name,
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-default navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    [
                        'label' => 'Home',
                        'url' => ['/site/index'],
                        'visible' => Yii::$app->user->isGuest ? false : true
                    ],
                    [
                        'label' => 'Tasks',
                        'url' => ['/task/index'],
                        'visible' => Yii::$app->user->isGuest ? false : true
                    ],
                    [
                        'label' => 'Users',
                        'url' => ['/user/index'],
                        'visible' => Yii::$app->user->isGuest ? false : true
                    ],
                    [
                        'label' => 'Admins',
                        'url' => ['/admin/index'],
                        'visible' => Yii::$app->user->isGuest ? false : true
                    ],
                    Yii::$app->user->isGuest ? (
                            ['label' => 'Login', 'url' => ['/site/login']]
                            ) : (
                            '<li>'
                            . Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton(
                                    'Logout (' . Yii::$app->user->identity->name . ')',
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
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; Akram Hossain <?= date('Y') ?></p>
            </div>
        </footer>

        <div class="global-loader">
            <div class="main-content">
                <div class="loading">
                    <img src="<?php echo BaseUrl::home() ?>images/loading-bars.svg" alt="loading"/>
                </div>
            </div>
        </div>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
