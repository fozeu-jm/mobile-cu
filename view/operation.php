<?php
$operation = "active";
$color = '#25c7c5';
$head = '#17a9a8';
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
            <div class="main-content">
                <div class="container-fluid">
                    <!--*****************cycle title***********************-->
                    <div style="margin-bottom: 40px;" class="row mem-title ">
                        <div class="col-sm-12">
                            <div style="height: 100px; position: relative;" class="card ">
                                <div  class="card-header02 ">
                                    <div style="text-align: center;" class="header-icon app-color" >
                                        <img  class="" src="view/images/icon/spy-48.png" alt=""/>
                                        <h2 class="title-1 " style="display: inline; vertical-align: middle;">
                                            <span style=" border-right: 2px solid white; padding-right: 20px;" class="text-white">Opérations</span>                       
                                        </h2>
                                        <span style="color: white;; font-size: 1.6em; vertical-align: middle;">Visualisation des Opérations </span>
                                    </div> 

                                </div>

                            </div>
                        </div>
                    </div>
                    <!--**************************cycle data table************************-->
                    <div style="  padding-top: 35px; overflow-x: hidden; ">
                        <input readonly="true" style="display: none;" id="verif-js" type="text" value="<?= $_SESSION['online']->getrole(); ?>">
                        <div style=" margin-bottom: 40px;" class="mem-table row mem-title">
                            <div class="col-sm-12 ">
                                <div style="" class="card ">
                                    <div  class="card-header02">
                                        <div style=" margin-bottom: 15px; height: 70px; text-align: center;" class="header-icon app-color" >
                                            <div style="margin-top: -7px;">
                                                <img  class="" src="view/images/icon/records.png" alt=""/>
                                                <h2 class="title-1 " style=" display: inline; vertical-align: middle;">
                                                    <span style="margin-top: -20px;" class="text-white hey">Opérations</span>                       
                                                </h2>
                                            </div>
                                        </div> 
                                    </div>
                                    <div  class="table-container table-responsive js-scrollbar3">
                                        <!-- start of table here -->
                                        <div style="" class="row">
                                            <div class="col-12 ">
                                                <table id="cyc-table"  class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Utilisateur</th>
                                                            <th>Operation</th>
                                                            <th>Date</th>
                                                            <th>Cible</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($list as $mem) {
                                                        ?>
                                                        <tr id="select<?= $mem->getopid(); ?>" class="animate">
                                                            <td><?= $i; ?></td>
                                                            <td> <?= $mem->getfullname(); ?> </td>
                                                            <td > <?= $mem->getname(); ?> </td>
                                                            <td > <?= $mem->getdate() ?> </td>
                                                            <td> <?= $mem->gettarget() ?> </td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                    ?>
                                                </table>
                                                <input id="last-count1" style="display: none ;" type="text" value="<?= $i; ?>" />
                                            </div>
                                        </div>
                                        <!--**** End of table ****-->
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <form style="display: none;" id="search-form" action="index.php" method="post">
                        <input value="print-operations" name="action" type="text">
                    </form>
                    <button type="submit" form="search-form" id="printcyc-btn" style="position: fixed; bottom: 0; right: 10px; bottom: 0px;"class="app-color btn-floating2">
                        <img style="padding-top: 2px; padding-left: 2px;" src="view/images/icon/print.png" alt=""/>
                    </button>
                    <div class="row">
                        <div style="margin-top: -40px;" class="col-6">
                            Nombre Totale d'Operations : <?= $nombre; ?>.
                        </div>
                        <div class="col-6">
                            <ul style="" class="pagination pagi">
                                <?php if (!isset($_GET['page'])) { ?>
                                    <li class="page-item1 "><a class="text-app-color" href="#">Prec</a></li>
                                    <?php
                                    for ($i = 1; $i <= $pagin; $i++) {
                                        if ($i == 1) {
                                            ?>
                                            <li class="active-page1 app-color"><a  class="" href="index.php?action=operation&page=<?= $i ?>"><?= $i ?></a></li>
                                        <?php } else { ?>
                                            <li class="page-item1"><a class="text-app-color" href="index.php?action=operation&page=<?= $i ?>"><?= $i ?></a></li>
                                        <?php
                                        }
                                    }
                                    ?>
                                    <li class="page-item1 "><a class="text-app-color" href="#">Suiv</a></li>
                                <?php } else { ?>
                                    <li class="page-item1 "><a class="text-app-color" href="#">Prec</a></li>
                                    <?php
                                    for ($i = 1; $i <= $pagin; $i++) {
                                        if ($i == $_GET['page']) {
                                            ?>
                                            <li class="active-page1 app-color"><a  class="text-app-color" href="index.php?action=operation&page=<?= $i ?>"><?= $i ?></a></li>
                                        <?php } else { ?>
                                            <li class="page-item1"><a class="text-app-color" href="index.php?action=operation&page=<?= $i ?>"><?= $i ?></a></li>
                                        <?php
                                        }
                                    }
                                    ?>
                                    <li class="page-item1 "><a class="text-app-color" href="#">Suiv</a></li>
                    <?php } ?>
                            </ul>
                        </div>
                    </div>
<?php include 'view/footer.php'; ?>
                </div>
            </div>
        </div>


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
        <script src="vendor/js/ajax-cycles.js"></script>
    </body>
</html>
<!-- end document-->
