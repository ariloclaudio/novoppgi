<?php
use yii\helpers\Html;

use app\models\Edital;
use app\models\Candidato;

/* @var $this \yii\web\View */
/* @var $content string */


if(!Yii::$app->user->isGuest){
$ultima_visualizacao = Yii::$app->user->identity->visualizacao_candidatos;
$candidato = Candidato::find()->where("inicio > '".$ultima_visualizacao."'")->all(); 
$count_candidatos = count($candidato);
}


?>

<script>

    setInterval(function(){

                                var xhttp = new XMLHttpRequest();
                                xhttp.onreadystatechange = function() {
                                    if (xhttp.readyState == 4 && xhttp.status == 200) {
                                        var class1 = document.getElementsByClassName("quantidadeCandidatos");
                                        class1[0].innerHTML = xhttp.responseText;
                                        class1[1].innerHTML = xhttp.responseText;
                                    }
                                };
                                    xhttp.open("GET", "index.php?r=edital/quantidadecandidatos", true);
                                    xhttp.send();

                                var xhttp2 = new XMLHttpRequest();
                                xhttp2.onreadystatechange = function() {
                                    if (xhttp2.readyState == 4 && xhttp2.status == 200) {
                                        document.getElementById("listaCandidatos").innerHTML = xhttp2.responseText;
                                    }
                                };
                                    xhttp2.open("GET", "index.php?r=edital/listacandidatos", true);
                                    xhttp2.send();


                                var xhttp3 = new XMLHttpRequest();
                                xhttp3.onreadystatechange = function() {
                                    if (xhttp3.readyState == 4 && xhttp3.status == 200) {
                                        document.getElementById("listaEncerrados").innerHTML = xhttp3.responseText;
                                    }
                                };
                                    xhttp3.open("GET", "index.php?r=edital/listaencerrados", true);
                                    xhttp3.send();

                                var xhttp4 = new XMLHttpRequest();
                                xhttp4.onreadystatechange = function() {
                                    if (xhttp4.readyState == 4 && xhttp4.status == 200) {
                                        var class2 = document.getElementsByClassName("quantidadeEncerrados");
                                        class2[0].innerHTML = xhttp4.responseText;
                                        class2[1].innerHTML = xhttp4.responseText;
                                    }
                                };
                                    xhttp4.open("GET", "index.php?r=edital/quantidadeencerrados", true);
                                    xhttp4.send();


                            }, 1000
    );


    function zerarNotificacaoInscricoes(){

        var xhttp = new XMLHttpRequest();
            xhttp.open("GET", "index.php?r=edital/zerarnotificacaoinscricoes", true);
            xhttp.send();

    }

    function zerarNotificacaoEncerrados(){
        alert('oi');
        var xhttp = new XMLHttpRequest();
            xhttp.open("GET", "index.php?r=edital/zerarnotificacaoencerrados", true);
            xhttp.send();

    }



</script>








<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success"> <div class="quantidadeCandidatos"> </div> </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"> Número de Novas Inscrições: <div style="display: inline" class="quantidadeCandidatos"> </div> </b></li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul id="listaCandidatos" class="menu">


                            </ul>

                        </li>
                        <li class="footer"><a href="#" onclick = "zerarNotificacaoInscricoes()"> Limpar Notificações </a></li>
                    </ul>
                </li>


                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning"> <div class=" quantidadeEncerrados "> </div> </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"> Número de Inscrições Finalizadas: <div style="display: inline" class=" quantidadeEncerrados "> </div> </b></li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul id="listaEncerrados" class="menu">


                            </ul>
                            
                        </li>
                        <li class="footer"><a href="#" onclick = "zerarNotificacaoEncerrados()"> Limpar Notifições </a></li>
                    </ul>
                </li>



                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">10</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 10 notifications</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-warning text-yellow"></i> Very long description here that may
                                        not fit into the page and may cause design problems
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-red"></i> 5 new members joined
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-user text-red"></i> You changed your username
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>
                <!-- Tasks: style can be found in dropdown.less -->
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-o"></i>
                        <span class="label label-danger">9</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 9 tasks</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Design some buttons
                                            <small class="pull-right">20%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                                 role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                 aria-valuemax="100">
                                                <span class="sr-only">20% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Create a nice theme
                                            <small class="pull-right">40%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-green" style="width: 40%"
                                                 role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                 aria-valuemax="100">
                                                <span class="sr-only">40% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Some task I need to do
                                            <small class="pull-right">60%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-red" style="width: 60%"
                                                 role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                 aria-valuemax="100">
                                                <span class="sr-only">60% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Make beautiful transitions
                                            <small class="pull-right">80%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-yellow" style="width: 80%"
                                                 role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                 aria-valuemax="100">
                                                <span class="sr-only">80% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#">View all tasks</a>
                        </li>
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"> <?php if(!Yii::$app->user->isGuest){ echo Yii::$app->user->identity->nome;} ?> </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                <?php if(!Yii::$app->user->isGuest){ echo Yii::$app->user->identity->nome;}?>
                                <small>Member since Nov. 2012</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Perfil</a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sair',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>


            </ul>
        </div>
    </nav>
</header>
