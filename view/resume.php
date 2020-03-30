<?php
$index = "active";
$color = '#5aaffb';
$head = '#2196f3';
include '/controller/config.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Gestionaire de tontine">
        <meta name="author" content="K@IZER">
        <meta name="keywords" content="tontine credit-union credit union finance">

        <!-- Title Page-->
        <title>Tontine</title>

        <!-- Fontfaces CSS-->
        <link href="vendor/css/font-face.css" rel="stylesheet" type="text/css"/>
        <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
        <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
        <link href="vendor/css/mdb.min.css" rel="stylesheet" type="text/css"/>

        <!-- Bootstrap CSS-->
        <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

        <!-- Vendor CSS-->
        <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
        <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
        <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
        <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
        <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
        <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
        <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
        <link href="vendor/css/animate.css" rel="stylesheet" media="all">

        <!-- Main CSS-->
        <link href="vendor/css/theme.css" rel="stylesheet" media="all">

    </head>

    <body class="animsition">
        <!-- HEADER MOBILE-->
        <?php include 'view/mobile-header.php'; ?>
        <!-- END HEADER MOBILE-->

        <!--  mobile sliding menu  -->
        <?php include 'view/mobile-sidebar.php'; ?>
        <!-- end mobile sliding menu  -->

        <!-- DESKTOP MENU SIDEBAR-->
        <?php include 'view/desktop-sidebar.php'; ?>
        <!-- END MENU SIDEBAR-->


        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <?php include 'view/desktop-header.php'; ?>
            <!-- HEADER DESKTOP-->

            <!-- main-content -->
            <div class="main-content">
                <div class="container-fluid">
                    <!--*** Overview title **** -->
                    <div class="row">
                        <div  class="col-sm-12 mem-title">
                            <div style="height: 100px;" class="card ">
                                <div  class="card-header02 ">
                                    <div class="header-icon blue" style="text-align: center; ">
                                        <img class="" src="view/images/icon/overview.png" alt=""/>
                                        <h2 class="title-1 " style="display: inline; vertical-align: middle; color: white; "><?php echo $lang['rev']; ?></h2>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--///*** Overview title **** -->
                    <!--********* Over view card items ****************************************-->
                    <div class="row m-t-25">
                        <div class="col-lg-3 col-md-6 col-sm-6 bilan-item animated fadeInUp">
                            <div class="card2 card-stats ">
                                <div class="card-header02 ">
                                    <div class="card-icon orange" style="color: white;">
                                        <img src="view/images/icon/day.png" alt=""/>
                                    </div>
                                    <div style="text-align: right;">
                                        <p class="card-category" ><?php echo $lang['remain']; ?></p>
                                        <h3 class="card-title">
                                            <span><?= $reste; ?>  /  <?= $length ?></span>
                                        </h3>
                                        <h3><?php echo $lang['day']; ?> </h3>
                                    </div>
                                </div>
                                <div class="card-footer orange text-white">
                                    <div class="stats">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span><?php echo $lang['on']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 bilan-item animated fadeInUp">
                            <div class="card2 card-stats ">
                                <div class="card-header02 ">
                                    <div class="card-icon blue">
                                        <img src="view/images/icon/round user.png" alt=""/>
                                    </div>
                                    <div style="text-align: right;">
                                        <p class="card-category" ><?php echo $lang['numb']; ?></p>
                                        <h3 class="card-title">
                                            <?= $ordinary; ?> / <?= $memberno ?> <?php echo $lang['member']; ?>
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-footer blue text-white">
                                    <div class="stats">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span><?php echo $lang['to']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 bilan-item animated fadeInUp">
                            <div class="card2 card-stats ">
                                <div class="card-header02 ">
                                    <div class="card-icon green">
                                        <img src="view/images/icon/special.png" alt=""/>
                                    </div>
                                    <div style="text-align: right;">
                                        <p class="card-category" ><?php echo $lang['numb']; ?></p>
                                        <h3 class="card-title">
                                            <?= $special; ?> / <?= $memberno ?> <?php echo $lang['member']; ?>
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-footer text-white green">
                                    <div class="stats">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span><?php echo $lang['ts']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 bilan-item animated fadeInUp">
                            <div class="card2 card-stats ">
                                <div class="card-header02 ">
                                    <div class="card-icon red">
                                        <img src="view/images/icon/family.png" alt=""/>
                                    </div>
                                    <div style="text-align: right;">
                                        <p class="card-category" ><?php echo $lang['family']; ?></p>
                                        <h3 class="card-title">
                                            <?= $family; ?> / <?= $memberno ?> <?php echo $lang['member']; ?>
                                        </h3>
                                    </div>

                                </div>
                                <div class="card-footer red text-white">
                                    <div class="stats">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span><?php echo $lang['CU']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--*************second row************************-->
                        <div class="col-lg-3 col-md-6 col-sm-6 bilan-item animated fadeInUp">
                            <div class="card2 card-stats ">
                                <div class="card-header02 ">
                                    <div class="card-icon blue" style="color: white;">
                                        <img src="view/images/icon/interest.png" alt=""/>
                                    </div>
                                    <div style="text-align: right;">
                                        <p class="card-category" ><?php echo $lang['int']; ?></p>
                                        <h3 class="card-title">
                                            <span><?= number_format($TOTALINTEREST) ?></span> FCFA
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-footer blue text-white">
                                    <div class="stats">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span><?php echo $lang['to']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 bilan-item animated fadeInUp">
                            <div class="card2 card-stats ">
                                <div class="card-header02 ">
                                    <div class="card-icon green">
                                        <img src="view/images/icon/invest.png" alt=""/>
                                    </div>
                                    <div style="text-align: right;">
                                        <p class="card-category" ><?php echo $lang['int']; ?></p>
                                        <h3 class="card-title">
                                            <?= number_format($SPECIALINTEREST) ?> FCFA
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-footer green text-white">
                                    <div class="stats">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span><?php echo $lang['ts']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 bilan-item animated fadeInUp">
                            <div class="card2 card-stats ">
                                <div class="card-header02 ">
                                    <div class="card-icon orange">
                                        <img src="view/images/icon/social-48.png" alt=""/>
                                    </div>
                                    <div style="text-align: right;">
                                        <p class="card-category" ><?php echo $lang['fund']; ?></p>
                                        <h3 class="card-title">
                                            <?= number_format($social) ?> FCFA
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-footer text-white orange">
                                    <div class="stats">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span><?php echo $lang['on']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 bilan-item animated fadeInUp">
                            <div class="card2 card-stats ">
                                <div class="card-header02 ">
                                    <div class="card-icon red">
                                        <img src="view/images/icon/loan.png" alt=""/>
                                    </div>
                                    <div style="text-align: right;">
                                        <p class="card-category" ><?php echo $lang['loans']; ?></p>
                                        <h3 class="card-title">
                                            <?= number_format($LOANS) ?> FCFA
                                        </h3>
                                    </div>

                                </div>
                                <div class="card-footer red text-white">
                                    <div class="stats">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span><?php echo $lang['on']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--////********* Over view card items ****************************************-->

                    <!--********* Graph card items ****************************************-->
                    <!--*** Overview title **** -->
                    <div class="row">
                        <div style="margin-top: 60px; margin-bottom: 30px;" class="col-sm-12">
                            <div style="height: 100px;" class="card ">
                                <div  class="card-header02 ">
                                    <div class="header-icon blue" style="text-align: center; ">
                                        <img class="" src="view/images/icon/stats-48.png" alt=""/>
                                        <h2 class="title-1 " style="display: inline; vertical-align: middle; color: white; "><?php echo $lang['stats']; ?></h2>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--///*** Overview title **** -->
                    <div class="row testo">
                        <div class=" offset-md-2  col-sm-8 graph-container">
                            <div class="card card-chart">
                                <div class="card-header02 card-header-success">
                                    <div class="graph-item purple">
                                        <canvas id="barchart"></canvas>
                                    </div>

                                </div>
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo $lang['salesper']; ?></h4>
                                    <p class="card-category">
                                        <span class="text-success"><?php echo $lang['perf']; ?></span></p>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="zmdi zmdi-time"></i> <?php echo $lang['to']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="offset-md-2 col-sm-8 graph-container">
                            <div class="card card-chart">
                                <div class="card-header02 card-header-success">
                                    <div class="graph-item orange">
                                        <canvas id="barchart2"></canvas>
                                    </div>

                                </div>
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo $lang['exp']; ?></h4>
                                    <p class="card-category">
                                        <span class="text-success"><?php echo $lang['perf']; ?></span></p>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="zmdi zmdi-time"></i> Tontine
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /// ********* Graph card items ****************************************-->
                    <button type="fixedsubmit-btn" form="search-form" id="printcyc-btn" style="position: fixed; bottom: 0; right: 0px; bottom: 0px;"class="blue btn-floating2">
                        <img style="padding-top: 2px; padding-left: 2px;" src="view/images/icon/print.png" alt=""/>
                    </button>
                    <?php include 'view/footer.php'; ?>
                </div>
            </div>
            <!--/ main-content -->
            <div id="toast">
                <img src="view/images/icon/ok.png" alt=""/>
            </div>
        </div>
        <!-- Jquery JS-->
        <script src="vendor/jquery-3.2.1.min.js"></script>
        <!-- Bootstrap JS-->
        <script src="vendor/bootstrap-4.1/popper.min.js"></script>
        <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
        <!-- Vendor JS       -->
        <script src="vendor/slick/slick.min.js">
        </script>
        <script src="vendor/wow/wow.min.js"></script>
        <script src="vendor/animsition/animsition.min.js"></script>
        <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
        </script>
        <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
        <script src="vendor/counter-up/jquery.counterup.min.js">
        </script>
        <script src="vendor/circle-progress/circle-progress.min.js"></script>
        <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
        <script src="vendor/chartjs/Chart.bundle.min.js"></script>
        <script src="vendor/select2/select2.min.js"></script>
        <!-- Main JS-->
        <script src="vendor/js/main.js"></script>
        <script src="vendor/js/ajax-graph.js"></script>
    </body>
</html>
<!-- end document-->
