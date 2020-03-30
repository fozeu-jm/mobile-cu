<?php
$cycles = "active";
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
                                        <img  class="" src="view/images/icon/cycle-48.png" alt=""/>
                                        <h2 class="title-1 " style="display: inline; vertical-align: middle;">
                                            <span style=" border-right: 2px solid white; padding-right: 20px;" class="text-white">Cycles</span>                       
                                        </h2>
                                        <span style="color: white;; font-size: 1.6em; vertical-align: middle;">Gerer vos Cycles Tontiniers</span>
                                    </div> 

                                </div>

                            </div>
                        </div>
                    </div>
                    <!--/// *****************Filters***********************-->
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
                                    <div class="col-sm-12 col-md-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <label style="margin-left:-40px;  display:block; text-align: center;" for="search-member">Recherche par noms (President) </label>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group">

                                                    <input name="searchcyc-name" id="search-cycle" style=" display: block; border: #17a9a8 solid medium; border-radius: 40px; padding-left: 9px; height: 40px;" type="text" placeholder="Recherche..." class="form-control">

                                                    <div class="input-group-btn">
                                                        <button type="button" id="search-submit" style="margin-top:  3px;" class="btn app-color"><i class="fa fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <label style="margin-left:-40px;  display:block; text-align: center;" for="search-member">Recherche par Années </label>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group">
                                                    <select id="yr-filter" name="year-cyc" class="presi-filter  custom-select " style="border: #17a9a8 solid medium; border-radius: 40px; padding-left: 9px; height: 40px;" name="" id="">
                                                        <option value="" disabled="">Filter par année de debut de cycles</option>
                                                        <option value="" selected="">Non precisé</option>
                                                        <?php $yr = 2050;
                                                        for ($i = 0; $i < 50; $i++) { ?>
                                                            <option value="<?= $yr - $i ?>"><?= $yr - $i ?></option>
<?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input style="display: none;" type="text" name="action" value="print-cyc">
                                </form>
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
                                                    <span style="margin-top: -20px;" class="text-white">Cycles</span>                       
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
                                                            <th>President</th>
                                                            <th>Date debut</th>
                                                            <th>Date Fin</th>
                                                            <th>Status</th>
                                                            <th>Fond Initial</th>
                                                            <?php if(in_array($_SESSION['online']->getrole(), array('President','Vice-President','Comptable'))) {?>
                                                            <th>Actions</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($list as $mem) {
                                                        ?>
                                                        <tr id="select<?= $mem->getcycid(); ?>" class="animate">
                                                            <td><?= $i; ?></td>
                                                            <td> <?= $mem->getpresident(); ?> </td>
                                                            <td > <?= $mem->getbegindate(); ?> </td>
                                                            <td > <?= $mem->getenddate() ?> </td>
                                                            <?php if ($mem->getstatus() == "Active") { ?>
                                                                <td > <p style="text-align: center; color: white" class="green"><?= $mem->getstatus() ?></p>  </td>
                                                            <?php } else { ?>
                                                                <td > <p style="text-align: center; color: white" class="red"><?= $mem->getstatus() ?></p>  </td>
    <?php } ?>
                                                            <td> <?= number_format($mem->getintialfond()). ' FCFA'; ?> </td>
                                                            <?php if(in_array($_SESSION['online']->getrole(), array('President','Vice-President','Comptable'))) {?>
                                                            <td> 
                                                                <input id="actu-number1<?= $mem->getcycid(); ?>" style="display: none;" type="text" value="<?= $i ?>"/>
                                                                <button data-toggle="modal" data-target="#modalLoginForm" class="edit_cycles" id="editcyc_<?= $mem->getcycid(); ?>"  >
                                                                    <img src="view/images/icon/edit.png" alt=""/>
                                                                </button>
                                                                <button class="delete_cycles" id="delcyc_<?= $mem->getcycid(); ?>">
                                                                    <img src="view/images/icon/delete.png" alt=""/>
                                                                </button>
                                                            </td>
                                                            <?php } ?>
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
                    <?php if(in_array($_SESSION['online']->getrole(), array('President','Vice-President','Comptable'))) {?>
                    <button id="addcyc-btn" style="position: fixed; bottom: 0; right: 0px; " class="app-color btn-floating2" data-toggle="modal" data-target="#modalLoginForm">
                        <img style="padding-top: 2px; padding-left: -1px;" src="view/images/icon/add.png" alt=""/>
                    </button>
                    <?php } ?>
                    <button type="submit" form="search-form" id="printcyc-btn" style="position: fixed; bottom: 0; right: 70px; bottom: 0px;"class="app-color btn-floating2">
                        <img style="padding-top: 2px; padding-left: 2px;" src="view/images/icon/print.png" alt=""/>
                    </button>
                    <div class="row">
                        <div style="margin-top: -40px;" class="col-6">
                            Nombre Totale de cycle : <?= $nombre; ?>.
                        </div>
                        <div class="col-6">
                            <ul style="" class="pagination pagi">
                                <?php if (!isset($_GET['page'])) { ?>
                                    <li class="page-item1 "><a class="text-app-color" href="#">Prec</a></li>
                                    <?php
                                    for ($i = 1; $i <= $pagin; $i++) {
                                        if ($i == 1) {
                                            ?>
                                            <li class="active-page1 app-color"><a  class="" href="index.php?action=cycles&page=<?= $i ?>"><?= $i ?></a></li>
                                        <?php } else { ?>
                                            <li class="page-item1"><a class="text-app-color" href="index.php?action=cycles&page=<?= $i ?>"><?= $i ?></a></li>
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
                                            <li class="active-page1 app-color"><a  class="text-app-color" href="index.php?action=cycles&page=<?= $i ?>"><?= $i ?></a></li>
                                        <?php } else { ?>
                                            <li class="page-item1"><a class="text-app-color" href="index.php?action=cycles&page=<?= $i ?>"><?= $i ?></a></li>
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

        <!-- insert modal -->
        <div  class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div  class="modal-dialog" role="document">
                <div class="modal-content">
                    <div  class="header-icon app-color modal-header text-center">
                        <h4 id="modal-heading" class="modal-title text-white w-100 font-weight-bold"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="#" id="form-addcyc">
                        <div class="modal-body mx-3">
                            <div style="display: none;" class="md-form mb-5">
                                <input name="ID" type="text" id="cyc-ID" placeholder="ID" class="form-control validate">
                            </div>
                            <div class="md-form mb-4">
                                <select name="president" id="pres-id" class="form-control validate">
                                    <option value="" disabled="">Choisir Le President</option>
                                    <option value="" selected="">Non precisé</option>
<?php foreach ($list2 as $memb) { ?>
                                        <option value="<?= $memb->getmemid(); ?>"><?= $memb->getfullname() ?></option>
<?php } ?>
                                </select>
                            </div>
                            <div class="md-form mb-5">
                                <input name="begindate" type="date" id="beg-date" placeholder="Date debut" class="form-control validate">
                            </div>

                            <div class="md-form mb-5">
                                <input name="enddate" type="date" id="end-date" placeholder="Date fin" class="form-control validate">
                            </div>

                            <div class="md-form mb-4">
                                <select name="status" id="cyc-status" class="form-control validate">
                                    <option  selected value="Inactive">Statut</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Active">Active</option>
                                </select>
                            </div>

                            <div class="md-form mb-5">
                                <input name="inifond" type="text" id="ini-fond" placeholder="Fond Initiale (FCFA)" class="form-control validate">
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-center">
                            <button id="add-cyc" data-dismiss="modal" aria-label="Close" class="btn app-color">Creer</button>
                            <button style="display: none;" id="edit-cyc" data-dismiss="modal" aria-label="Close" class="btn app-color">Modifier</button>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
        <!--// insert modal -->

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