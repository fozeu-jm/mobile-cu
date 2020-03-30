<?php include '/controller/config.php'; $session=return_session(); ?>
<aside class="menu-sidebar2 js-right-sidebar d-block d-lg-none ">
    <!-- logo -->
    <div style="background-color: <?= $head; ?>" class="logo">
        <a href="index.php?action=resume">
            <img src="view/images/icon/cu-white.png" alt="Cool Admin" />
        </a>
    </div>
    <!-- /logo -->

    <div class="menu-sidebar2__content js-scrollbar2">
        <!-- useraccount picture and logout -->
        <div class="account2">
            <div class="image img-cir img-120">
                <?php if(in_array($_SESSION['online']->getrole(), array('President','Vice-President','Comptable'))) {?>
                <img src="view/images/icon/avatar-big-01.png" alt="John Mary" />
                <?php }else{ ?>
                <img src="view/images/icon/user-big.png" alt="John Mary" />
                <?php } ?>
            </div>
            <h4 class="name"><?= $_SESSION['online']->getfullname();?></h4>
            <a href="index.php?action=logout">Sign out</a>
        </div>
        <!--/ useraccount picture and logout -->
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                
                <li class="<?php echo $index; ?>">
                    <a class="js-arrow" href="index.php?action=resume">
                        <img class="side-bullet" src="view/images/icon/resume.png" alt=""/>Resumé
                    </a>
                </li>
                <?php if ($session->getactive()=='true') { ?>
                    <li style="display: block;" id="mobile-js" class="<?php echo $vote; ?> animated">
                        <a class="js-arrow" href="index.php?action=vote">

                            <img class="side-bullet" src="view/images/icon/vote.png" alt=""/>Vote
                        </a>
                    </li>
                <?php } else { ?>
                    <li style="display: none;" id="mobile-js" class="<?php echo $vote; ?> animated">
                        <a class="js-arrow" href="index.php?action=vote">

                            <img class="side-bullet" src="view/images/icon/vote.png" alt=""/>Vote
                        </a>
                    </li>
                <?php } ?>
                <li class="<?= $contribution ?>">
                    <a href="index.php?action=contributions">
                        <img class="side-bullet" src="view/images/icon/contribution.png" alt=""/>Contribution
                    </a>
                </li>
                <li class="<?= $sales ?>">
                    <a href="index.php?action=sales">
                        <img class="side-bullet" src="view/images/icon/sales.png" alt=""/>Ventes
                    </a>
                </li>
                <li class="<?= $loan ?>">
                    <a href="index.php?action=loans">
                        <img class="side-bullet" src="view/images/icon/loan-32.png" alt=""/>Prêts</a>
                </li>
                <li class="has-sub <?= $social ?>">
                    <a class="js-arrow" href="#">
                        <img class="side-bullet" src="view/images/icon/social.png" alt=""/>Fond Social
                        
                    </a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list">
                        <li>
                            <a href="index.php?action=depot">Dêpot</a>
                        </li>
                        <li>
                            <a href="index.php?action=help">Aide Sociale</a>
                        </li>
                    </ul>
                </li>
                <li class="<?php echo $spend; ?>">
                    <a href="index.php?action=spend">
                        <img class="side-bullet" src="view/images/icon/buy.png" alt=""/>Depenses
                    </a>
                </li>
                <li class="<?php echo $frais; ?>">
                    <a href="index.php?action=frais">
                        <img class="side-bullet" src="view/images/icon/manage.png" alt=""/>Commissions Ts.
                    </a>
                </li>
                <li class="<?php echo $meal; ?>">
                    <a href="index.php?action=meal">
                        <img class="side-bullet" src="view/images/icon/meal.png" alt=""/>Repas
                    </a>
                </li>
                <li class="<?php echo $penalty; ?>">
                    <a href="index.php?action=penalty">
                        <img class="side-bullet" src="view/images/icon/law.png" alt=""/>Sanctions
                    </a>
                </li>
                <li class="<?php echo $rights; ?>">
                    <a href="index.php?action=rights">
                        <img class="side-bullet" src="view/images/icon/join.png" alt=""/>Droits D'Adhesion
                    </a>
                </li>
                <li class="<?php echo $member; ?>">
                    <a href="index.php?action=members">
                        <img class="side-bullet" src="view/images/icon/user.png" alt=""/>Membres
                    </a>
                </li>
                <li class="<?php echo $cycles; ?>">
                    <a href="index.php?action=cycles">
                        <img class="side-bullet" src="view/images/icon/cycle.png" alt=""/>Cycles
                    </a>
                </li>
                <li class="has-sub">
                    <a class="js-arrow" href="#">
                        <img class="side-bullet" src="view/images/icon/language.png" alt=""/>Langue
                    </a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list">
                        <li>
                          <a href="index.php?lang=fr">Français</a>
                        </li>
                        <li>
                            <a href="index.php?lang=en">English</a>
                        </li>
                        <li>
                            <a href="#">Chinese</a>
                        </li>
                    </ul>
                </li>
                <?php if(in_array($_SESSION['online']->getrole(), array('President','Vice-President','Comptable'))) {?>
                <li class="<?php echo $operation; ?>">
                    <a href="index.php?action=operation">
                        <img class="side-bullet" src="view/images/icon/spy.png" alt=""/><?php echo $lang['spy']; ?>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</aside>
