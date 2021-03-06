<?php
ob_start();
?>
<style type="text/css">
    table {
        border-collapse: collapse;
        width:100%;
    }
    .bord {
        border: 0.4px solid grey;
        height: 40px;
    }
    .green{
        background-color: #4ba64f;
    }
    .red{
        background-color: #e8423f;
    }
</style>
<page backtop="20mm" backleft="10mm" backright="10mm" backbottom="0mm">
    <table>
        <tr style="" >
            <td style=" " >
                <img src="view/images/eyocreative-logo.png" alt="eyo" >
            </td>
            <td style="padding-left: 290px;" >
                <img src="view/images/cradeb.png" alt="eyo" >
            </td>
        </tr>
    </table>
    <div style="width:100%;  padding-top:10px;border-bottom:0.6px solid grey;">
    </div>
    <div style="box-shadow: 0px 0px 2px 5px; border-radius: 31px; width: 100%; text-align: center; margin-top: 20px; color: white; background-color:#697889;  ">
        <h1>Bilan Mensuel Fond-Social <?= $monthname ?></h1>
    </div>
    <table style="width: 400px; margin-top:30px; ">
        <thead>
            <tr style="border-radius: 2px 2px 0px 0px; background:#697889; text-align:center; color:white; ">
                <th>#</th>
                <th style="height:35px; border:none;">Noms Complet</th>
                <th style="border:none;">Sit F.</th>
                <th style="border:none;">Ton O.</th>
                <th style="border:none;">Date</th>
                <th style="border:none;">Montant</th>
                <th style="border:none;">Montant DU</th>
                <th style="border:none;">Cumul.</th>
                <th style="border:none;">Soldes</th>
            </tr>
        </thead>

        <?php
        $j = 0;
        $i = 1;
        $sf = 0;
        $to = 0;
        $amt = 0;
        $du = 0;
        $cum = 0;

        foreach ($printlist as $mem) {
            ?>
            <tr class="animate">
                <td style="width:10%; text-align: center;"class="bord"><?= $i; ?></td>
                <td style="width:30%;text-align: center;"class="bord"> <?= $mem->getfullname() ?> </td>
                <td style="width:10%;text-align: center;"class="bord"> <?= $mem->getfamilysituation() ?> </td>
                <td style="width:10%;text-align: center;"class="bord"> <?= $mem->getordinarysharesno() ?> </td>
                <td style="width:20%;text-align: center;"class="bord"> <?= $mem->getdate() ?> </td>
                <td style="width:30%;text-align: center;"class="bord"> <?= number_format($mem->getamount()) ?> </td>
                <td style="width:20%;text-align: center;"class="bord"> <?= number_format($mem->getfamilysituation() * 50000) ?> </td>
                <td style="width:20%;text-align: center;"class="bord">
                    <?php
                    while (true) {
                        if($mem->getfullname() == $cumul_list[$j]->getfullname()) {
                            echo number_format($cumul_list[$j]->getamount());
                            break;
                        } else {
                            $j++;
                        }
                    }
                    ?> 
                </td>
                <td style="width:20%;text-align: center;"class="bord"> <?= number_format(($mem->getfamilysituation() * 50000) - ($cumul_list[$j]->getamount())) ?> </td>
            </tr>
            <?php
            $sf += $mem->getfamilysituation();
            $to += $mem->getordinarysharesno();
            $amt += $mem->getamount();
            $du += $mem->getfamilysituation() * 50000;
            $cum += $cumul_list[$j]->getamount();
            $i++;
            $j++;
        }
        ?>
        <tr style="border-radius: 2px 2px 0px 0px; background:#697889; text-align:center; color:white; ">
            <td colspan="2" style="width:10%; text-align: center;"class="bord">Total</td>
            <td  style="width:10%; text-align: center;"class="bord"><?= $sf ?></td>
            <td  style="width:10%; text-align: center;"class="bord"><?= $to ?></td>
            <td  style="width:10%; text-align: center;"class="bord">/</td>
            <td  style="width:10%; text-align: center;"class="bord"><?= number_format($amt) ?></td>
            <td  style="width:10%; text-align: center;"class="bord"><?= number_format($du) ?></td>
            <td  style="width:10%; text-align: center;"class="bord"><?= number_format($cum) ?></td>
            <td  style="width:10%; text-align: center;"class="bord"><?= number_format($du - $cum) ?></td>
        </tr>
    </table>

<!--    <table>
    <tr>
        <td style="line-height:22px;width:100%;"  style="padding-top:10px; color:grey">
            Thank you for your order! <br>
            If you have any questions, please feel free to contact us at e-store@vizio.com
        </td>
    </tr>
</table>-->
    <table>
        <tr>
            <td style="text-align: center; padding-top:30px; color:grey">
                Copyright &copy; 2018 Mobile-CU. All rights reserved. Visitez nous sur : www.eyocreative.com
            </td>
        </tr>
    </table>
    <div style="width:100%;  padding-top:10px;border-bottom:0.6px solid grey;"></div>
</page>

<?php
$content = ob_get_clean();
require('vendor/html2pdf/html2pdf.class.php');
try {
    $pdf = new HTML2PDF('P', 'A4', 'fr');
    $pdf->pdf->setDisplayMode('fullpage');
    $pdf->writeHTML($content);
    $pdf->output('Bilan mensuel fond-social ' . $monthname . '.pdf', 'I');
} catch (HTML2PDF_exception $e) {
    die($e);
}
?>

