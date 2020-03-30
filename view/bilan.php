<?php
$bilan = "active";
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
                                        <img  class="" src="view/images/icon/journal-48.png" alt=""/>
                                        <h2 class="title-1 " style="display: inline; vertical-align: middle;">
                                            <span style=" border-right: 2px solid white; padding-right: 20px;" class="text-white">Bilan</span>                       
                                        </h2>
                                        <span style="color: white;; font-size: 1.6em; vertical-align: middle;">Généreration Des Bilans</span>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/// *****************Filters***********************-->
                    <?php if (!is_bool($cycle12)) { ?>
                        <div style="margin-bottom: 40px;"  class="row mem-filt">
                            <div class="col col-sm-12">
                                <div class="card2  ">
                                    <div class="card-header02 ">
                                        <div class="card-icon app-color" style="padding: 2px; color: white;">
                                            <img src="view/images/icon/filter.png" alt=""/>
                                        </div>    
                                    </div>
                                    <div class="row">
                                        <div style="margin-top: -10px; margin-bottom: 10px;" class="col-sm-12">
                                            <div style="text-align: center;">
                                                <p><h3>Recherche</h3></p>                                            
                                            </div>
                                        </div>
                                    </div>
                                    <form class="row" id="search-form" method="post" action="index.php">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label style="margin-left:-40px;  display:block; text-align: center;" for="search-member">Recherche par Mois </label>
                                                </div>
                                                <div class="col-12">
                                                    <div class="input-group">
                                                        <select id="search-index2" name="search-month" class="presi-filter  custom-select " style="border: #17a9a8 solid medium; border-radius: 40px; padding-left: 9px; height: 40px;" name="" id="">
                                                            <option value="" disabled="">Filter par mois</option>
                                                            <option value="" selected="">Non precisé</option>
                                                            <?php foreach ($months as $item) { ?>
                                                                <option value="<?= key($item) ?>"><?= $item[key($item)] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input style="display: none;" type="text" name="action" value="print-bilan">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--**************Loans datatable****************************************************-->
                        <div style="  padding-top: 35px; overflow-x: hidden; ">
                            <div style=" margin-bottom: 40px;" class="mem-table row mem-title">
                                <input readonly="true" style="display: none;" id="verif-js" type="text" value="<?= $_SESSION['online']->getrole(); ?>">
                                <div class="col-sm-12 ">
                                    <div style="" class="card ">
                                        <div  class="card-header02">
                                            <div style=" margin-bottom: 15px; height: 70px; text-align: center;" class="header-icon app-color" >
                                                <div style="margin-top: -7px;">
                                                    <img  class="" src="view/images/icon/records.png" alt=""/>
                                                    <h2 class="title-1 " style=" display: inline; vertical-align: middle;">
                                                        <span style="margin-top: -20px;" class="text-white">Bilan</span>                       
                                                    </h2>
                                                </div>
                                            </div> 
                                        </div>
                                        <div  class="table-container table-responsive js-scrollbar3">
                                            <!-- start of table here -->
                                            <div style="" class="row">
                                                <div class="col-12 ">
                                                  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--**************Fixed floating buttons****************************************************-->
                       
                        <button type="fixedsubmit-btn" form="search-form" id="printcyc-btn" style="position: fixed; bottom: 0; right: 0px; bottom: 0px;"class="app-color btn-floating2">
                            <img style="padding-top: 2px; padding-left: 2px;" src="view/images/icon/print.png" alt=""/>
                        </button>
                     
                        <?php include 'view/footer.php'; ?>
                    </div>
                    <?php
                } else {
                    echo '<p style="color:red; text-align:center; font-weight:bold;">Pas de cycles Activé. Veuillez activer un cycle dans la section cycle pour pouvoir continué.</p>';
                }
                ?>
                <div class="" id="throbber" style="display: none;">
                    <img src="view/circle-loader.gif" width="200" height="200" alt="circle-loader"/>
                </div>
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
            <script src="vendor/js/jquery.blockUI.js" type="text/javascript"></script>
            <script src="vendor/select2/select2.min.js"></script>
            <!-- Main JS-->
            <script src="vendor/js/main.js"></script>
    </body>
</html>
<!-- end document-->

