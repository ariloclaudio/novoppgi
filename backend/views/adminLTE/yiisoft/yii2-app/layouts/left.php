<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="img/<?= !Yii::$app->user->isGuest ? "administrador" : "guest" ?>.png" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= !Yii::$app->user->isGuest ? Yii::$app->user->identity->nome : "Visitante" ?></p>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget([
            'options' => ['class' => 'sidebar-menu'],
            'items' => [
                ['label' => 'Início','icon' => 'fa fa-home', 'url' => ['site/index'], 'visible' => !Yii::$app->user->isGuest ],
                ['label' => 'Administração', 'options' => ['class' => 'header'], 'visible' => Yii::$app->user->can('usuarios')],
                [
                    'label' => 'Usuários',
                    'icon' => 'fa fa-users',
                    'url' => '#',
                    'visible' => Yii::$app->user->can('usuarios'),
                    'items' => [
                        ['label' => 'Adicionar Usuário', 'icon' => 'fa fa-user-plus', 'url' => ['site/signup'],],
                        ['label' => 'Listar Usuários', 'icon' => 'fa fa-list', 'url' => ['user/index'],],
                    ],
                ],
                ['label' => 'Coordenação PPGI', 'options' => ['class' => 'header'], 'visible' => Yii::$app->user->can('edital')],
                [
                    'label' => 'Edital',
                    'icon' => 'fa fa-file-code-o',
                    'url' => '#',
                    'visible' => Yii::$app->user->can('edital'),
                    'items' => [
                        ['label' => 'Criar Edital', 'icon' => 'fa fa-file-code-o', 'url' => ['edital/create'],],
                        ['label' => 'Listar Editais', 'icon' => 'fa fa-list', 'url' => ['edital/index'],],
                    ],
                ],
                ['label' => 'Professor', 'options' => ['class' => 'header'], 'visible' => Yii::$app->user->can('professor')],
                ['label' => 'Professor Opção', 'icon' => 'fa fa-file-code-o', 'url' => ['site/index'], 'visible' => Yii::$app->user->can('professor'),],
                ['label' => 'Aluno', 'options' => ['class' => 'header'], 'visible' => Yii::$app->user->can('aluno')],
                ['label' => 'Aluno Opção', 'icon' => 'fa fa-file-code-o', 'url' => ['site/index'], 'visible' => Yii::$app->user->can('professor'),],
                ['label' => 'Login','icon' => 'fa fa-user', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest ],
            ],
        ]) ?>

    </section>

</aside>
