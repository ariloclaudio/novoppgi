<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<!-- Main content -->
<section class="content">

    <div class="error-page">
        <h2 class="headline text-info"><i class="fa fa-warning text-yellow"></i></h2>

        <div class="error-content">
            <h3><?= $name ?></h3>

            <p>
                <?= nl2br(Html::encode($message)) ?>
            </p>

            <p>
                Ocorreu o erro acima enquanto o servidor processava sua requisição.
                Contate o administrador do sistema. Obrigado.
                Enquanto isso, você pode <a href='<?= Yii::$app->homeUrl ?>'>Retorna para sua tela principal</a>.
            </p>
        </div>
    </div>

</section>
