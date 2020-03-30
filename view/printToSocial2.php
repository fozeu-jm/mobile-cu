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
        <h1>Bilan Fin De Cycle Fond-Social </h1>
    </div>
    <table style="width: 400px; margin-top:30px; margin-left: -25px; ">
        <thead>
            <tr style="border-radius: 2px 2px 0px 0px; background:#697889; text-align:center; color:white; ">
                <th>#</th>
                <th style="height:35px; border:none;">Noms Complet</th>
                <th style="border:none;">Sit F.</th>
                <th style="border:none;">Ton O.</th>
                <th style="border:none;">Cotissé</th>
                <th style="border:none;">DU</th>
                <th style="border:none;">Soldes</th>
                <th style="border:none;">A Rembou.</th>
                <th style="border:none;">A Compl</th>
                <th style="border:none;">Signature</th>
            </tr>
        </thead>

        <?php
        $j = 0;
        $i = 1;
        $sf = 0;
        $to = 0;
        $cot = 0;
        $du = 0;
        $cum = 0;
        $compl = 0;
        $remb = 0;

        foreach ($cumul_list as $mem) {
            ?>
            <tr class="animate">
                <td style="width:10%; text-align: center;"class="bord"><?= $i; ?></td>
                <td style="width:30%;text-align: center;"class="bord"> <?= $mem->getfullname() ?> </td>
                <td style="width:10%;text-align: center;"class="bord"> <?= $mem->getfamilysituation() ?> </td>
                <td style="width:10%;text-align: center;"class="bord"> <?= $mem->getordinarysharesno() ?> </td>
                <td style="width:20%;text-align: center;"class="bord"> <?= number_format($mem->getamount()) ?> </td>
                <td style="width:20%;text-align: center;"class="bord"> <?= number_format($mem->getfamilysituation() * 50000) ?> </td>
                <td style="width:20%;text-align: center;"class="bord"> <?= number_format(($mem->getfamilysituation() * 50000) - ($mem->getamount())) ?> </td>
                <td style="width:15%;text-align: center;"class="bord">
                    <?php
                    if (($mem->getfamilysituation() * 50000) - ($mem->getamount()) < 0) {
                        echo number_format(($mem->getfamilysituation() * 50000) - ($mem->getamount()));
                        $remb += ($mem->getfamilysituation() * 50000) - ($mem->getamount());
                    } else {
                        echo '0';
                    }
                    ?>
                </td>
                <td style="width:15%;text-align: center;"class="bord">
                    <?php
                    if (($mem->getfamilysituation() * 50000) - ($mem->getamount()) > 0) {
                        echo number_format(($mem->getfamilysituation() * 50000) - ($mem->getamount()));
                        $compl += ($mem->getfamilysituation() * 50000) - ($mem->getamount());
                    } else {
                        echo '0';
                    }
                    ?>
                </td>
                <td style="width:25%;text-align: center;"class="bord"></td>
            </tr>
            <?php
            $sf += $mem->getfamilysituation();
            $to += $mem->getordinarysharesno();
            $cot += $mem->getamount();
            $du += $mem->getfamilysituation() * 50000;
            $i++;
        }
        ?>
        <tr style="border-radius: 2px 2px 0px 0px; background:#697889; text-align:center; color:white; ">
            <td colspan="2">Totale</td>
            <td><?= number_format($sf) ?></td>
            <td><?= number_format($to) ?></td>
            <td><?= number_format($cot) ?></td>
            <td><?= number_format($du) ?></td>
            <td>/</td>
            <td><?= number_format($remb) ?></td>
            <td><?= number_format($compl) ?></td>
            <td></td>
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
    $pdf->output('Bilan generale fond-social.pdf', 'I');
} catch (HTML2PDF_exception $e) {
    die($e);
}
?>

