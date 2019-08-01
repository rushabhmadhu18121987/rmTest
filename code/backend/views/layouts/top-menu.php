<?php

use yii\helpers\Url;
?> 
<header class="main-header">
    <!-- Header Navbar -->
    <!-- Logo --> 

    <a href="<?= Url::to(['/']) ?>" class="logo hidden-xs"> 
        <span class="logo-lg"><b><img src="<?= Yii::$app->params['LOGO_URL'] ?>" width="120px" alt="" /></b> <?php /* Yii::$app->name */ ?></span> 
        <!-- mini logo for sidebar mini 50x50 pixels --> 
        <span class="logo-mini"><b><img src="<?= Yii::$app->params['LOGO_MINI_URL'] ?>" width="35px" alt="" /></b></span> 
        <!-- logo for regular state and mobile devices --> 
    </a> 

    <!-- Logo --> 
    <nav class="navbar navbar-static-top" role="navigation"> 
        <!-- Sidebar toggle button-->  
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"> <span class="sr-only">Toggle navigation</span> </a> 
        <!-- Navbar Right Menu --> 
        <!-- Logo --> 
        <a href="<?= Url::to(['/']) ?>" class="logo hidden-md hidden-lg" style="width:auto;"> 
            <span class="logo-lg"><b><img src="<?= Yii::$app->params['LOGO_URL'] ?>" width="150px" alt="" /></b> <?php /* Yii::$app->name */ ?></span> 
        </a> 
        <!-- Logo --> 
    </nav>
</header>