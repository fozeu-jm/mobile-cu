<?php

require 'controller/controller.php';
session_start();

try {
    if (isset($_SESSION['online']) || isset($_POST['action'])) {
        if (isset($_SESSION['online']) && !isset($_POST['action']) && !isset($_GET['action'])) {
            resume_page();
        }
        if (isset($_GET['action']) || isset($_POST['action'])) {
            if (isset($_GET['action']) && $_GET['action'] == "members") {
                if (isset($_GET['page'])) {
                    members_scroll($_GET['page']);
                } else {
                    members_page();
                }
            }

            if (isset($_GET['action']) && $_GET['action'] == "logout") {
                logout();
            }

            if (isset($_GET['action']) && $_GET['action'] == "resume") {
                resume_page();
            }


            if (isset($_GET['action']) && $_GET['action'] == "getmem") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $memb = get_member($_GET['id']);
                    if (is_null($memb)) {
                        echo 'problem with the query';
                    } else {
                        echo json_encode($memb);
                    }
                }
            }

            if (isset($_GET['action']) && $_GET['action'] == "delmem") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    if (delete_member($_GET['id'])) {
                        echo 'Success';
                    } else {
                        echo 'problem with the query';
                    }
                }
            }


            if (isset($_GET['action']) && $_GET['action'] == "cycles") {
                if (isset($_GET['page'])) {
                    cycles_scroll($_GET['page']);
                } else {
                    cycle_page();
                }
            }


            if (isset($_GET['action']) && $_GET['action'] == "getcyc") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $cyc = get_cycle($_GET['id']);
                    if (is_null($cyc)) {
                        echo 'problem with the query';
                    } else {
                        echo json_encode($cyc);
                    }
                }
            }
            if (isset($_GET['action']) && $_GET['action'] == "delcyc") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    if (del_cycle($_GET['id'])) {
                        
                    } else {
                        echo 'problem with the query';
                    }
                }
            }
            if (isset($_GET['action']) && $_GET['action'] == "contributions") {
                if (isset($_GET['page'])) {
                    contri_scroll($_GET['page']);
                } else {
                    contribution_page();
                }
            }
            if (isset($_GET['action']) && $_GET['action'] == "getcontri") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo get_cont($_GET['id']);
                }
            }

            if (isset($_GET['action']) && $_GET['action'] == "delcontri") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo del_contri($_GET['id']);
                }
            }
            if (isset($_GET['action']) && $_GET['action'] == "loans") {
                if (isset($_GET['page'])) {
                    loan_scroll($_GET['page']);
                } else {
                    loan_page();
                }
            }
            if (isset($_GET['action']) && $_GET['action'] == "getloan") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo get_loan($_GET['id']);
                }
            }
            if (isset($_GET['action']) && $_GET['action'] == "del-loan") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo del_loan($_GET['id']);
                }
            }
            if (isset($_GET['action']) && $_GET['action'] == "sales") {
                if (isset($_GET['page'])) {
                    sales_scroll($_GET['page']);
                } else {
                    sales_page();
                }
            }
            if (isset($_GET['action']) && $_GET['action'] == "getsales") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo get_sales($_GET['id']);
                }
            }
            if (isset($_GET['action']) && $_GET['action'] == "del-sales") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo del_sales($_GET['id']);
                }
            }

            if (isset($_GET['action']) && $_GET['action'] == "sales-mon") {
                echo sales_month();
            }
            if (isset($_GET['action']) && $_GET['action'] == "help") {
                if (isset($_GET['page'])) {
                    help_scroll($_GET['page']);
                } else {
                    help_page();
                }
            }
            if (isset($_GET['action']) && $_GET['action'] == "gethelp") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo get_help($_GET['id']);
                }
            }
            if (isset($_GET['action']) && $_GET['action'] == "del-help") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo del_help($_GET['id']);
                }
            }
            if (isset($_GET['action']) && $_GET['action'] == "meal") {
                if (isset($_GET['page'])) {
                    meal_scroll($_GET['page']);
                } else {
                    meal_page();
                }
            }
            if (isset($_GET['action']) && $_GET['action'] == "getmeal") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo get_meal($_GET['id']);
                }
            }
            if (isset($_GET['action']) && $_GET['action'] == "del-meal") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo del_meal($_GET['id']);
                }
            }
            if (isset($_GET['action']) && $_GET['action'] == "penalty") {
                if (isset($_GET['page'])) {
                    pen_scroll($_GET['page']);
                } else {
                    penalty_page();
                }
            }

            if (isset($_GET['action']) && $_GET['action'] == "getpen") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo get_pen($_GET['id']);
                }
            }

            if (isset($_GET['action']) && $_GET['action'] == "del-pen") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo del_pen($_GET['id']);
                }
            }

            if (isset($_GET['action']) && $_GET['action'] == "rights") {
                if (isset($_GET['page'])) {
                    right_scroll($_GET['page']);
                } else {
                    rights_page();
                }
            }

            if (isset($_GET['action']) && $_GET['action'] == "getright") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo get_right($_GET['id']);
                }
            }

            if (isset($_GET['action']) && $_GET['action'] == "del-right") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo del_right($_GET['id']);
                }
            }

            if (isset($_GET['action']) && $_GET['action'] == "spend") {
                if (isset($_GET['page'])) {
                    spend_scroll($_GET['page']);
                } else {
                    spend_page();
                }
            }
            if (isset($_GET['action']) && $_GET['action'] == "getspend") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo get_spend($_GET['id']);
                }
            }
            if (isset($_GET['action']) && $_GET['action'] == "del-spend") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo del_spend($_GET['id']);
                }
            }

            if (isset($_GET['action']) && $_GET['action'] == "exp-month") {
                echo exp_month();
            }

            if (isset($_GET['action']) && $_GET['action'] == "frais") {
                if (isset($_GET['page'])) {
                    comission_scroll($_GET['page']);
                } else {
                    frais_page();
                }
            }

            if (isset($_GET['action']) && $_GET['action'] == "getcom") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo get_com($_GET['id']);
                }
            }
            if (isset($_GET['action']) && $_GET['action'] == "del-com") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo del_com($_GET['id']);
                }
            }

            if (isset($_GET['action']) && $_GET['action'] == "depot") {
                if (isset($_GET['page'])) {
                    depot_scroll($_GET['page']);
                } else {
                    depot_page();
                }
            }

            if (isset($_GET['action']) && $_GET['action'] == "getdepot") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo get_depot($_GET['id']);
                }
            }
            if (isset($_GET['action']) && $_GET['action'] == "del-depot") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo del_depot($_GET['id']);
                }
            }

            if (isset($_GET['action']) && $_GET['action'] == "operation") {
                if (isset($_GET['page'])) {
                    operation_scroll($_GET['page']);
                } else {
                    operation_page();
                }
            }

            if (isset($_GET['action']) && $_GET['action'] == "activate") {
                echo edit_state("true");
            }

            if (isset($_GET['action']) && $_GET['action'] == "disable") {
                echo edit_state("false");
            }

            if (isset($_GET['action']) && $_GET['action'] == "get-session") {
                echo get_session();
            }

            if (isset($_GET['action']) && $_GET['action'] == "vote") {
                vote_page();
            }

            if (isset($_GET['action']) && $_GET['action'] == "results") {
                result_page();
            }

            if (isset($_GET['action']) && $_GET['action'] == "display-res") {
                echo resultat_vote();
            }

            if (isset($_GET['action']) && $_GET['action'] == "refund") {
                if (isset($_GET['page'])) {
                    refund_scroll($_GET['page']);
                } else {
                    refund_page();
                }
            }

            if (isset($_GET['action']) && $_GET['action'] == "getrefund") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo get_refund($_GET['id']);
                }
            }

            if (isset($_GET['action']) && $_GET['action'] == "del-refund") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo del_refund($_GET['id']);
                }
            }

            if (isset($_GET['action']) && $_GET['action'] == "diverse") {
                if (isset($_GET['page'])) {
                    diverse_scroll($_GET['page']);
                } else {
                    diverse_page();
                }
            }

            if (isset($_GET['action']) && $_GET['action'] == "getdiv") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo get_diverse($_GET['id']);
                }
            }

            if (isset($_GET['action']) && $_GET['action'] == "del-diverse") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    echo del_div($_GET['id']);
                }
            }

            if (isset($_GET['action']) && $_GET['action'] == "bilan") {
                bilan_page();
            }

            /*             * ****************POST AJAX*********************************** */
            if (isset($_POST['action']) && $_POST['action'] == "add-member") {
                $param = array(
                    'fullname' => strtoupper($_POST['fullname']),
                    'adresse' => $_POST['adresse'],
                    'tel' => $_POST['tel'],
                    'role' => $_POST['role'],
                    'family' => $_POST['sf'],
                    'to' => $_POST['to'],
                    'ts' => $_POST['ts'],
                    'username' => $_POST['username'],
                    'pass' => $_POST['pass']
                );
                echo insert_mem($param);
            }
            if (isset($_POST['action']) && $_POST['action'] == "edit-member") {
                $param = array(
                    'ID' => $_POST['ID'],
                    'fullname' => $_POST['fullname'],
                    'adresse' => $_POST['adresse'],
                    'tel' => $_POST['tel'],
                    'role' => $_POST['role'],
                    'family' => $_POST['sf'],
                    'to' => $_POST['to'],
                    'ts' => $_POST['ts'],
                    'username' => $_POST['username'],
                    'pass' => $_POST['pass']
                );
                if (edit_member($param)) {
                    echo 'successful';
                } else {
                    echo 'problem with query';
                }
            }

            if (isset($_POST['action']) && $_POST['action'] == "searchmem-name") {
                $par = array(
                    'name' => strtoupper($_POST['searchmem-name']),
                    'to' => $_POST['dropdown-to'],
                    'ts' => $_POST['dropdown-ts']
                );
                $list = searchmember_name($par);
                echo json_encode($list);
            }
            if (isset($_POST['action']) && $_POST['action'] == "print-mem") {
                $par = array(
                    'name' => strtoupper($_POST['searchmem-name']),
                    'to' => $_POST['dropdown-to'],
                    'ts' => $_POST['dropdown-ts']
                );
                print_member($par);
            }
            if (isset($_POST['action']) && $_POST['action'] == "add-cyc") {
                $param = array(
                    'president' => $_POST['president'],
                    'begindate' => $_POST['begindate'],
                    'enddate' => $_POST['enddate'],
                    'status' => $_POST['status'],
                    'inifond' => $_POST['inifond']
                );
                echo insert_cyc($param);
            }
            if (isset($_POST['action']) && $_POST['action'] == "edit-cycle") {
                $param = array(
                    'ID' => $_POST['ID'],
                    'president' => strtoupper($_POST['president']),
                    'begindate' => $_POST['begindate'],
                    'enddate' => $_POST['enddate'],
                    'status' => $_POST['status'],
                    'inifond' => $_POST['inifond']
                );
                echo edit_cycle($param);
            }
            if (isset($_POST['action']) && $_POST['action'] == "search-cyc") {
                $param = array(
                    'president' => strtoupper($_POST['searchcyc-name']),
                    'year' => $_POST['year-cyc'],
                );
                $list = searchCycle($param);
                echo json_encode($list);
            }
            if (isset($_POST['action']) && $_POST['action'] == "print-cyc") {
                $par = array(
                    'president' => strtoupper($_POST['searchcyc-name']),
                    'year' => $_POST['year-cyc'],
                );
                print_cycles($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "add-contri") {
                $par = array(
                    'member' => $_POST['member'],
                    'ordinary' => $_POST['ordinary'],
                    'special' => $_POST['special'],
                    'date' => $_POST['date'],
                    'month' => $_POST['month'],
                    'meal' => $_POST['meal'],
                    'active' => $_POST['active'],
                    'label' => $_POST['label']
                );
                echo insert_contri($par);
            }
            if (isset($_POST['action']) && $_POST['action'] == "edit-contri") {
                $par = array(
                    'ID' => $_POST['ID'],
                    'member' => $_POST['member'],
                    'ordinary' => $_POST['ordinary'],
                    'special' => $_POST['special'],
                    'date' => $_POST['date'],
                    'month' => $_POST['month'],
                    'meal' => $_POST['meal'],
                    'label' => $_POST['label']
                );
                echo edit_contri($par);
            }
            if (isset($_POST['action']) && $_POST['action'] == "search-contri") {
                $par = array(
                    'name' => strtoupper($_POST['search-name']),
                    'month' => $_POST['search-month'],
                    'type' => $_POST['search-type']
                );
                echo searchContri($par);
            }
            if (isset($_POST['action']) && $_POST['action'] == "print-contri") {
                $par = array(
                    'name' => strtoupper($_POST['search-name']),
                    'month' => $_POST['search-month'],
                    'type' => $_POST['search-type']
                );
                print_contri($par);
            }
            if (isset($_POST['action']) && $_POST['action'] == "add-loan") {
                $par = array(
                    'member' => $_POST['member'],
                    'amount' => $_POST['amount'],
                    'rate' => $_POST['rate'],
                    'date' => $_POST['date'],
                    'check' => $_POST['check'],
                    'active' => $_POST['active']
                );
                echo insert_loan($par);
            }
            if (isset($_POST['action']) && $_POST['action'] == "edit-loan") {
                $par = array(
                    'ID' => $_POST['ID'],
                    'member' => $_POST['member'],
                    'amount' => $_POST['amount'],
                    'rate' => $_POST['rate'],
                    'interest' => $_POST['interest'],
                    'date' => $_POST['date'],
                    'refund' => $_POST['refund'],
                    'status' => $_POST['status'],
                    'check' => $_POST['check'],
                    'active' => $_POST['active'],
                    'account' => $_POST['account']
                );
                echo edit_loan($par);
            }
            if (isset($_POST['action']) && $_POST['action'] == "search-loan") {
                $par = array(
                    'name' => strtoupper($_POST['search-name']),
                    'month' => $_POST['search-month'],
                );
                echo searchloan($par);
            }
            if (isset($_POST['action']) && $_POST['action'] == "print-loans") {
                $par = array(
                    'name' => strtoupper($_POST['search-name']),
                    'month' => $_POST['search-month'],
                );
                print_loan($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "add-sales") {
                $par = array(
                    'member' => $_POST['member'],
                    'amount' => $_POST['amount'],
                    'sell' => $_POST['sell'],
                    'check' => $_POST['check'],
                    'date' => $_POST['date'],
                    'tontine' => $_POST['tontine'],
                    'active' => $_POST['active'],
                );
                echo insert_sales($par);
            }
            if (isset($_POST['action']) && $_POST['action'] == "edit-sales") {
                $par = array(
                    'ID' => $_POST['ID'],
                    'member' => $_POST['member'],
                    'amount' => $_POST['amount'],
                    'sell' => $_POST['sell'],
                    'check' => $_POST['check'],
                    'date' => $_POST['date'],
                    'tontine' => $_POST['tontine'],
                    'active' => $_POST['active']
                );
                echo edit_sales($par);
            }
            if (isset($_POST['action']) && $_POST['action'] == "search-sales") {
                $par = array(
                    'name' => strtoupper($_POST['search-name']),
                    'month' => $_POST['search-month'],
                    'tontine' => $_POST['search-tontine']
                );
                echo searchsales($par);
            }
            if (isset($_POST['action']) && $_POST['action'] == "print-sales") {
                $par = array(
                    'name' => strtoupper($_POST['search-name']),
                    'month' => $_POST['search-month'],
                    'tontine' => $_POST['search-tontine']
                );
                print_sales($par);
            }
            if (isset($_POST['action']) && $_POST['action'] == "add-help") {
                $par = array(
                    'member' => $_POST['member'],
                    'amount' => $_POST['amount'],
                    'check' => $_POST['check'],
                    'date' => $_POST['date'],
                    'active' => $_POST['active'],
                    'reason' => $_POST['reason'],
                );
                echo insert_help($par);
            }
            if (isset($_POST['action']) && $_POST['action'] == "edit-help") {
                $par = array(
                    'ID' => $_POST['ID'],
                    'member' => $_POST['member'],
                    'amount' => $_POST['amount'],
                    'check' => $_POST['check'],
                    'date' => $_POST['date'],
                    'active' => $_POST['active'],
                    'reason' => $_POST['reason'],
                );
                echo edit_help($par);
            }
            if (isset($_POST['action']) && $_POST['action'] == "search-help") {
                $par = array(
                    'name' => strtoupper($_POST['search-name']),
                    'month' => $_POST['search-month'],
                );
                echo searchhelp($par);
            }
            if (isset($_POST['action']) && $_POST['action'] == "print-help") {
                $par = array(
                    'name' => strtoupper($_POST['search-name']),
                    'month' => $_POST['search-month'],
                );
                print_help($par);
            }
            if (isset($_POST['action']) && $_POST['action'] == "add-meal") {
                $par = array(
                    'member' => $_POST['member'],
                    'amount' => $_POST['amount'],
                    'check' => $_POST['check'],
                    'date' => $_POST['date'],
                    'active' => $_POST['active'],
                );
                echo insert_meal($par);
            }
            if (isset($_POST['action']) && $_POST['action'] == "edit-meal") {
                $par = array(
                    'ID' => $_POST['ID'],
                    'member' => $_POST['member'],
                    'amount' => $_POST['amount'],
                    'check' => $_POST['check'],
                    'date' => $_POST['date'],
                    'active' => $_POST['active'],
                );
                echo edit_meal($par);
            }
            if (isset($_POST['action']) && $_POST['action'] == "search-meal") {
                $par = array(
                    'name' => strtoupper($_POST['search-name']),
                    'month' => $_POST['search-month'],
                );
                echo searchmeal($par);
            }
            if (isset($_POST['action']) && $_POST['action'] == "print-meal") {
                $par = array(
                    'name' => strtoupper($_POST['search-name']),
                    'cycle' => $_POST['search-month'],
                );
                print_meal($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "add-pen") {
                $par = array(
                    'member' => $_POST['member'],
                    'amount' => $_POST['amount'],
                    'date' => $_POST['date'],
                    'active' => $_POST['active'],
                    'reason' => $_POST['reason'],
                );
                echo insert_pen($par);
            }
            if (isset($_POST['action']) && $_POST['action'] == "edit-pen") {
                $par = array(
                    'ID' => $_POST['ID'],
                    'member' => $_POST['member'],
                    'amount' => $_POST['amount'],
                    'date' => $_POST['date'],
                    'active' => $_POST['active'],
                    'reason' => $_POST['reason']
                );
                echo edit_pen($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "search-pen") {
                $par = array(
                    'name' => strtoupper($_POST['search-name']),
                    'month' => $_POST['search-month'],
                );
                echo searchpen($par);
            }
            if (isset($_POST['action']) && $_POST['action'] == "print-penalty") {
                $par = array(
                    'name' => strtoupper($_POST['search-name']),
                    'month' => $_POST['search-month'],
                );
                print_pen($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "add-rights") {
                $par = array(
                    'member' => $_POST['member'],
                    'amount' => $_POST['amount'],
                    'date' => $_POST['date'],
                    'active' => $_POST['active'],
                );
                echo insert_rights($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "edit-right") {
                $par = array(
                    'ID' => $_POST['ID'],
                    'member' => $_POST['member'],
                    'amount' => $_POST['amount'],
                    'date' => $_POST['date'],
                    'active' => $_POST['active']
                );
                echo edit_right($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "search-rights") {
                $par = array(
                    'name' => strtoupper($_POST['search-name']),
                    'month' => $_POST['search-month'],
                );
                echo searchrights($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "print-rights") {
                $par = array(
                    'name' => strtoupper($_POST['search-name']),
                    'month' => $_POST['search-month'],
                );
                print_rights($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "add-spend") {
                $par = array(
                    'amount' => $_POST['amount'],
                    'check' => $_POST['check'],
                    'date' => $_POST['date'],
                    'active' => $_POST['active'],
                    'reason' => strtoupper($_POST['reason']),
                );
                echo insert_spend($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "edit-spend") {
                $par = array(
                    'ID' => $_POST['ID'],
                    'amount' => $_POST['amount'],
                    'check' => $_POST['check'],
                    'date' => $_POST['date'],
                    'active' => $_POST['active'],
                    'reason' => strtoupper($_POST['reason']),
                );
                echo edit_spend($par);
            }
            if (isset($_POST['action']) && $_POST['action'] == "search-spend") {
                $par = array(
                    'name' => strtoupper($_POST['search-name']),
                    'month' => $_POST['search-month']
                );
                echo searchspend($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "print-spend") {
                $par = array(
                    'name' => strtoupper($_POST['search-name']),
                    'month' => $_POST['search-month']
                );
                print_spend($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "add-com") {
                $par = array(
                    'amount' => $_POST['amount'],
                    'rate' => $_POST['rate'],
                    'active' => $_POST['active'],
                );
                echo insert_com($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "edit-com") {
                $par = array(
                    'ID' => $_POST['ID'],
                    'amount' => $_POST['amount'],
                    'rate' => $_POST['rate'],
                    'active' => $_POST['active'],
                );
                echo edit_com($par);
            }
            if (isset($_POST['action']) && $_POST['action'] == "search-com") {
                $par = array(
                    'cycle' => $_POST['search-cycle']
                );
                echo searchcom($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "print-com") {
                $par = array(
                    'cycle' => $_POST['search-cycle']
                );
                print_com($par);
            }



            if (isset($_POST['action']) && $_POST['action'] == "add-refund") {
                $par = array(
                    'amount' => $_POST['amount'],
                    'date' => $_POST['date'],
                    'active' => $_POST['active'],
                    'label' => $_POST['label'],
                    'loanid' => $_POST['loanid']
                );
                echo insert_refund($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "edit-refund") {
                $par = array(
                    'ID' => $_POST['ID'],
                    'amount' => $_POST['amount'],
                    'date' => $_POST['date'],
                    'active' => $_POST['active'],
                    'label' => $_POST['label'],
                    'loanid' => $_POST['loanid']
                );
                echo edit_refund($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "search-refund") {
                $par = array(
                    'name' => strtoupper($_POST['search-name']),
                    'month' => $_POST['search-month']
                );
                echo searchrefund($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "print-refund") {
                $par = array(
                    'name' => strtoupper($_POST['search-name']),
                    'month' => $_POST['search-month']
                );
                echo print_refund();
            }

            if (isset($_POST['action']) && $_POST['action'] == "add-diverse") {
                $par = array(
                    'amount' => $_POST['amount'],
                    'date' => $_POST['date'],
                    'active' => $_POST['active'],
                    'member' => $_POST['member']
                );
                echo insert_div($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "edit-diverse") {
                $par = array(
                    'ID' => $_POST['ID'],
                    'amount' => $_POST['amount'],
                    'date' => $_POST['date'],
                    'active' => $_POST['active'],
                    'member' => $_POST['member']
                );
                echo edit_div($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "search-diverse") {
                $par = array(
                    'name' => strtoupper($_POST['search-name']),
                    'month' => $_POST['search-month']
                );
                echo searchdiv($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "print-diverse") {
                $par = array(
                    'name' => strtoupper($_POST['search-name']),
                    'month' => $_POST['search-month']
                );
                print_div($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "add-depot") {
                $par = array(
                    'amount' => $_POST['amount'],
                    'date' => $_POST['date'],
                    'active' => $_POST['active'],
                    'member' => $_POST['member']
                );
                echo insert_depot($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "edit-depot") {
                $par = array(
                    'ID' => $_POST['ID'],
                    'amount' => $_POST['amount'],
                    'date' => $_POST['date'],
                    'active' => $_POST['active'],
                    'member' => $_POST['member']
                );
                echo edit_depot($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "search-depot") {
                $par = array(
                    'name' => strtoupper($_POST['search-name']),
                    'month' => $_POST['search-month']
                );
                echo searchdepot($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "print-depot") {
                $par = array(
                    'name' => strtoupper($_POST['search-name']),
                    'month' => $_POST['search-month']
                );
                print_depot($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "login") {
                $par = array(
                    'user' => $_POST['user'],
                    'pass' => sha1($_POST['pass'])
                );
                log_process($par);
            }

            if (isset($_POST['action']) && $_POST['action'] == "print-operations") {
                print_operations();
            }

            if (isset($_POST['action']) && $_POST['action'] == "vote-member") {
                $par = array(
                    'voter' => $_POST['voter'],
                    'voted' => $_POST['voted']
                );
                echo cast_vote($par);
            }
            
            if (isset($_POST['action']) && $_POST['action'] == "print-bilan") {
                print_bilan($_POST['search-month']);
            }
        }
    } elseif (!isset($_SESSION['online'])) {
        if (!isset($_SESSION['splash'])) {
            splash_screen();
        } else {
            login_page(null);
        }
    }
} catch (Exception $exc) {
    echo $exc->getMessage();
}
