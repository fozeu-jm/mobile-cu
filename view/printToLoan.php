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
    <div style="box-shadow: 0px 0px 2px 5px; border-radius: 31px; width: 100%; text-align: center; margin-top: 50px; color: white; background-color:#697889;  ">
        <h1>Journal Mensuel: Prêts <?= $monthname ?></h1>
    </div>
    <table style="width: 400px; margin-top:60px; margin-left: -20px; ">
        <thead>
            <tr style="border-radius: 2px 2px 0px 0px; background:#697889; text-align:center; color:white; ">
                <th>#</th>
                <th style="border:none;">Date</th>
                <th style="height:35px;border:none;">Nom Complet</th>
                <th style="border:none;">Cheques</th>
                <th style="border:none;">Libellé</th>
                <th style="border:none;">Montant (FCFA)</th>
            </tr>
        </thead>
        <!-- Loan loop -->
        <tr style="background:#697889; ">
            <td colspan="6" style="text-align: center;color: white;"> <h4>Prêts</h4> </td>
        </tr>
        <?php
        $i = 1;
        $pret = 0;
        foreach ($printlist as $mem) {
            ?>
            <tr class="animate">
                <td style="width:15%; text-align: center;"class="bord"><?= $i; ?></td>
                <td style="width:20%;text-align: center;"class="bord"> <?= $mem->getdate() ?> </td>
                <td style="width:40%;"class="bord"> <?= $mem->getfullname() ?> </td>
                <td style="width:40%;"class="bord"><?= $mem->getchequesno() ?></td>
                <td style="width:40%;"class="bord"> </td>
                <td style="width:20%;text-align: center;"class="bord"> <?= number_format($mem->getamount()) ?> </td>
            </tr>
            <?php
            $pret += $mem->getamount();
            $i++;
        }
        ?>
        <tr style="background:#697889; color: white;">
            <td colspan="5" style="text-align: center; color: white;"> Totale du Mois</td>
            <td style=" text-align: center;" ><?= number_format($pret); ?></td>
        </tr>
        <tr style="background:#697889;">
            <td colspan="6" style="text-align: center; color: white;"><h4>Remboursements</h4></td>
        </tr>
        <?php
        $j = 1;
        $remb=0;
        foreach ($reflist as $mem) {
            ?>
            <tr class="animate">
                <td style="width:5%; text-align: center;" class="bord"><?= $j; ?></td>
                <td style="width:20%;text-align: center;" class="bord"> <?= $mem->getdate() ?> </td>
                <td class="bord"> <?= $mem->getfullname() ?> </td>
                <td style="width:40%;" class="bord"> </td>
                <td style="width:40%;" class="bord"> <?= $mem->getlabels() ?> </td>
                <td style="width:20%;text-align: center;"class="bord"> <?= number_format($mem->getamount()) ?> </td>
            </tr>
            <?php
            $remb += $mem->getamount();
            $i++;
        }
        ?>
        <tr style="background:#697889; color: white;">
            <td colspan="5" style="text-align: center; color: white;"> Totale du Mois</td>
            <td style=" text-align: center;" ><?= number_format($remb); ?></td>
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
    $pdf->output('journal_mensuel_prets_'.$monthname.'.pdf', 'I');
} catch (HTML2PDF_exception $e) {
    die($e);
}
?>

