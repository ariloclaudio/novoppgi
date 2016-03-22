<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="img/<?= !Yii::$app->user->isGuest ? strtolower(Yii::$app->user->identity->descricaoPerfil()) : "guest" ?>.png" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= !Yii::$app->user->isGuest ? Yii::$app->user->identity->nome : "Visitante" ?></p>
                <?= !Yii::$app->user->isGuest ? Yii::$app->user->identity->descricaoPerfil() : "" ?></a>

            </div>
        </div>

        <?= dmstr\widgets\Menu::widget([
            'options' => ['class' => 'sidebar-menu'],
            'items' => [
                ['label' => 'Seleção PPGI', 'options' => ['class' => 'header']],
                ['label' => 'Início','icon' => 'fa fa-home', 'url' => ['/site'], 'visible' => !Yii::$app->user->isGuest ],
                ['label' => 'Edital', 'icon' => 'fa fa-file-code-o', 'url'=>['/edital'], 'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->perfil != 5],
                ['label' => 'Login','icon' => 'fa fa-user', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest ],
                [
                    'label' => 'Usuários',
                    'icon' => 'fa fa-users',
                    'url' => '#',
                    'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->perfil == 1,
                    'items' => [
                        ['label' => 'Adicionar Usuário', 'icon' => 'fa fa-user-plus', 'url' => ['site/signup'],],
                        ['label' => 'Listar Usuários', 'icon' => 'fa fa-list', 'url' => ['user/index'],],
                    ],
                ],
            ],
        ]) ?>

    </section>

</aside>
