<?php include '/controller/config.php';
$session = return_session(); ?>
<aside style="background-color: <?= $color; ?>"class="menu-sidebar d-none d-lg-block">
    <!-- logo -->
    <div class="logo">
        <a href="index.php?action=resume">
            <img src="view/images/icon/cu-white.png" alt="Cool Admin" />
        </a>
    </div>
    <!-- /logo -->

    <div class="menu-sidebar__content js-scrollbar1">
        <!-- useraccount picture and logout -->
        <div class="account2">
            <div class="image img-cir img-120">
                <?php if (in_array($_SESSION['online']->getrole(), array('President', 'Vice-President', 'Comptable'))) { ?>
                    <img src="view/images/icon/avatar-big-01.png" alt="John Mary" />
                <?php } else { ?>
                    <img src="view/images/icon/user-big.png" alt="John Mary" />
<?php } ?>
            </div>
            <h4 class="name"><?= $_SESSION['online']->getfullname(); ?></h4>
            <a href="index.php?action=logout"><?php echo $lang['out']; ?></a>
        </div>
        <!--/ useraccount picture and logout -->
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li class="<?php echo $index; ?>">
                    <a class="js-arrow" href="index.php?action=resume">

                        <img class="side-bullet" src="view/images/icon/resume.png" alt=""/><?php echo $lang['resume']; ?>
                    </a>
                </li>
                <li class="<?php echo $bilan; ?>">
                    <a class="js-arrow" href="index.php?action=bilan">

                        <img class="side-bullet" src="view/images/icon/journal.png" alt=""/>Bilan Financier
                    </a>
                </li>
<?php if ($session->getactive() == 'true') { ?>
                    <li style="display: block;" id="vote-js" class="<?php echo $vote; ?> animated">
                        <a class="js-arrow" href="index.php?action=vote">

                            <img class="side-bullet" src="view/images/icon/vote.png" alt=""/><?php echo $lang['vote']; ?>
                        </a>
                    </li>
<?php } else { ?>
                    <li style="display: none;" id="vote-js" class="<?php echo $vote; ?> animated">
                        <a class="js-arrow" href="index.php?action=vote">

                            <img class="side-bullet" src="view/images/icon/vote.png" alt=""/>Vote
                        </a>
                    </li>
<?php } ?>
                <li class="<?= $contribution ?>">
                    <a href="index.php?action=contributions">
                        <img class="side-bullet" src="view/images/icon/contribution.png" alt=""/><?php echo $lang['contri']; ?>
                    </a>
                </li>
                <li class="<?= $sales ?>">
                    <a href="index.php?action=sales">
                        <img class="side-bullet" src="view/images/icon/sales.png" alt=""/><?php echo $lang['sales']; ?>
                    </a>
                </li>
                <li class="has-sub <?= $loan ?>">
                    <a class="js-arrow" href="#">
                        <img class="side-bullet" src="view/images/icon/loan-32.png" alt=""/><?php echo $lang['loans']; ?>

                    </a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list">
                        <li>
                            <a href="index.php?action=loans">Crédit</a>
                        </li>
                        <li>
                            <a href="index.php?action=refund">Remboursement</a>
                        </li>
                    </ul>
                </li>
                <li class="has-sub <?= $social ?>">
                    <a class="js-arrow" href="#">
                        <img class="side-bullet" src="view/images/icon/social.png" alt=""/><?php echo $lang['fund']; ?>

                    </a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list">
                        <li>
                            <a href="index.php?action=depot">Entrée</a>
                        </li>
                        <li>
                            <a href="index.php?action=help">Crédit</a>
                        </li>
                    </ul>
                </li>
                <li class="<?php echo $spend; ?>">
                    <a href="index.php?action=spend">
                        <img class="side-bullet" src="view/images/icon/buy.png" alt=""/><?php echo $lang['exp']; ?>
                    </a>
                </li>
                <li class="<?php echo $frais; ?>">
                    <a href="index.php?action=frais">
                        <img class="side-bullet" src="view/images/icon/manage.png" alt=""/><?php echo $lang['com']; ?>
                    </a>
                </li>
                <li class="<?php echo $meal; ?>">
                    <a href="index.php?action=meal">
                        <img class="side-bullet" src="view/images/icon/meal.png" alt=""/><?php echo $lang['meal']; ?>
                    </a>
                </li>
                <li class="<?php echo $penalty; ?>">
                    <a href="index.php?action=penalty">
                        <img class="side-bullet" src="view/images/icon/law.png" alt=""/><?php echo $lang['pen']; ?>
                    </a>
                </li>
                <li class="<?php echo $rights; ?>">
                    <a href="index.php?action=rights">
                        <img class="side-bullet" src="view/images/icon/join.png" alt=""/><?php echo $lang['rights']; ?>
                    </a>
                </li>
                 <li class="<?php echo $diverse; ?>">
                    <a href="index.php?action=diverse">
                        <img class="side-bullet" src="view/images/icon/donate.png" alt=""/>Contribution div
                    </a>
                </li>
                <li class="<?php echo $member; ?>">
                    <a href="index.php?action=members">
                        <img class="side-bullet" src="view/images/icon/user.png" alt=""/><?php echo $lang['member']; ?>
                    </a>
                </li>
                <li class="<?php echo $cycles; ?>">
                    <a href="index.php?action=cycles">
                        <img class="side-bullet" src="view/images/icon/cycle.png" alt=""/><?php echo $lang['cycle']; ?>
                    </a>
                </li>
<?php if (in_array($_SESSION['online']->getrole(), array('President', 'Vice-President', 'Comptable'))) { ?>
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