<?php $session = return_session(); ?>
<header style="background-color: <?= $head; ?>" class="header-desktop ">
    <input id="default-js" style="display: none;" value="<?= $session->getactive() ?>" type="text">
    <div class="section__content section__content--p30">
        <div  class="container-fluid">
            <div style="float: right;" class="header-wrap">

                <div class="header-button">

                    <div class="  account-wrap">
                        <div class="  account-item clearfix js-item-menu">

                            <div class="  content">
                                <a class="js-acc-btn" href="#"><i class="zmdi zmdi-menu"></i></a>
                            </div>
                            <!--*************************************-->
                            <div class="account-dropdown js-dropdown">
                                <div class="info clearfix">
                                    <div class="image">
                                        <a href="#">
                                            <?php if (in_array($_SESSION['online']->getrole(), array('President', 'Vice-President', 'Comptable'))) { ?>
                                                <img src="view/images/icon/avatar-01.png" alt="John Doe" />
                                            <?php } else { ?>
                                                <img src="view/images/icon/user-sm.png" alt="John Mary" />
                                            <?php } ?>
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5 class="name">
                                            <a href="#"><?= $_SESSION['online']->getfullname(); ?></a>
                                        </h5>
                                        <span class="email"><?= $_SESSION['online']->getrole(); ?></span>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="index.php?action=members">
                                            <i class="zmdi zmdi-account"></i>Account</a>
                                    </div>

                                    <div class="account-dropdown__item">
                                        <a href="index.php?lang=fr">
                                            <img style="margin-right: 15px;" src="view/images/icon/french.png"/> Français</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="index.php?lang=en">
                                            <img style="margin-right: 17px;" src="view/images/icon/britain.png"/> English</a>
                                    </div>

                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <img style="margin-right: 17px;" src="view/images/icon/china.png"/> Chinese</a>
                                    </div>
                                    <?php if(in_array($_SESSION['online']->getrole(), array('President','Vice-President','Comptable'))) {?>
                                    <div class="account-dropdown__item">
                                        <?php if ($session->getactive() == "false") { ?>
                                            <a id="activate" href="#">
                                                <img style="margin-right: 17px;" src="view/images/icon/vote-16.png"/> Activate Vote Session
                                            </a>
                                        <?php } else { ?>
                                            <a id="disable" href="#">
                                                <img style="margin-right: 17px;" src="view/images/icon/vote-16.png"/> Disable Vote Session
                                            </a>
                                        <?php } ?>
                                    </div>

                                    <div class="account-dropdown__item">
                                        <a href="index.php?action=results">
                                            <img style="margin-right: 17px;" src="view/images/icon/glaph.png"/> Display Voting Results
                                        </a>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="account-dropdown__footer">
                                    <a href="index.php?action=logout">
                                        <i class="zmdi zmdi-power"></i>Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>