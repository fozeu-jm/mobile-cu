<?php
//session_start();
$vote = "active";
$month = array('Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre');
$color = '#5aaffb';
$head = '#2196f3';
?>
<!DOCTYPE html>
<html lang="fr">

    <head>
        <!-- Required meta tags-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="au theme template">
        <meta name="author" content="Hau Nguyen">
        <meta name="keywords" content="au theme template">

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

        <!-- Main CSS-->
        <link href="vendor/css/theme.css" rel="stylesheet" media="all">

    </head>

    <body style="position: relative;" class="animsition">

        <!-- DESKTOP MENU SIDEBAR-->
        <?php include 'view/desktop-sidebar.php'; ?>
        <!-- END MENU SIDEBAR-->

        <!-- HEADER MOBILE-->
        <?php include 'view/mobile-header.php'; ?>
        <!-- END HEADER MOBILE-->

        <!--  mobile sliding menu  -->
        <?php include 'view/mobile-sidebar.php'; ?>
        <!-- end mobile sliding menu  -->



        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <?php include 'view/desktop-header.php'; ?>
            <!-- HEADER DESKTOP-->
            <div class="main-content">
                <div class="container-fluid">
                    <!--*****************cycle title***********************-->
                    <div style="margin-bottom: 130px;" class="row mem-title ">
                        <div class="col-sm-12">
                            <div style="height: 100px; position: relative;" class="card ">
                                <div  class="card-header02 ">
                                    <div style="text-align: center;" class="header-icon blue" >
                                        <img  class="" src="view/images/icon/stats-48.png" alt=""/>
                                        <h2 class="title-1 " style="display: inline; vertical-align: middle;">
                                            <span style=" border-right: 2px solid white; padding-right: 20px;" class="text-white">Votes</span>                       
                                        </h2>
                                        <span style="color: white;; font-size: 1.6em; vertical-align: middle;">Résultats De la Session de Votes</span>
                                    </div> 

                                </div>

                            </div>
                        </div>
                    </div>
                    <!--/// *****************cycle title***********************-->
                    <?php if (!is_bool($cycle12)) { ?>
                        <!--**************vote cards****************************************************-->
                        <div style="margin-bottom: 40px; " id="electoral-js" class="row mem-title ">
                           <div class="offset-md-2 col-sm-8 graph-container">
                            <div class="card card-chart">
                                <div class="card-header02 card-header-success">
                                    <div class="graph-item blue">
                                        <canvas id="barchart2"></canvas>
                                    </div>

                                </div>
                                <div class="card-body">
                                    <h4 class="card-title">Résultats</h4>
                                    <p class="card-category">
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="zmdi zmdi-time"></i> Election
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>

                        <?php include 'view/footer.php'; ?>
                    </div>


                    <?php
                } else {
                    echo '<p style="color:red; text-align:center; font-weight:bold;">Your vote has being taken into consideration.Thanks For voting !!</p>';
                }
                ?>
                <div class="" id="throbber" style="display: none;">
                    <img src="view/circle-loader.gif" width="200" height="200" alt="circle-loader"/>
                </div>
                <div id="toast">
                    <img src="view/images/icon/ok.png" alt=""/>
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
                <script src="vendor/js/jquery.blockUI.js" type="text/javascript"></script>
                <script src="vendor/select2/select2.min.js"></script>
                <!-- Main JS-->
                <script src="vendor/js/main.js"></script>
                <script src="vendor/js/ajax-results.js"></script>
                </body>
                </html>
                <!-- end document-->

