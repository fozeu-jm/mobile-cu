<?php
$member = "active";
$color = '#b32dca';
$head = '#9c27b0';
?>
<!DOCTYPE html>
<html lang="en">

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

            <!--  **************************************** main-content ****************************************************-->
            <div class="main-content">
                <div class="container-fluid">
                    <!--*****************user title***********************-->
                    <div style="margin-bottom: 40px;" class="row mem-title ">
                        <div class="col-sm-12">
                            <div style="height: 100px; position: relative;" class="card ">
                                <div  class="card-header02 ">
                                    <div style="text-align: center;" class="header-icon purple" >
                                        <img  class="" src="view/images/icon/member-title.png" alt=""/>
                                        <h2 class="title-1 " style="display: inline; vertical-align: middle;">
                                            <span style=" border-right: 2px solid white; padding-right: 20px;" class="text-white">Membres</span>                       
                                        </h2>
                                        <span style="color: white;; font-size: 1.6em; vertical-align: middle;">Gerer vos membres</span>
                                    </div> 

                                </div>

                            </div>
                        </div>
                    </div>
                    <!--/// *****************user title***********************-->

                    <!--*****************filter input***********************-->
                    <div style="margin-bottom: 40px;"  class="row mem-filt">
                        <div class="col col-sm-12">
                            <div class="card2  ">
                                <div class="card-header02 ">
                                    <div class="card-icon purple" style="padding: 2px; color: white;">
                                        <img src="view/images/icon/filter.png" alt=""/>
                                    </div>    
                                </div>
                                <div class="row">
                                    <div style="margin-top: -10px; margin-bottom: 10px;" class="col-sm-12">
                                        <div style="text-align: center;">
                                            <p><h3>Filtres</h3></p>                                            
                                        </div>
                                    </div>
                                </div>

                                <form class="row" id="searchmem-nameform" method="post" action="index.php">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="row">
                                            <div class="col-12">
                                                <label style="margin-left:-40px;  display:block; text-align: center;" for="search-member">Recherche par noms</label>
                                            </div>
                                            <div class="col-12">

                                                <div class="input-group">

                                                    <input name="searchmem-name" id="search-member" style=" display: block; border: #9d36b3 solid medium; border-radius: 40px; padding-left: 9px; height: 40px;" type="text" placeholder="Recherche..." class="form-control">

                                                    <div class="input-group-btn">
                                                        <button type="button" id="search-submit" style="margin-top:  3px;" class="btn purple"><i class="fa fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="row">
                                            <div class="col-12">
                                                <label style="margin-left:-40px;  display:block; text-align: center;" for="to-filter">Tontine Ordinaire</label>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group">
                                                    <select id="to-filter" name="dropdown-to" class="selectmem-filter  custom-select " style="border: #9d36b3 solid medium; border-radius: 40px; padding-left: 9px; height: 40px;" name="" id="">
                                                        <option value="" disabled="" >Filtres par nombre de parts</option>
                                                        <option value="" selected="">Non precisé</option>
                                                        <?php for ($i = 0; $i <= 10; $i++) { ?>
                                                            <option value="<?= $i ?>"><?= $i ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="col-sm-12 col-md-4">
                                        <div class="row">
                                            <div class="col-12">
                                                <label style="margin-left:-40px;  display:block; text-align: center;" for="ts-filter">Tontine Spéciale</label>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group">
                                                    <select id="ts-filter" name="dropdown-ts" placeholder="hum" class="selectmem-filter browser-default custom-select mb-4" style="border: #9d36b3 solid medium; border-radius: 40px; padding-left: 9px; height: 40px;" name="" id="">
                                                        <option value="" disabled="" >Filtres par nombre de parts</option>
                                                        <option value="" selected="">Non precisé</option>
                                                        <?php for ($i = 0; $i <= 10; $i++) { ?>
                                                            <option value="<?= $i ?>"><?= $i ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>

                                                </div>

                                            </div>

                                        </div>
                                    </div> 
                                    <input style="display: none;" type="text" name="action" value="print-mem">
                                </form>

                            </div>
                        </div>

                    </div>
                    <!--/// *****************filter input***********************-->

                    <!--*****************Member table entry*********************-->
                    <div style="  padding-top: 35px; overflow-x: hidden; ">
                        <input readonly="true" style="display: none;" id="verif-js" type="text" value="<?= $_SESSION['online']->getrole(); ?>">
                        <div style=" margin-bottom: 40px;" class="mem-table row mem-title">
                            <div class="col-sm-12 ">
                                <div style="" class="card ">
                                    <div  class="card-header02">
                                        <div style=" margin-bottom: 15px; height: 70px; text-align: center;" class="header-icon purple" >
                                            <div style="margin-top: -7px;">
                                                <img  class="" src="view/images/icon/records.png" alt=""/>
                                                <h2 class="title-1 " style=" display: inline; vertical-align: middle;">
                                                    <span style="margin-top: -20px;" class="text-white">Membres</span>                       
                                                </h2>
                                            </div>
                                        </div> 
                                    </div>
                                    <div  class="table-container table-responsive js-scrollbar3">
                                        <!-- start of table here -->
                                        <div style="" class="row">
                                            <div class="col-12 ">
                                                <table id="mem-table"  class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Nom Complet</th>
                                                            <th>Role</th>
                                                            <th>Situation F.</th>
                                                            <th>N° Tel</th>
                                                            <th>Adresse</th>
                                                            <th>Tontine O.</th>
                                                            <th>Tontine S.</th>
                                                            <th>Utilisateur</th>
                                                            <?php if(in_array($_SESSION['online']->getrole(), array('President','Vice-President','Comptable'))) {?>
                                                            <th>Actions</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($list as $mem) {
                                                        ?>
                                                        <tr id="select<?= $mem->getmemid(); ?>" class="animate">
                                                            <td><?= $i; ?></td>
                                                            <td> <?= $mem->getfullname(); ?> </td>
                                                            <td > <?= $mem->getrole(); ?> </td>
                                                            <td style="text-align: center;" > <?= $mem->getfamilysituation(); ?> </td>
                                                            <td> <?= $mem->gettelno(); ?> </td>
                                                            <td> <?= $mem->getadresse(); ?> </td>
                                                            <td style="text-align: center;"> <?= $mem->getordinarysharesno(); ?> </td>
                                                            <td style="text-align: center;" > <?= $mem->getspecialsharesno(); ?></td>
                                                            <td> <?= $mem->getusername(); ?> </td>
                                                            <?php if(in_array($_SESSION['online']->getrole(), array('President','Vice-President','Comptable'))) { ?>
                                                            <td> 
                                                                <input id="actu-number<?= $mem->getmemid(); ?>" style="display: none;" type="text" value="<?= $i ?>"/>
                                                                <button class="edit_member" id="edit_<?= $mem->getmemid(); ?>" data-toggle="modal" data-target="#modalLoginForm">
                                                                    <img src="view/images/icon/edit.png" alt=""/>
                                                                </button>
                                                                <button class="delete_member" id="delete_<?= $mem->getmemid(); ?>">
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
                                                <input id="last-count" style="display: none ;" type="text" value="<?= $i; ?>" />
                                            </div>
                                        </div>
                                        <!--**** End of table ****-->
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ************************fixed buttons***************************************************-->
                    <?php if(in_array($_SESSION['online']->getrole(), array('President','Vice-President','Comptable'))) {?>
                    <button id="add-btn" style="position: fixed; bottom: 0; right: 0px; " class="purple btn-floating2" data-toggle="modal" data-target="#modalLoginForm">
                        <img style="padding-top: 2px; padding-left: 6px;" src="view/images/icon/user.png" alt=""/>
                    </button>
                    <?php } ?>
                    <button type="submit" form="searchmem-nameform" id="printmem-btn" style="position: fixed; bottom: 0; right: 70px; bottom: 0px;"class="purple btn-floating2">
                        <img style="padding-top: 2px; padding-left: 2px;" src="view/images/icon/print.png" alt=""/>
                    </button>
                    <div class="row">
                        <div style="margin-top: -40px;" class="col-6">
                            Nombre Totale de membre : <?= $nombre; ?>.
                        </div>
                        <div class="col-6">
                            <ul style="" class="pagination pagi">
                                <?php if (!isset($_GET['page'])) { ?>
                                    <li class="page-item1 "><a class="text-purple" href="#">Prec</a></li>
                                    <?php for ($i = 1; $i <= $pagin; $i++) {
                                        if ($i == 1) {
                                            ?>
                                            <li class="active-page"><a  class="text-purple" href="index.php?action=members&page=<?= $i?>"><?= $i ?></a></li>
                                        <?php } else { ?>
                                            <li class="page-item1"><a class="text-purple" href="index.php?action=members&page=<?= $i?>"><?= $i ?></a></li>
                                    <?php } } ?>
                                    <li class="page-item1 "><a class="text-purple" href="#">Suiv</a></li>
                                    <?php }else {?>
                                    <li class="page-item1 "><a class="text-purple" href="#">Prec</a></li>
                                    <?php for ($i = 1; $i <= $pagin; $i++) { 
                                        if ($i == $_GET['page']) {
                                            ?>
                                            <li class="active-page"><a  class="text-purple" href="index.php?action=members&page=<?= $i?>"><?= $i ?></a></li>
                                             <?php } else { ?>
                                            <li class="page-item1"><a class="text-purple" href="index.php?action=members&page=<?= $i?>"><?= $i ?></a></li>
                                    <?php } } ?>
                                            <li class="page-item1 "><a class="text-purple" href="#">Suiv</a></li>
                                    <?php }  ?>
                                </ul>
                            </div>
                       
                        </div>

                        <?php include 'view/footer.php'; ?>
                    </div>

                </div>
                <!--/// **************************************** main-content ****************************************************-->
            </div>
            <!--******************************Modals*****************************************************-->
            <!-- insert modal -->
            <div  class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div  class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div  class="header-icon purple modal-header text-center">
                            <h4 id="modal-heading" class="modal-title text-white w-100 font-weight-bold"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span class="text-white" aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="#" id="form-addmem">
                            <div class="modal-body mx-3">
                                <div style="display: none;" class="md-form mb-5">
                                    <input name="ID" type="text" id="mem-ID" placeholder="ID" class="form-control validate">
                                </div>
                                <div class="md-form mb-5">
                                    <input name="fullname" type="text" id="mem-name" placeholder="Noms Complet" class="form-control validate">
                                </div>

                                <div class="md-form mb-4">
                                    <input name="adresse" type="text" id="mem-adresse" placeholder="Adresse" class="form-control validate">
                                </div>

                                <div class="md-form mb-4">
                                    <input name="tel" type="text" id="mem-tel" placeholder="N° Tel" class="form-control validate">
                                </div>

                                <div class="md-form mb-4">
                                    <select name="role" id="mem-role" class="form-control validate">
                                        <option  selected value="Membre">Role</option>
                                        <option value="Membre">Membre</option>
                                        <option value="President">President</option>
                                        <option value="Comptable">Comptable</option>
                                        <option value="Vice-president">Vice-president</option>
                                        <option value="Censeur">Censeur</option>

                                    </select>
                                </div>

                                <div class="md-form mb-4">
                                    <select name="sf" id="mem-sf" class="form-control validate">
                                        <option selected value="0">Situation Familiale</option>
                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="md-form mb-4">
                                    <select name="to" type="password" id="mem-to" class="form-control validate">
                                        <option  selected value="1">Parts Tontine Oridinaire</option>
                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="md-form mb-4">
                                    <select name="ts" type="password" id="mem-ts" class="form-control validate">
                                        <option selected value="0">Parts Tontine Speciale</option>
                                        <?php for ($i = 0; $i <= 5; $i++) { ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php
                                        }
                                        ?>
                                </select>
                            </div>
                            <div class="md-form mb-5">
                                <input name="username" type="text" id="mem-username" placeholder="Noms d'utilisateur" class="form-control validate">
                            </div>
                            <div class="md-form mb-5">
                                <input name="pass" type="password" id="mem-pass" placeholder="Mot de passe" class="form-control validate">
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-center">
                            <button id="add-mem" data-dismiss="modal" aria-label="Close" class="btn purple">Ajouter</button>
                            <button style="display: none;" id="edit-mem" data-dismiss="modal" aria-label="Close" class="btn purple">Modifier</button>
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
        <script src="vendor/js/ajax.js"></script>
    </body>
</html>
<!-- end document-->
