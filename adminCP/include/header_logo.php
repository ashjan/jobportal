<!DOCTYPE html>
<html>

    <head>
        <title>Job Portal | Admin</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootstrap -->
        <link rel="stylesheet" media="screen" href="<?php echo SURL . 'css/bootstrap.min.css'; ?>">
        <link rel="stylesheet" media="screen" href="<?php echo SURL . 'css/bootstrap-theme.min.css'; ?>">

        <!-- Bootstrap Admin Theme -->
        <link rel="stylesheet" media="screen" href="<?php echo SURL . 'css/bootstrap-admin-theme.css'; ?>">
        <link rel="stylesheet" media="screen" href="<?php echo SURL . 'css/bootstrap-admin-theme-change-size.css'; ?>">
        
        
        <link rel="stylesheet" media="screen" href="<?php echo SURL . 'css/main.css'; ?>">
              <link rel="stylesheet" media="screen" href="<?php echo SURL . 'css/default.css'; ?>">
        <script src="<?php echo SURL . "js/jquery_latest.js" ;?>" ></script>

<script type="text/javascript" src="<?php echo SURL . "js/bootstrap.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo SURL . "js/common.js" ?>"></script>
<script type="text/javascript" src="<?php echo SURL . "js/twitter-bootstrap-hover-dropdown.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo SURL . "js/bootstrap-admin-theme-change-size.js" ?>"></script>
<script type="text/javascript" src="<?php echo SURL . "vendors/datatables/js/jquery.dataTables.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo SURL . "js/DT_bootstrap.js" ?>"></script>
<script src='<?php echo SURL . "js/jquery.form.min.js" ?>'></script>
<script type="text/javascript" src="<?php echo SURL . "js/zebra_datepicker.js" ?>"></script>
<script type="text/javascript" src="<?php echo SURL . "js/jquery.zohoviewer.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo SURL . "js/jquery.gdocsviewer.min.js" ?>"></script>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
           <script type="text/javascript" src="js/html5shiv.js"></script>
           <script type="text/javascript" src="js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="bootstrap-admin-with-small-navbar">
        <!-- small navbar -->
        <nav class="navbar navbar-default navbar-fixed-top bootstrap-admin-navbar-sm" role="navigation">
            <div class="container">
                <div class="collapse navbar-collapse">
                    <!--                    <ul class="nav navbar-nav navbar-left bootstrap-admin-theme-change-size">
                                            <li class="text">Change size:</li>
                                            <li><a class="size-changer small">Small</a></li>
                                            <li><a class="size-changer large active">Large</a></li>
                                        </ul>-->
                    <ul class="nav navbar-nav navbar-right">

<!--                        <li>
                            <a href="#">Reminders <i class="glyphicon glyphicon-bell"></i></a>
                        </li>
                        <li>
                            <a href="#">Settings <i class="glyphicon glyphicon-cog"></i></a>
                        </li>-->
                        <li>
                            <a href="<?php echo SURL.'index.php'?>">Go to frontend <i class="glyphicon glyphicon-share-alt"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" role="button" class="dropdown-toggle" data-hover="dropdown"> <i class="glyphicon glyphicon-user"></i> Admin <i class="caret"></i></a>
                            <ul class="dropdown-menu">
<!--                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>-->
                                <!--<li role="presentation" class="divider"></li>-->
                                <li><a href="<?php echo SURL . 'logout.php'; ?>">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- main / large navbar -->
        <nav class="navbar navbar-default navbar-fixed-top bootstrap-admin-navbar bootstrap-admin-navbar-under-small" role="navigation">
            <div class="container">
                <div class="row">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".main-navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="about.html">Welcome to Job Mug`s Administration Panel</a>
                    </div>
                    <!--                    <div class="collapse navbar-collapse main-navbar-collapse">
                                            <ul class="nav navbar-nav">
                                                <li class="active"><a href="#">Link</a></li>
                                                <li><a href="#">Link</a></li>
                                                <li class="dropdown">
                                                    <a href="#" class="dropdown-toggle" data-hover="dropdown">Dropdown <b class="caret"></b></a>
                                                    <ul class="dropdown-menu">
                                                        <li role="presentation" class="dropdown-header">Dropdown header</li>
                                                        <li><a href="#">Action</a></li>
                                                        <li><a href="#">Another action</a></li>
                                                        <li><a href="#">Something else here</a></li>
                                                        <li role="presentation" class="divider"></li>
                                                        <li role="presentation" class="dropdown-header">Dropdown header</li>
                                                        <li><a href="#">Separated link</a></li>
                                                        <li><a href="#">One more separated link</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div> /.navbar-collapse -->
                </div>
            </div><!-- /.container -->
        </nav>
        <div class="container">
            <div class="row">