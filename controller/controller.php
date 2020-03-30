<?php

require 'model/memberManager.class.php';
require 'model/cyclesManager.class.php';
require 'model/contributionManager.php';
require 'model/loanManager.class.php';
require 'model/salesManager.class.php';
require 'model/socialAidManager.php';
require 'model/mealManager.class.php';
require 'model/penaltyManager.php';
require 'model/rightsManager.class.php';
require 'model/expenseManager.class.php';
require 'model/comissionManager.class.php';
require 'model/socialManager.class.php';
require 'model/operationManager.php';
require 'model/sessionManager.php';
require 'model/voteManager.class.php';
require 'model/loanrefundManager.class.php';
require 'model/divcontributionsManager.class.php';

function resume_page() {
    $reste = remaining();
    $length = duration();
    $ordinary = to_share();
    $memberno = count_member();
    $special = ts_share();
    $family = sf_share();
    total_sales();
    /*     * *** ORDINARY POOL INTEREST CALCULATION********** */
    $sales = total_sales(); // ORDINARY SALES
    $loaninterest = l_interest(); // INTEREST ON LOANS
    $rights = total_rights(); //TOTAL ADHESION RIGHTS
    $penalty = total_pen();
    $expense = total_exp();
    $divcontributions = total_diverse();

    $specialsales = total_special(); // SPECIAL POOL INTEREST ON CAPITAL SALES
    $comission = (0.05) * $specialsales; // COMISSION ON SPECIAL POOL INTEREST(SALES)

    $TOTALINTEREST = ($sales + $loaninterest + $rights + $comission + $penalty + $divcontributions) - $expense;

    /*     * *** SPECIAL POOL INTEREST CALCULATION********** */

    $SPECIALINTEREST = $specialsales - $comission;

    $social = total_social(); // SOCIAL FUND CALCULATION

    $LOANS = simpleloans();
    require 'view/resume.php';
}

function login_page($error) {
    $error;
    require 'view/log.php';
}

function logout() {
    $manager = new memberManager();
    $manager->spy_logout($_SESSION['online']);
    session_unset();
    session_destroy();
    login_page(null);
    $_SESSION['splash'] = 'true';
}

function splash_screen() {
    require 'view/splash.php';
    $_SESSION['splash'] = 'true';
}

/* * *******************Member page controllers**************************************** */
if (true) {

    function count_member() {
        $manager = new memberManager();
        return $num = $manager->count_mem();
    }

    function log_process($par) {
        $manager = new memberManager();
        $member = $manager->log($par);
        if (is_null($member)) {
            $error = "Erreur d'identifiant";
            login_page($error);
        } else {
            $_SESSION['online'] = $member;
            resume_page();
        }
    }

    function social() {
        $manager = new memberManager();
        return $manager->all_social();
    }

    function to_share() {
        $manager = new memberManager();
        return $manager->ordinaryshare_no();
    }

    function ts_share() {
        $manager = new memberManager();
        return $manager->specialshare_no();
    }

    function sf_share() {
        $manager = new memberManager();
        return $manager->sf_no();
    }

    function members_page() {
        $manager = new memberManager();
        $result = $manager->all_members();
        $list = $result['list'];
        $nombre = $result['count'];
        $value = $nombre / 10;
        $pagin = ceil($value);
        require 'view/member.php';
    }

    function print_member($par) {
        $manager = new memberManager();
        $printlist = $manager->searchName($par);
        require 'view/printToMember.php';
    }

    function members_scroll($page) {
        $manager = new memberManager();
        $res = ($page * 10) - 10;
        $result = $manager->member_pagination($res);
        $list = $result['list'];
        $nombre = $result['count'];
        $value = $nombre / 10;
        $pagin = ceil($value);
        require 'view/member.php';
    }

    function insert_mem($params) {
        $manager = new memberManager();
        return $manager->insert($params);
    }

    function array_it($mem) {
        $tab = array(
            'memid' => $mem->getmemid(),
            'fullname' => $mem->getfullname(),
            'role' => $mem->getrole(),
            'fs' => $mem->getfamilysituation(),
            'telno' => $mem->gettelno(),
            'adresse' => $mem->getadresse(),
            'to' => $mem->getordinarysharesno(),
            'ts' => $mem->getspecialsharesno(),
            'username' => $mem->getusername(),
            'pass' => $mem->getpassword()
        );
        return $tab;
    }

    function array_them($list) {
        $tab = array();
        foreach ($list as $mem) {
            $subarray = array(
                'memid' => $mem->getmemid(),
                'fullname' => $mem->getfullname(),
                'role' => $mem->getrole(),
                'fs' => $mem->getfamilysituation(),
                'telno' => $mem->gettelno(),
                'adresse' => $mem->getadresse(),
                'to' => $mem->getordinarysharesno(),
                'ts' => $mem->getspecialsharesno(),
                'username' => $mem->getusername(),
                'pass' => $mem->getpassword()
            );
            $tab[] = $subarray;
        }
        return $tab;
    }

    function get_member($id) {
        $manager = new memberManager();
        $member = $manager->return_std($id);
        if (is_null($member)) {
            return null;
        } else {
            return array_it($member);
        }
    }

    function all_member() {
        $manager = new memberManager();
        return $list = $manager->all();
    }

    function edit_member($params) {
        $manager = new memberManager();
        return $manager->edit($params);
    }

    function delete_member($id) {
        $manager = new memberManager();
        return $manager->delete($id);
    }

    function searchmember_name($par) {
        $manager = new memberManager();
        $list = $manager->searchName($par);
        return array_them($list);
    }

}

//*********************Cycle page controllers*****************************************/
if (true) {

    function cycle_page() {
        $manager = new cyclesManager();
        $list2 = all_member();
        $result = $manager->all_cycles();
        $list = $result['list'];
        $nombre = $result['count'];
        $value = $nombre / 10;
        $pagin = ceil($value);
        require 'view/cycles.php';
    }

    function cycles_scroll($page) {
        $manager = new cyclesManager();
        $res = ($page * 10) - 10;
        $list2 = all_member();
        $result = $manager->cycle_pagination($res);
        $list = $result['list'];
        $nombre = $result['count'];
        $value = $nombre / 10;
        $pagin = ceil($value);
        require 'view/cycles.php';
    }

    function insert_cyc($params) {
        $manager = new cyclesManager();
        if ($params['status'] == 'Active') {
            if ($manager->is_active()) {
                return "Un cycle est déja Activé";
            } else {
                return $manager->insert($params);
            }
        } else {
            return $manager->insert($params);
        }
    }

    function remaining() {
        $manager = new cyclesManager();
        return $manager->ending();
    }

    function duration() {
        $manager = new cyclesManager();
        return $manager->lenght();
    }

    function array_cyc($cycl) {
        $tabs = array(
            'cycid' => $cycl->getcycid(),
            'president' => $cycl->getpresident(),
            'begdate' => $cycl->getbegindate(),
            'enddate' => $cycl->getenddate(),
            'memid' => $cycl->getmemid(),
            'status' => $cycl->getstatus(),
            'fondini' => $cycl->getintialfond()
        );
        return $tabs;
    }

    function get_cycle($id) {
        $manager = new cyclesManager();
        $cycle = $manager->return_cyc($id);
        if (is_null($cycle)) {
            return null;
        } else {
            return array_cyc($cycle);
        }
    }

    function edit_cycle($params) {

        $manager = new cyclesManager();
        if ($params['status'] == 'Active') {
            if ($manager->is_active()) {
                return "Un cycle est déja Activé";
            } else {
                return $manager->update($params);
            }
        } else {
            return $manager->update($params);
        }
    }

    function del_cycle($id) {
        $manager = new cyclesManager();
        return $manager->delete($id);
    }

    function searchCycle($par) {
        $manager = new cyclesManager();
        $list = $manager->search_cycle($par);
        return array_cycles($list);
    }

    function array_cycles($list) {
        $tab = array();
        foreach ($list as $cycl) {
            $subarray = array(
                'cycid' => $cycl->getcycid(),
                'president' => $cycl->getpresident(),
                'begdate' => $cycl->getbegindate(),
                'enddate' => $cycl->getenddate(),
                'memid' => $cycl->getmemid(),
                'status' => $cycl->getstatus(),
                'fondini' => $cycl->getintialfond()
            );
            $tab[] = $subarray;
        }
        return $tab;
    }

    function print_cycles($par) {
        $manager = new cyclesManager();
        $printlist = $manager->search_cycle($par);
        require 'view/printToCycle.php';
    }

    function active() {
        $manager = new cyclesManager();
        return $manager->return_active();
    }

    function all_cycles() {
        $manager = new cyclesManager();
        return $manager->all();
    }

}

//*********************contribution controllers***************************************/
if (true) {

    function contribution_page() {
        $manager = new contributionManager();
        $full_list = $manager->all_contribution();
        $list2 = all_member();
        $list3 = all_cycles();
        $cycle12 = active();
        $nombre = $full_list['count'];
        $list = $full_list['list'];
        $value = $nombre / 10;
        $pagin = ceil($value);
        if ($cycle12 != null) {
            $months = list_months($cycle12->getbegindate(), $cycle12->getenddate());
        }
        require 'view/contributions.php';
    }

    function total_contribution() {
        $manager = new contributionManager();
        return $manager->sum_contributions();
    }

    function contri_scroll($page) {
        $manager = new contributionManager();
        $res = ($page * 10) - 10;
        $list2 = all_member();
        $list3 = all_cycles();
        $cycle12 = active();
        if ($cycle12 != null) {
            $months = list_months($cycle12->getbegindate(), $cycle12->getenddate());
        }
        $result = $manager->contri_pagination($res);
        $list = $result['list'];
        $nombre = $result['count'];
        $value = $nombre / 10;
        $pagin = ceil($value);
        require 'view/contributions.php';
    }

    function insert_contri($par) {
        $manager = new contributionManager();
        return $manager->insert($par);
    }

    function get_cont($id) {
        $manager = new contributionManager();
        $result = $manager->return_contri($id);
        if (is_string($result)) {
            return $result;
        } else {
            return json_encode(array_cont($result));
        }
    }

    function array_cont(contribution $cont) {
        $tabs = array(
            'contid' => $cont->getcontid(),
            'ordinary' => $cont->getordinary(),
            'special' => $cont->getspecial(),
            'month' => $cont->getmeetingdate(),
            'date' => $cont->getdepositdate(),
            'meal' => $cont->getmeal(),
            'cycle' => $cont->getcycle(),
            'cycid' => $cont->getcycid(),
            'fullname' => $cont->getfullname(),
            'tord' => $cont->gettord(),
            'ts' => $cont->getts(),
            'label' => $cont->getlabels()
        );
        return $tabs;
    }

    function edit_contri($par) {
        $manager = new contributionManager();
        return $manager->edit($par);
    }

    function del_contri($id) {
        $manager = new contributionManager();
        return $manager->delete($id);
    }

    function searchContri($par) {
        $manager = new contributionManager();
        $list = $manager->search($par);
        return json_encode(array_conts($list));
    }

    function array_conts($list) {
        $tab = array();
        foreach ($list as $cont) {
            $subarray = array(
                'contid' => $cont->getcontid(),
                'ordinary' => $cont->getordinary(),
                'special' => $cont->getspecial(),
                'month' => $cont->getmeetingdate(),
                'date' => $cont->getdepositdate(),
                'meal' => $cont->getmeal(),
                'cycle' => $cont->getcycle(),
                'cycid' => $cont->getcycid(),
                'fullname' => $cont->getfullname(),
                'tord' => $cont->gettord(),
                'ts' => $cont->getts(),
                'label' => $cont->getlabels()
            );
            $tab[] = $subarray;
        }
        return $tab;
    }

    function print_contri($par) {
        $manager = new contributionManager();
        if ($par['month'] != '') {
            $par['type'] = '';
            $printlist = $manager->search($par);
            $monthname = month_name($par['month']);
            require 'view/printToContribution.php';
        } else {
            $printlist = $manager->report();
            require 'view/printoToContribution2.php';
        }
    }

}

//*********************Loan controllers***************************************/

if (true) {

    function loan_page() {
        $manager = new loanManager();
        $full_list = $manager->all_loans();
        $list2 = all_member();
        $cycle12 = active();
        $nombre = $full_list['count'];
        $list = $full_list['list'];
        $value = $nombre / 10;
        if ($cycle12 != null) {
            $months = list_months($cycle12->getbegindate(), $cycle12->getenddate());
        }
        $pagin = ceil($value);
        require 'view/loans.php';
    }

    function interest_loan() {
        $manager = new loanManager();
        return $manager->loan_int();
    }

    function total_nonloans() {
        $manager = new loanManager();
        return $manager->non_loan();
    }

    function total_refund() {
        $manager = new loanManager();
        return $manager->sum_refund();
    }

    function loan_scroll($page) {
        $manager = new loanManager();
        $res = ($page * 10) - 10;
        $list2 = all_member();
        $list3 = all_cycles();
        $cycle12 = active();
        $result = $manager->loan_pagination($res);
        $list = $result['list'];
        $nombre = $result['count'];
        $value = $nombre / 10;
        if ($cycle12 != null) {
            $months = list_months($cycle12->getbegindate(), $cycle12->getenddate());
        }
        $pagin = ceil($value);
        require 'view/loans.php';
    }

    function insert_loan($par) {
        $manager = new loanManager();
        return $manager->insert($par);
    }

    function get_loan($id) {
        $manager = new loanManager();
        $result = $manager->return_loan($id);
        if (is_string($result)) {
            return $result;
        } else {
            return json_encode(array_loan($result));
        }
    }

    function simpleloans() {
        $manager = new loanManager();
        return $manager->total_loans();
    }

    function array_loan($cont) {
        $tabs = array(
            'loanid' => $cont->getloanid(),
            'amount' => $cont->getamount(),
            'rate' => $cont->getrate(),
            'date' => $cont->getdate(),
            'cycle' => $cont->getcycle(),
            'fullname' => $cont->getfullname(),
            'check' => $cont->getchequesno()
        );
        return $tabs;
    }

    function edit_loan($par) {
        $manager = new loanManager();
        return $manager->edit($par);
    }

    function del_loan($id) {
        $manager = new loanManager();
        return $manager->delete($id);
    }

    function array_loans($list) {
        $tab = array();
        foreach ($list as $cont) {
            $subarray = array(
                'loanid' => $cont->getloanid(),
                'amount' => $cont->getamount(),
                'rate' => $cont->getrate(),
                'date' => $cont->getdate(),
                'cycle' => $cont->getcycle(),
                'fullname' => $cont->getfullname(),
                'check' => $cont->getchequesno()
            );
            $tab[] = $subarray;
        }
        return $tab;
    }

    function searchloan($par) {
        $manager = new loanManager();
        $list = $manager->search($par);
        return json_encode(array_loans($list));
    }

    function print_loan($par) {
        if ($par['month'] != '') {
            $manager = new loanManager();
            $par['name'] = '';
            $printlist = $manager->search($par);
            $monthname = month_name($par['month']);

            $manager2 = new loanrefundManager();
            $reflist = $manager2->bymonth($par['month']);
            require 'view/printToLoan.php';
        } else {
            $manager = new loanManager();
            $printlist = $manager->report();

            $manager2 = new loanrefundManager();
            $reflist = $manager2->report();
            require 'view/printToLoan2.php';
        }
    }

}

//*********************Sales controllers***************************************/
if (true) {

    function sales_page() {
        $manager = new salesManager();
        $full_list = $manager->all_sales();
        $list2 = social();
        $cycle12 = active();
        $nombre = $full_list['count'];
        $list = $full_list['list'];
        if ($cycle12 != null) {
            $months = list_months($cycle12->getbegindate(), $cycle12->getenddate());
        }
        $value = $nombre / 10;
        $pagin = ceil($value);
        require 'view/sales.php';
    }

    function total_sales() {
        $manager = new salesManager();
        return $manager->Ordinarysum_sell();
    }

    function total_special() {
        $manager = new salesManager();
        return $manager->specialsum_sell();
    }

    function total_cost() {
        $manager = new salesManager();
        return $manager->sum_sales();
    }

    function sales_month() {
        $manager = new salesManager();
        return json_encode($manager->salesPerMonth());
    }

    function insert_sales($par) {
        $manager = new salesManager();
        return $manager->insert($par);
    }

    function get_sales($id) {
        $manager = new salesManager();
        $result = $manager->return_sales($id);
        if (is_string($result)) {
            return $result;
        } else {
            return json_encode(array_sale($result));
        }
    }

    function array_sale($cont) {
        $tabs = array(
            'tsid' => $cont->gettsid(),
            'cycid' => $cont->getcycid(),
            'amount' => $cont->getamount(),
            'sell' => $cont->getsellingprice(),
            'date' => $cont->getdate(),
            'check' => $cont->getchequesno(),
            'cycle' => $cont->getcycle(),
            'fullname' => $cont->getfullname(),
            'tontine' => $cont->gettype()
        );
        return $tabs;
    }

    function array_sales($list) {
        $tab = array();
        foreach ($list as $cont) {
            $subarray = array(
                'tsid' => $cont->gettsid(),
                'cycid' => $cont->getcycid(),
                'amount' => $cont->getamount(),
                'sell' => $cont->getsellingprice(),
                'date' => $cont->getdate(),
                'check' => $cont->getchequesno(),
                'cycle' => $cont->getcycle(),
                'fullname' => $cont->getfullname(),
                'tontine' => $cont->gettype(),
            );
            $tab[] = $subarray;
        }
        return $tab;
    }

    function edit_sales($par) {
        $manager = new salesManager();
        return $manager->edit($par);
    }

    function del_sales($id) {
        $manager = new salesManager();
        return $manager->delete($id);
    }

    function searchsales($par) {
        $manager = new salesManager();
        $list = $manager->search($par);
        return json_encode(array_sales($list));
    }

    function print_sales($par) {
        $manager = new salesManager();
        if ($par['tontine'] != "") {
            if ($par['month'] != "") {
                $printlist = $manager->search($par);
                $monthname = month_name($par['month']);
                require 'view/printToSales.php';
            } else {
                $printlist = $manager->report($par['tontine']);
                require 'view/printToSales2.php';
            }
        } else {
            
        }
    }

    function sales_scroll($page) {
        $manager = new salesManager();
        $res = ($page * 10) - 10;
        $list2 = social();
        $cycle12 = active();
        if ($cycle12 != null) {
            $months = list_months($cycle12->getbegindate(), $cycle12->getenddate());
        }
        $cycle12 = active();
        $result = $manager->sales_pagination($res);
        $list = $result['list'];
        $nombre = $result['count'];
        $value = $nombre / 10;
        $pagin = ceil($value);
        require 'view/sales.php';
    }

}

//*********************help controllers***************************************/
if (true) {

    function help_page() {
        $manager = new socialAidManager();
        $full_list = $manager->all_aid();
        $list2 = all_member();
        $list3 = all_cycles();
        $cycle12 = active();
        if ($cycle12 != null) {
            $months = list_months($cycle12->getbegindate(), $cycle12->getenddate());
        }
        $nombre = $full_list['count'];
        $list = $full_list['list'];
        $value = $nombre / 10;
        $pagin = ceil($value);
        require 'view/help.php';
    }

    function insert_help($par) {
        $manager = new socialAidManager();
        return $manager->insert($par);
    }

    function get_help($id) {
        $manager = new socialAidManager();
        $result = $manager->return_help($id);
        if (is_string($result)) {
            return $result;
        } else {
            return json_encode(array_help($result));
        }
    }

    function array_help($cont) {
        $tabs = array(
            'said' => $cont->getsaid(),
            'amount' => $cont->getamount(),
            'date' => $cont->getdate(),
            'check' => $cont->getchequesno(),
            'cycle' => $cont->getcycle(),
            'fullname' => $cont->getfullname(),
            'reason' => $cont->getreason()
        );
        return $tabs;
    }

    function edit_help($par) {
        $manager = new socialAidManager();
        return $manager->edit($par);
    }

    function del_help($id) {
        $manager = new socialAidManager();
        return $manager->delete($id);
    }

    function searchhelp($par) {
        $manager = new socialAidManager();
        $list = $manager->search($par);
        return json_encode(array_helps($list));
    }

    function array_helps($list) {
        $tab = array();
        foreach ($list as $cont) {
            $subarray = array(
                'said' => $cont->getsaid(),
                'amount' => $cont->getamount(),
                'date' => $cont->getdate(),
                'check' => $cont->getchequesno(),
                'cycle' => $cont->getcycle(),
                'fullname' => $cont->getfullname(),
                'reason' => $cont->getreason()
            );
            $tab[] = $subarray;
        }
        return $tab;
    }

    function print_help($par) {
        $manager = new socialaidManager();

        $printlist = $manager->search($par);
        if ($par['month'] != "") {
            $monthname = month_name($par['month']);
        }
        require 'view/printToHelp.php';
    }

    function help_scroll($page) {
        $manager = new socialAidManager();
        $res = ($page * 10) - 10;
        $list2 = all_member();
        $list3 = all_cycles();
        $cycle12 = active();
        if ($cycle12 != null) {
            $months = list_months($cycle12->getbegindate(), $cycle12->getenddate());
        }
        $result = $manager->help_pagination($res);
        $list = $result['list'];
        $nombre = $result['count'];
        $value = $nombre / 10;
        $pagin = ceil($value);
        require 'view/help.php';
    }

}

//*********************meal controllers***************************************/

if (true) {

    function meal_page() {
        $manager = new mealManager();
        $full_list = $manager->all_meals();
        $list2 = all_member();
        $cycle12 = active();
        if ($cycle12 != null) {
            $months = list_months($cycle12->getbegindate(), $cycle12->getenddate());
        }
        $nombre = $full_list['count'];
        $list = $full_list['list'];
        $value = $nombre / 10;
        $pagin = ceil($value);
        require 'view/meal.php';
    }

    function total_meals() {
        $manager = new mealManager();
        return $manager->sum_meals();
    }

    function insert_meal($par) {
        $manager = new mealManager();
        return $manager->insert($par);
    }

    function get_meal($id) {
        $manager = new mealManager();
        $result = $manager->return_meal($id);
        if (is_string($result)) {
            return $result;
        } else {
            return json_encode(array_meal($result));
        }
    }

    function array_meal($cont) {
        $tabs = array(
            'mealid' => $cont->getmealid(),
            'amount' => $cont->getamount(),
            'date' => $cont->getdate(),
            'check' => $cont->getchequesno(),
            'cycle' => $cont->getcycle(),
            'fullname' => $cont->getfullname()
        );
        return $tabs;
    }

    function edit_meal($par) {
        $manager = new mealManager();
        return $manager->edit($par);
    }

    function del_meal($id) {
        $manager = new mealManager();
        return $manager->delete($id);
    }

    function array_meals($list) {
        $tab = array();
        foreach ($list as $cont) {
            $subarray = array(
                'mealid' => $cont->getmealid(),
                'amount' => $cont->getamount(),
                'date' => $cont->getdate(),
                'check' => $cont->getchequesno(),
                'cycle' => $cont->getcycle(),
                'fullname' => $cont->getfullname(),
            );
            $tab[] = $subarray;
        }
        return $tab;
    }

    function searchmeal($par) {
        $manager = new mealManager();
        $list = $manager->search($par);
        return json_encode(array_meals($list));
    }

    function print_meal($par) {
        $manager = new mealManager();
        $printlist = $manager->report();
        require 'view/printToMeal.php';
    }

    function meal_scroll($page) {
        $manager = new mealManager();
        $res = ($page * 10) - 10;
        $list2 = all_member();
        if ($cycle12 != null) {
            $months = list_months($cycle12->getbegindate(), $cycle12->getenddate());
        }
        $cycle12 = active();
        $result = $manager->meal_pagination($res);
        $list = $result['list'];
        $nombre = $result['count'];
        $value = $nombre / 10;
        $pagin = ceil($value);
        require 'view/meal.php';
    }

}

//*********************penalty controllers***************************************/
if (true) {

    function penalty_page() {
        $manager = new penaltyManager();
        $full_list = $manager->all_penalty();
        $list2 = all_member();
        $cycle12 = active();
        if ($cycle12 != null) {
            $months = list_months($cycle12->getbegindate(), $cycle12->getenddate());
        }
        $nombre = $full_list['count'];
        $list = $full_list['list'];
        $value = $nombre / 10;
        $pagin = ceil($value);
        require 'view/penalty.php';
    }

    function total_pen() {
        $manager = new penaltyManager();
        return $manager->sum_pen();
    }

    function insert_pen($par) {
        $manager = new penaltyManager();
        return $manager->insert($par);
    }

    function get_pen($id) {
        $manager = new penaltyManager();
        $result = $manager->return_penalty($id);
        if (is_string($result)) {
            return $result;
        } else {
            return json_encode(array_pen($result));
        }
    }

    function array_pen($cont) {
        $tabs = array(
            'penid' => $cont->getpenid(),
            'amount' => $cont->getamount(),
            'date' => $cont->getdate(),
            'cycle' => $cont->getcycle(),
            'fullname' => $cont->getfullname(),
            'reason' => $cont->getlabels()
        );
        return $tabs;
    }

    function edit_pen($par) {
        $manager = new penaltyManager();
        return $manager->edit($par);
    }

    function del_pen($id) {
        $manager = new penaltyManager();
        return $manager->delete($id);
    }

    function searchpen($par) {
        $manager = new penaltyManager();
        $list = $manager->search($par);
        return json_encode(array_pens($list));
    }

    function array_pens($list) {
        $tab = array();
        foreach ($list as $cont) {
            $subarray = array(
                'penid' => $cont->getpenid(),
                'amount' => $cont->getamount(),
                'date' => $cont->getdate(),
                'cycle' => $cont->getcycle(),
                'fullname' => $cont->getfullname(),
                'reason' => $cont->getlabels()
            );
            $tab[] = $subarray;
        }
        return $tab;
    }

    function pen_scroll($page) {
        $manager = new penaltyManager();
        $res = ($page * 10) - 10;
        $list2 = all_member();
        $cycle12 = active();
        if ($cycle12 != null) {
            $months = list_months($cycle12->getbegindate(), $cycle12->getenddate());
        }
        $result = $manager->pen_pagination($res);
        $list = $result['list'];
        $nombre = $result['count'];
        $value = $nombre / 10;
        $pagin = ceil($value);
        require 'view/penalty.php';
    }

    function print_pen($par) {
        $manager = new penaltyManager();
        if ($par['month'] != "") {
            $printlist = $manager->search($par);
            $monthname = month_name($par['month']);
            require 'view/printToPenalty.php';
        } else {
            $printlist = $manager->search($par);
            require 'view/printToPenalty2.php';
        }
    }

}

//********************Rights controllers*******************************************/
if (true) {

    function rights_page() {
        $manager = new rightsManager();
        $full_list = $manager->all_rights();
        $list2 = all_member();
        $cycle12 = active();
        if ($cycle12 != null) {
            $months = list_months($cycle12->getbegindate(), $cycle12->getenddate());
        }
        $nombre = $full_list['count'];
        $list = $full_list['list'];
        $value = $nombre / 10;
        $pagin = ceil($value);
        require 'view/rights.php';
    }

    function total_rights() {
        $manager = new rightsManager();
        return $manager->sum_rights();
    }

    function insert_rights($par) {
        $manager = new rightsManager();
        return $manager->insert($par);
    }

    function edit_right($par) {
        $manager = new rightsManager();
        return $manager->edit($par);
    }

    function get_right($id) {
        $manager = new rightsManager();
        $result = $manager->return_right($id);
        if (is_string($result)) {
            return $result;
        } else {
            return json_encode(array_right($result));
        }
    }

    function array_right($cont) {
        $tabs = array(
            'arid' => $cont->getarid(),
            'amount' => $cont->getamount(),
            'date' => $cont->getdate(),
            'cycle' => $cont->getcycle(),
            'fullname' => $cont->getfullname()
        );
        return $tabs;
    }

    function del_right($id) {
        $manager = new rightsManager();
        return $manager->delete($id);
    }

    function searchrights($par) {
        $manager = new rightsManager();
        $list = $manager->search($par);
        return json_encode(array_rights($list));
    }

    function array_rights($list) {
        $tab = array();
        foreach ($list as $cont) {
            $subarray = array(
                'arid' => $cont->getarid(),
                'amount' => $cont->getamount(),
                'date' => $cont->getdate(),
                'cycle' => $cont->getcycle(),
                'fullname' => $cont->getfullname()
            );
            $tab[] = $subarray;
        }
        return $tab;
    }

    function print_rights($par) {
        $par['month'] = "";
        $manager = new rightsManager();
        $printlist = $manager->search($par);
        require 'view/printToRight.php';
    }

    function right_scroll($page) {
        $manager = new rightsManager();
        $res = ($page * 10) - 10;
        $list2 = all_member();
        $cycle12 = active();
        if ($cycle12 != null) {
            $months = list_months($cycle12->getbegindate(), $cycle12->getenddate());
        }
        $result = $manager->right_pagination($res);
        $list = $result['list'];
        $nombre = $result['count'];
        $value = $nombre / 10;
        $pagin = ceil($value);
        require 'view/rights.php';
    }

}
//*******************Expenses controllers**********************************************/
if (true) {

    function spend_page() {
        $manager = new expenseManager();
        $full_list = $manager->all_spend();
        $list3 = all_cycles();
        $cycle12 = active();
        $nombre = $full_list['count'];
        $list = $full_list['list'];
        $value = $nombre / 10;
        if ($cycle12 != null) {
            $months = list_months($cycle12->getbegindate(), $cycle12->getenddate());
        }
        $pagin = ceil($value);
        require 'view/spend.php';
    }

    function total_exp() {
        $manager = new expenseManager();
        return $manager->sum_exp();
    }

    function insert_spend($par) {
        $manager = new expenseManager();
        return $manager->insert($par);
    }

    function exp_month() {
        $manager = new expenseManager();
        return json_encode($manager->exp_month());
    }

    function get_spend($id) {
        $manager = new expenseManager();
        $result = $manager->return_spend($id);
        if (is_string($result)) {
            return $result;
        } else {
            return json_encode(array_spend($result));
        }
    }

    function array_spend($cont) {
        $tabs = array(
            'expid' => $cont->getexpid(),
            'amount' => $cont->getamount(),
            'date' => $cont->getdate(),
            'check' => $cont->getchequesno(),
            'cycle' => $cont->getcycle(),
            'reason' => $cont->getlabels()
        );
        return $tabs;
    }

    function edit_spend($par) {
        $manager = new expenseManager();
        return $manager->edit($par);
    }

    function del_spend($id) {
        $manager = new expenseManager();
        return $manager->delete($id);
    }

    function searchspend($par) {
        $manager = new expenseManager();
        $list = $manager->search($par);
        return json_encode(array_spends($list));
    }

    function array_spends($list) {
        $tab = array();
        foreach ($list as $cont) {
            $subarray = array(
                'expid' => $cont->getexpid(),
                'amount' => $cont->getamount(),
                'date' => $cont->getdate(),
                'check' => $cont->getchequesno(),
                'cycle' => $cont->getcycle(),
                'reason' => $cont->getlabels()
            );
            $tab[] = $subarray;
        }
        return $tab;
    }

    function print_spend($par) {
        $manager = new expenseManager();
        if ($par['month'] != "") {
            $printlist = $manager->search($par);
            $monthname = month_name($par['month']);
            require 'view/printToSpend.php';
        } else {
            $par['month'] = '';
            $printlist = $manager->search($par);
            require 'view/printToSpend2.php';
        }
    }

    function spend_scroll($page) {
        $manager = new expenseManager();
        $res = ($page * 10) - 10;
        $list3 = all_cycles();
        $cycle12 = active();
        if ($cycle12 != null) {
            $months = list_months($cycle12->getbegindate(), $cycle12->getenddate());
        }
        $result = $manager->pagination($res);
        $list = $result['list'];
        $nombre = $result['count'];
        $value = $nombre / 10;
        $pagin = ceil($value);
        require 'view/spend.php';
    }

}
//*******************Comission controllers**************************************************/
if (true) {

    function frais_page() {
        $manager = new comissionManager();
        $full_list = $manager->all();
        $list3 = all_cycles();
        $cycle12 = active();
        $nombre = $full_list['count'];
        $list = $full_list['list'];
        $value = $nombre / 10;
        $pagin = ceil($value);
        require 'view/frais.php';
    }

    function total_com() {
        $manager = new comissionManager();
        return $manager->sum_comissions();
    }

    function insert_com($par) {
        $manager = new comissionManager();
        return $manager->insert($par);
    }

    function get_com($id) {
        $manager = new comissionManager();
        $result = $manager->return_com($id);
        if (is_string($result)) {
            return $result;
        } else {
            return json_encode(array_com($result));
        }
    }

    function array_com($cont) {
        $tabs = array(
            'scomid' => $cont->getscomid(),
            'amount' => $cont->getamount(),
            'rate' => $cont->getrate(),
            'cycle' => $cont->getcycle(),
        );
        return $tabs;
    }

    function edit_com($par) {
        $manager = new comissionManager();
        return $manager->edit($par);
    }

    function del_com($id) {
        $manager = new comissionManager();
        return $manager->delete($id);
    }

    function searchcom($par) {
        $manager = new comissionManager();
        $list = $manager->search($par);
        return json_encode(array_coms($list));
    }

    function array_coms($list) {
        $tab = array();
        foreach ($list as $cont) {
            $subarray = array(
                'scomid' => $cont->getscomid(),
                'amount' => $cont->getamount(),
                'rate' => $cont->getrate(),
                'cycle' => $cont->getcycle(),
            );
            $tab[] = $subarray;
        }
        return $tab;
    }

    function print_com($par) {
        $manager = new comissionManager();
        $printlist = $manager->search($par);
        require 'view/printToCom.php';
    }

    function comission_scroll($page) {
        $manager = new comissionManager();
        $res = ($page * 10) - 10;
        $list3 = all_cycles();
        $cycle12 = active();
        $result = $manager->pagination($res);
        $list = $result['list'];
        $nombre = $result['count'];
        $value = $nombre / 10;
        $pagin = ceil($value);
        require 'view/frais.php';
    }

}
//*******************Depot FS controllers**************************************************/
if (true) {

    function depot_page() {
        $manager = new socialManager();
        $manager2 = new memberManager();
        $full_list = $manager->all();
        $list2 = all_member();
        $cycle12 = active();
        $nombre = $full_list['count'];
        $list = $full_list['list'];
        $value = $nombre / 10;
        $pagin = ceil($value);
        if ($cycle12 != null) {
            $months = list_months($cycle12->getbegindate(), $cycle12->getenddate());
        }
        $num = count($months);
        $ord = $manager2->ordinaryshare_no();
        $resultat = ($num * 100000) / $ord;
        require 'view/depot.php';
    }

    function depot_scroll($page) {
        $res = ($page * 10) - 10;
        $manager = new socialManager();
        $manager2 = new memberManager();
        $full_list = $manager->pagination($page);
        $list2 = all_member();
        $cycle12 = active();
        $nombre = $full_list['count'];
        $list = $full_list['list'];
        $value = $nombre / 10;
        $pagin = ceil($value);
        if ($cycle12 != null) {
            $months = list_months($cycle12->getbegindate(), $cycle12->getenddate());
        }
        $num = count($months);
        $ord = $manager2->ordinaryshare_no();
        $resultat = ($num * 100000) / $ord;
        require 'view/depot.php';
    }

    function list_months($begin, $last) {
        $start = (new DateTime($begin))->modify('first day of this month');
        $end = (new DateTime($last))->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period = new DatePeriod($start, $interval, $end);
        $list = array();
        $name = array();
        foreach ($period as $dt) {
            $full = $dt->format("Y-m-d");
            $mois = $dt->format("m");
            $dateobj = Datetime::createFromFormat('!m', $mois);
            $monthname = $dateobj->format('F');
            $name[] = array($full => $monthname . '-' . $dt->format("Y"));
        }
        return $name;
    }

    function month_name($date) {
        $dates = DateTime::createFromFormat('Y-m-d', $date);
        return $dates->format('F') . ' ' . $dates->format('Y');
    }

    function total_social() {
        $manager = new socialManager();
        return $manager->sum_social();
    }

    function insert_depot($par) {
        $manager = new socialManager();
        return $manager->insert($par);
    }

    function get_depot($id) {
        $manager = new socialManager();
        $result = $manager->return_depot($id);
        if (is_string($result)) {
            return $result;
        } else {
            return json_encode(array_depot($result));
        }
    }

    function array_depot($cont) {
        $tabs = array(
            'sfid' => $cont->getsfid(),
            'amount' => $cont->getamount(),
            'date' => $cont->getdate(),
            'cycle' => $cont->getcycle(),
            'fullname' => $cont->getfullname(),
            'ordinary' => $cont->getordinarysharesno(),
            'family' => $cont->getfamilysituation()
        );
        return $tabs;
    }

    function edit_depot($par) {
        $manager = new socialManager();
        return $manager->edit($par);
    }

    function del_depot($id) {
        $manager = new socialManager();
        return $manager->delete($id);
    }

    function searchdepot($par) {
        $manager = new socialManager();
        $list = $manager->search($par);
        return json_encode(array_depots($list));
    }

    function array_depots($list) {
        $tab = array();
        foreach ($list as $cont) {
            $subarray = array(
                'sfid' => $cont->getsfid(),
                'amount' => $cont->getamount(),
                'date' => $cont->getdate(),
                'cycle' => $cont->getcycle(),
                'fullname' => $cont->getfullname(),
                'ordinary' => $cont->getordinarysharesno(),
                'family' => $cont->getfamilysituation()
            );
            $tab[] = $subarray;
        }
        return $tab;
    }

    function print_depot($par) {
        $manager = new socialManager();
        if ($par['month'] != '') {
            $printlist = $manager->search($par);
            $cumul_list = $manager->cumlative($par['name']);
            $monthname = month_name($par['month']);
            require 'view/printToSocial.php';
        } else {
            $cumul_list = $manager->cumlative($par['name']);
            require 'view/printToSocial2.php';
        }
    }

}

//******************Spy controllers*******************************************************/
if (true) {

    function operation_page() {
        $manager = new operationManager();
        $full_list = $manager->all();
        $nombre = $full_list['count'];
        $list = $full_list['list'];
        $value = $nombre / 40;
        $pagin = ceil($value);
        require 'view/operation.php';
    }

    function operation_scroll($page) {
        $manager = new operationManager();
        $res = ($page * 40) - 40;
        $result = $manager->pagination($res);
        $list = $result['list'];
        $nombre = $result['count'];
        $value = $nombre / 40;
        $pagin = ceil($value);
        require 'view/operation.php';
    }

    function print_operations() {
        $manager = new operationManager();
        $printlist = $manager->every();
        require 'view/printOps.php';
    }

}

//******************* session controllers************************************************//
if (true) {

    function edit_state($state) {
        $manager = new sessionManager();
        return $manager->edit($state);
    }

    function return_session() {
        $manager = new sessionManager();
        $session = $manager->get_session();
        return $session;
    }

    function get_session() {
        $manager = new sessionManager();
        $session = $manager->get_session();
        return $session->getactive();
    }

}

//********************* Vote Controllers************************************************//
if (true) {

    function vote_page() {
        $manager = new memberManager();
        $list = $manager->candidates();
        $manages = new voteManager();
        $voted = $manages->have_voted($_SESSION['online']->getmemid());
        $session = getSession();
        if ($session->getactive() == 'true') {
            require 'view/vote.php';
        } else {
            echo '<p> Vote Session not Activated </p> ';
            echo '<a href="index.php"> Back </a>';
        }
    }

    function cast_vote($par) {
        $manager = new voteManager();
        if ($manager->have_voted($par['voter'])) {
            return 'You have Already voted !!';
        } else {
            return $manager->insert($par);
        }
    }

    function getSession() {
        $manager = new sessionManager();
        return $manager->get_session();
    }

    function result_page() {
        $cycle12 = active();
        require 'view/result.php';
    }

    function resultat_vote() {
        $manager = new voteManager();
        return json_encode($manager->calc_results());
    }

}

//********************** Refund controllers *********************************************//
if (true) {

    function refund_page() {
        $manager = new loanrefundManager();
        $result = $manager->all();
        $list = $result['list'];
        $nombre = $result['count'];
        $value = $nombre / 10;
        $pagin = ceil($value);
        $cycle12 = active();
        if ($cycle12 != null) {
            $months = list_months($cycle12->getbegindate(), $cycle12->getenddate());
        }
        $refloan;
        if (isset($_GET['loanid'])) {
            $manager2 = new loanManager();
            $refloan = $manager2->return_loan($_GET['loanid']);
        }
        require 'view/refund.php';
    }

    function insert_refund($par) {
        $manager = new loanrefundManager();
        return $manager->insert($par);
    }

    function l_interest() {
        $manager = new loanrefundManager();
        return $manager->laon_interest();
    }

    function get_refund($id) {
        $manager = new loanrefundManager();
        return json_encode(array_refund($manager->return_refund($id)));
    }

    function array_refund($cont) {
        $tabs = array(
            'refid' => $cont->getrefid(),
            'amount' => $cont->getamount(),
            'label' => $cont->getlabels(),
            'date' => $cont->getdate(),
            'fullname' => $cont->getfullname(),
            'rate' => $cont->getrate(),
            'lamount' => $cont->getl_amount(),
            'ldate' => $cont->getl_date(),
        );
        return $tabs;
    }

    function edit_refund($par) {
        $manager = new loanrefundManager();
        return $manager->edit($par);
    }

    function del_refund($id) {
        $manager = new loanrefundManager();
        return $manager->delete($id);
    }

    function searchrefund($par) {
        $manager = new loanrefundManager();
        $list = $manager->search($par);
        return json_encode(array_refunds($list));
    }

    function array_refunds($list) {
        $tab = array();
        foreach ($list as $cont) {
            $subarray = array(
                'refid' => $cont->getrefid(),
                'amount' => $cont->getamount(),
                'label' => $cont->getlabels(),
                'date' => $cont->getdate(),
                'fullname' => $cont->getfullname()
            );
            $tab[] = $subarray;
        }
        return $tab;
    }

    function refund_scroll($page) {
        $manager = new loanrefundManager();
        $res = ($page * 10) - 10;
        $result = $manager->pagination($res);
        $list = $result['list'];
        $nombre = $result['count'];
        $value = $nombre / 10;
        $pagin = ceil($value);
        $cycle12 = active();
        if ($cycle12 != null) {
            $months = list_months($cycle12->getbegindate(), $cycle12->getenddate());
        }
        $refloan;
        if (isset($_GET['loanid'])) {
            $manager2 = new loanManager();
            $refloan = $manager2->return_loan($_GET['loanid']);
        }
        require 'view/refund.php';
    }

    function print_refund() {
        $manager = new loanManager();
        $manager2 = new loanrefundManager();

        $loans = $manager->find_all_loans();
        $interests = $manager2->refund_category("INTERET");

        $principal = $manager2->refund_category("PRINCIPALE");
        require 'view/printTorefund.php';
    }

}

//********************** Diverses controllers *********************************************//
if (true) {

    function diverse_page() {
        $manager = new divcontributionsManager();
        $full_list = $manager->all();
        $list2 = all_member();
        $cycle12 = active();
        $nombre = $full_list['count'];
        $list = $full_list['list'];
        $value = $nombre / 10;
        if ($cycle12 != null) {
            $months = list_months($cycle12->getbegindate(), $cycle12->getenddate());
        }
        $pagin = ceil($value);
        require 'view/diverse.php';
    }

    function diverse_scroll($page) {
        $manager = new divcontributionsManager();
        $res = ($page * 10) - 10;
        $list2 = all_member();
        $list3 = all_cycles();
        $cycle12 = active();
        $result = $manager->pagination($res);
        $list = $result['list'];
        $nombre = $result['count'];
        $value = $nombre / 10;
        if ($cycle12 != null) {
            $months = list_months($cycle12->getbegindate(), $cycle12->getenddate());
        }
        $pagin = ceil($value);
        require 'view/diverse.php';
    }

    function insert_div($par) {
        $manager = new divcontributionsManager();
        return $manager->insert($par);
    }

    function total_diverse() {
        $manager = new divcontributionsManager();
        return $manager->total();
    }

    function get_diverse($id) {
        $manager = new divcontributionsManager();
        $result = $manager->return_div($id);
        if (is_string($result)) {
            return $result;
        } else {
            return json_encode(array_div($result));
        }
    }

    function array_div($cont) {
        $tabs = array(
            'divid' => $cont->getdivid(),
            'amount' => $cont->getamount(),
            'date' => $cont->getdate(),
            'fullname' => $cont->getfullname()
        );
        return $tabs;
    }

    function edit_div($par) {
        $manager = new divcontributionsManager();
        return $manager->edit($par);
    }

    function del_div($id) {
        $manager = new divcontributionsManager();
        return $manager->delete($id);
    }

    function array_divs($list) {
        $tab = array();
        foreach ($list as $cont) {
            $subarray = array(
                'divid' => $cont->getdivid(),
                'amount' => $cont->getamount(),
                'date' => $cont->getdate(),
                'fullname' => $cont->getfullname()
            );
            $tab[] = $subarray;
        }
        return $tab;
    }

    function searchdiv($par) {
        $manager = new divcontributionsManager();
        $list = $manager->search($par);
        return json_encode(array_divs($list));
    }

    function print_div($par) {
        $manager = new divcontributionsManager();
        if ($par['month'] != '') {
            $printlist = $manager->search($par);
            $monthname = month_name($par['month']);
            require 'view/printToDiv.php';
        } else {
            $printlist = $manager->search($par);
            require 'view/printToDiv2.php';
        }
    }

}
//************************* Bilan Controllers***********************************************//
if (true) {

    function bilan_page() {
        $cycle12 = active();
        if ($cycle12 != null) {
            $months = list_months($cycle12->getbegindate(), $cycle12->getenddate());
        }
        require 'view/bilan.php';
    }

    function print_bilan($month) {
        if ($month != "") {
            $precedent = previous_month($month);

            /*             * *********calcul soldes initial**************************** */
            $special = ts_month($precedent);
            $ts_sales = ts_sales($precedent);
            $soldesinitial = $special - $ts_sales;
            /*             * ****************CALCUL BILAN ACTUEL****************************** */
            $specialactual = ts_month($month);
            $ts_salesactual = ts_sales($month);
            $ts_interest = ts_interest($month);
            $soldefinal = $soldesinitial + $specialactual - $ts_salesactual;
            $comission = (0.05) * $ts_interest;


            /*             * **************TONTINE ORDINAIRE***************************** *///
            $ordcotisation = ord_entrer($precedent);
            $ventesordinaire = ord_sortie($precedent);
            $ordinaireinitial = $ordcotisation - $ventesordinaire;
            // ACTUAL PERF ////////////
            $cotissation = ord_entrer($month);
            $ventes = ord_sortie($month);
            $interest = to_interest($month);
            $loaninterest = lo_interest($month);
            $penalte = pen_month($month);
            $depense = exp_per_month($month);
            $final = $ordinaireinitial + $cotissation - $ventes;
            $produit = $interest + $loaninterest + $penalte + $comission;
            $resultat = $produit - $depense;
            /*             * **********DROITS ADHESION **************************** */
            $adhesion = right_month($month);
            //******************FONDS SOCIAL**************************************/
            $socialinitial = social_month($precedent);
            $depot = depot_month($month);
            $help = help_month($month);

            //******************lOANS**********************************************/
            $initialloan = loans_month($precedent);
            $intialprincipal = principal_month($precedent);
            $initialsolde = $initialloan - $intialprincipal;

            $loans = loans_month($month);
            $principal = principal_month($month);
            $interestloan = lo_interest($month);
            $finalsolde = $initialsolde + $loans - $principal;

            //******************MEAL**********************************************/
            $initialmealentry = meal_entry($precedent);
            $initialmealexit = meals_exit_month($precedent);
            $meal_initialsolde = $initialmealentry - $initialmealexit;

            $mealentry = meal_entry($month);
            $mealexit = meals_exit_month($month);
            $mealsolde = $mealentry - $mealexit;
            $monthname = month_name($month);
            require 'view/printToMonth.php';
        } else {
            $cycle12 = active2();
            $beg = $cycle12->getbegindate();
            $beginame = month_name($beg);
            $currentname = month_name(date("Y-m-d"));
            $precedent2 = previous_month($cycle12->getbegindate());

            /*             * *******************calcul soldes initial**************************** */
            $special = ts_month($precedent2); //initial special entry
            $ts_sales = ts_sales($precedent2); //special exit
            $soldesinitial = $special - $ts_sales; // initial special soldes
            /*             * ****************CALCUL BILAN ACTUEL****************************** */
            $specialactual = special_entry(); // actual special entry
            $ts_salesactual = special_exit(); // actual special exit
            $ts_interest = special_sales_interest(); // actual special sales interest
            $soldefinal = $soldesinitial + $specialactual - $ts_salesactual;
            $comission = (0.05) * $ts_interest;


            /*             * **************TONTINE ORDINAIRE***************************** *///
            $ordcotisation = ord_entrer($precedent2); // initial ordinary entry
            $ventesordinaire = ord_sortie($precedent2); // actual ordinary exit
            $ordinaireinitial = $ordcotisation - $ventesordinaire; // initial ordinary soldes
            // ACTUAL PERF ////////////
            $cotissation = ordinary_entry(); // actual ordinary entry
            $ventes = ordinary_exit(); // actual ordinary exit
            $interest = ordinary_sales_interest(); //actual sales ordinary interest
            $loaninterest = interest(); // actual loan interest 
            $penalte = total_pen(); // actual penalty interest 
            $depense = total_exp(); // actual total expense
            $final = $ordinaireinitial + $cotissation - $ventes; // actual final solde
            $produit = $interest + $loaninterest + $penalte + $comission; // actual total products
            $resultat = $produit - $depense; // exploitaion results products - expense
            /*             * **********DROITS ADHESION **************************** */
            $adhesion = total_rights(); // adhesions rights
            //******************FONDS SOCIAL**************************************/
            $socialinitial = social_month($precedent2); // solde initial social
            $depot = total_depot(); // actual social entry
            $help = total_help(); // actual social exit
            //******************lOANS**********************************************/
            $initialloan = loans_month($precedent2);
            $intialprincipal = principal_month($precedent2);
            $initialsolde = $initialloan - $intialprincipal;

            $loans = simpleloans(); // total loans pret
            $principal = principal_month($month); // refund principal remboursement princiaple
            $interestloan = total_principal(); // total actually 
            $finalsolde = $initialsolde + $loans - $principal;

            //******************MEAL**********************************************/
            $initialmealentry = meal_entry($precedent2);
            $initialmealexit = meals_exit_month($precedent2);
            $meal_initialsolde = $initialmealentry - $initialmealexit;

            $mealentry = mealsum_entry();
            $mealexit = total_sales();
            $mealsolde = $mealentry - $mealexit;
            require 'view/printToMonth2.php';
        }
    }

    function previous_month($month) {
        $str = explode("-", $month);
        $num = $str[1];
        $subs = $num - 1;
        if ($subs == 0) {
            $subs = 12;
            $str[0] = $str[0] - 1;
        }
        $precedent = $str[0] . '-' . sprintf("%02d", $subs) . '-' . '01';
        return $precedent;
    }

    function ts_month($month) {
        $manager = new contributionManager();
        return $manager->contrimonth($month);
    }

    function ts_sales($month) {
        $manager = new salesManager();
        return $manager->salesmonth($month);
    }

    function ts_interest($month) {
        $manager = new salesManager();
        return $manager->ts_interest($month);
    }

    function ord_entrer($month) {
        $manager = new contributionManager();
        return $manager->ordinarymonth($month);
    }

    function ord_sortie($month) {
        $manager = new salesManager();
        return $manager->monthordinaire($month);
    }

    function to_interest($month) {
        $manager = new salesManager();
        return $manager->to_interest($month);
    }

    function lo_interest($month) {
        $manager = new loanrefundManager();
        return $manager->interest_month($month);
    }

    function exp_per_month($month) {
        $manager = new expenseManager();
        return $manager->exppermonth($month);
    }

    function pen_month($month) {
        $manager = new penaltyManager();
        return $manager->pen_month($month);
    }

    function right_month($month) {
        $manager = new rightsManager();
        return $manager->rights_month($month);
    }

    function social_month($month) {
        $manager = new socialManager();
        return $manager->social_month($month);
    }

    function depot_month($month) {
        $manager = new socialManager();
        return $manager->depot_month($month);
    }

    function help_month($month) {
        $manager = new socialManager();
        return $manager->help_month($month);
    }

    function loans_month($month) {
        $manager = new loanManager();
        return $manager->loans_month($month);
    }

    function principal_month($month) {
        $manager = new loanrefundManager();
        return $manager->principal_month($month);
    }

    function meal_entry($month) {
        $manager = new contributionManager();
        return $manager->meal_month($month);
    }

    function mealsum_entry() {
        $manager = new contributionManager();
        return $manager->meal_sum();
    }

    function meals_exit_month($month) {
        $manager = new mealManager();
        return $manager->meals_exit_month($month);
    }

    function special_entry() {
        $manager = new contributionManager();
        return $manager->sum_special_entry();
    }

    function ordinary_entry() {
        $manager = new contributionManager();
        return $manager->sum_ordinary_entry();
    }

    function ordinary_exit() {
        $manager = new salesManager();
        return $manager->ordinary_exit();
    }

    function special_exit() {
        $manager = new salesManager();
        return $manager->special_exit();
    }

    function ordinary_sales_interest() {
        $manager = new salesManager();
        return $manager->ordinary_sale_interest();
    }

    function special_sales_interest() {
        $manager = new salesManager();
        return $manager->special_sale_interest();
    }

    function interest() {
        $manager = new loanrefundManager();
        return $manager->interest();
    }

    function total_depot() {
        $manager = new socialManager();
        return $manager->total_depot();
    }

    function total_help() {
        $manager = new socialManager();
        return $manager->total_help();
    }

    function total_principal() {
        $manager = new loanrefundManager();
        return $manager->total_principal();
    }
    
    function active2(){
        $manager = new cyclesManager();
        return $manager->return_active2();
    }

}