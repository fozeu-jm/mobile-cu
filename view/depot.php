<?php
$social = "active";
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
                                    <div style="text-align: center;" class="header-icon blue" >
                                        <img  class="" src="view/images/icon/social-48.png" alt=""/>
                                        <h2 class="title-1 " style="display: inline; vertical-align: middle;">
                                            <span style=" border-right: 2px solid white; padding-right: 20px;" class="text-white">Fond Sociale</span>                       
                                        </h2>
                                        <span style="color: white;; font-size: 1.6em; vertical-align: middle;">Gestion Du Fond Sociale</span>
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
                                        <div class="card-icon blue" style="padding: 2px; color: white;">
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
                                                    <label style="margin-left:-40px;  display:block; text-align: center;" for="search-member">Recherche par noms </label>
                                                </div>
                                                <div class="col-12">

                                                    <div class="input-group">

                                                        <input name="search-name" id="search-index1" style=" display: block; border: #22c4d8 solid medium; border-radius: 40px; padding-left: 9px; height: 40px;" type="text" placeholder="Recherche..." class="form-control">

                                                        <div class="input-group-btn">
                                                            <button type="button" id="search-submit" style="margin-top:  3px;" class="btn blue"><i class="fa fa-search"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label style="margin-left:-40px;  display:block; text-align: center;" for="search-member">Recherche par Mois </label>
                                                </div>
                                                <div class="col-12">
                                                    <div class="input-group">
                                                        <select id="search-index2" name="search-month" class="presi-filter  custom-select " style="border: #22c4d8 solid medium; border-radius: 40px; padding-left: 9px; height: 40px;" name="" id="">
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
                                        <input style="display: none;" type="text" name="action" value="print-depot">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--**************fondscoial entry datatable****************************************************-->
                        <div style="  padding-top: 35px; overflow-x: hidden; ">
                            <div style=" margin-bottom: 40px;" class="mem-table row mem-title">
                                <input readonly="true" style="display: none;" id="verif-js" type="text" value="<?= $_SESSION['online']->getrole(); ?>">
                                <div class="col-sm-12 ">
                                    <div style="" class="card ">
                                        <div  class="card-header02">
                                            <div style=" margin-bottom: 15px; height: 70px; text-align: center;" class="header-icon blue" >
                                                <div style="margin-top: -7px;">
                                                    <img  class="" src="view/images/icon/records.png" alt=""/>
                                                    <h2 class="title-1 " style=" display: inline; vertical-align: middle;">
                                                        <span style="margin-top: -20px;" class="hey text-white">Fond Sociale</span>                       
                                                    </h2>
                                                </div>
                                            </div> 
                                        </div>
                                        <div  class="table-container table-responsive js-scrollbar3">
                                            <!-- start of table here -->
                                            <div style="" class="row">
                                                <div class="col-12 ">
                                                    <table id="table-js"  class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Noms Complet</th>
                                                                <th>Situation F.</th>
                                                                <th >Tontine O.</th>
                                                                <th>Date</th>
                                                                <th>Montant</th>
                                                                <?php if (in_array($_SESSION['online']->getrole(), array('President', 'Vice-President', 'Comptable'))) { ?>
                                                                    <th>Action</th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($list as $con) {
                                                            ?>
                                                            <tr id="select<?= $con->getsfid() ?>" class="animate">
                                                                <td><?= $i; ?></td>
                                                                <td > <?= $con->getfullname(); ?> </td>
                                                                <td > <?= $con->getfamilysituation() ?> </td>
                                                                <td > <?= $con->getordinarysharesno() ?> </td>
                                                                <td > <?= $con->getdate() ?> </td>
                                                                <td > <?= number_format($con->getamount()) . ' FCFA' ?> </td>
                                                                <?php if (in_array($_SESSION['online']->getrole(), array('President', 'Vice-President', 'Comptable'))) { ?>
                                                                    <td> 
                                                                        <input id="actu-number1<?= $con->getsfid() ?>" style="display: none;" type="text" value="<?= $i ?>"/>
                                                                        <button data-toggle="modal" data-target="#modalLoginForm" class="edit_cycles" id="editcyc_<?= $con->getsfid() ?>"  >
                                                                            <img src="view/images/icon/edit.png" alt=""/>
                                                                        </button>
                                                                        <button class="delete_cycles" id="delcyc_<?= $con->getsfid() ?>">
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
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                        <!--**************Fixed floating buttons****************************************************-->
                        <?php if (in_array($_SESSION['online']->getrole(), array('President', 'Vice-President', 'Comptable'))) { ?>
                            <button id="fixedadd-btn" style="position: fixed; bottom: 0; right: 0px; " class="blue btn-floating2" data-toggle="modal" data-target="#modalLoginForm">
                                <img style="padding-top: 2px; padding-left: -1px;" src="view/images/icon/add.png" alt=""/>
                            </button>
                        <?php } ?>
                        <button type="fixedsubmit-btn" form="search-form" id="printcyc-btn" style="position: fixed; bottom: 0; right: 70px; bottom: 0px;"class="blue btn-floating2">
                            <img style="padding-top: 2px; padding-left: 2px;" src="view/images/icon/print.png" alt=""/>
                        </button>
                        <!--**************Pagination buttons****************************************************-->
                        <div class="row">
                            <div style="margin-top: -40px;" class="col-6">
                                Nombre Totale de ventes : <?= $nombre; ?>.
                            </div>
                            <div class="col-6">
                                <ul style="" class="pagination pagi">
                                    <?php if (!isset($_GET['page'])) { ?>
                                        <li class="page-item1 "><a class="text-blue" href="#">Prec</a></li>
                                        <?php
                                        for ($i = 1; $i <= $pagin; $i++) {
                                            if ($i == 1) {
                                                ?>
                                                <li class="active-page1 blue"><a  class="" href="index.php?action=depot&page=<?= $i ?>"><?= $i ?></a></li>
                                            <?php } else { ?>
                                                <li class="page-item1"><a class="text-blue" href="index.php?action=depot&page=<?= $i ?>"><?= $i ?></a></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <li class="page-item1 "><a class="text-blue" href="#">Suiv</a></li>
                                    <?php } else { ?>
                                        <li class="page-item1 "><a class="text-blue" href="#">Prec</a></li>
                                        <?php
                                        for ($i = 1; $i <= $pagin; $i++) {
                                            if ($i == $_GET['page']) {
                                                ?>
                                                <li class="active-page1 blue"><a  class="text-blue" href="index.php?action=depot&page=<?= $i ?>"><?= $i ?></a></li>
                                            <?php } else { ?>
                                                <li class="page-item1"><a class="text-blue" href="index.php?action=depot&page=<?= $i ?>"><?= $i ?></a></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <li class="page-item1 "><a class="text-blue" href="#">Suiv</a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <?php include 'view/footer.php'; ?>
                    </div>

                    <!-- insert modal -->
                    <div  class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div  class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div  class="header-icon blue modal-header text-center">
                                    <h4 id="modal-heading" class="modal-title text-white w-100 font-weight-bold"></h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span class="text-white" aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="#" id="modal-js">
                                    <div class="modal-body mx-3">
                                        <fieldset class="form-group">
                                            <legend visible="true" style="width: auto; font-size: 16px;">Information Membre</legend>
                                            <div>
                                                <select name="mem-id" id="mem-js" class="form-control validate">
                                                    <option value="" disabled="">Choisir le membre voulant effectué un versement</option>
                                                    <option value="" selected="">Non precisé</option>
                                                    <?php foreach ($list2 as $memb) { ?>
                                                        <option value="<?= $memb->getmemid() . '_' . $memb->getordinarysharesno() . '_' . $memb->getfamilysituation() ?>"><?= $memb->getfullname() ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="md-form mb-5">
                                                <label style="margin-top: -35px;" for="dep-date">Situation f</label>
                                                <input readonly="true" value="0" type="number" id="sf-js" class="form-control validate" >
                                            </div>
                                            <div class="md-form mb-5">
                                                <label style="margin-top: -35px;" for="dep-date">Tontine O</label>
                                                <input readonly="true" value="0" type="number" id="to-js" class="form-control validate" >
                                            </div>
                                            <div class="md-form mb-5">
                                                <label style="margin-top: -35px;" for="dep-date">Montant de base</label>
                                                <input readonly="true" value="<?= $resultat ?>" type="number" id="base-js" class="form-control validate" >
                                            </div>
                                        </fieldset>
                                        <div style="display: none;" class="md-form mb-5">
                                            <input name="ID" type="text" id="ID-JS" placeholder="ID" class="form-control validate">
                                        </div>
                                        <div class="md-form mb-5">
                                            <label style="margin-top: -35px;" for="dep-date">Montant</label>
                                            <input name="amount" value="0" type="number" id="amount-js" class="form-control validate" >
                                        </div>

                                        <div class="md-form mb-5">
                                            <label style="margin-top: -35px;" for="dep-date">Date </label>
                                            <input value="<?= date("Y-m-d"); ?>"  name="date" type="date" id="date-js" placeholder="" class="form-control validate">
                                        </div>

                                        <div class="md-form mb-4">
                                            <select name="active" id="active-js" class="form-control validate">
                                                <option value="<?= $cycle12->getcycid() ?>"><?= $cycle12->getbegindate() . ' ==> ' . $cycle12->getenddate() ?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="modal-footer d-flex justify-content-center">
                                        <button id="modaladd-js" data-dismiss="modal" aria-label="Close" class="btn blue">Creer</button>
                                        <button style="display: none;" id="modaledit-js" data-dismiss="modal" aria-label="Close" class="btn blue">Modifier</button>
                                    </div>
                                </form> 
                            </div>
                        </div>
                    </div>
                    <!--// insert modal -->
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
        <script src="vendor/js/ajax-depot.js"></script>
    </body>
</html>
<!-- end document-->

