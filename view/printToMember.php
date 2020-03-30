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
    <div style="box-shadow: 0px 0px 2px 5px; border-radius: 31px; width: 100%; text-align: center; margin-top: 10px; color: white; background-color:#697889;  ">
        <h1>Carnêts Des Membres</h1>
    </div>
    <table style="width: 400px; margin-top:10px; ">
        <thead>
            <tr style="border-radius: 2px 2px 0px 0px; background:#697889; text-align:center; color:white; ">
                <th>#</th>
                <th style="height:35px;border:none;">Nom Complet</th>
                <th style="border:none;">N° Tel</th>
                <th style="border:none;">Adresse</th>
                <th style="border:none;">Situation F.</th>
                <th style="border:none;">Tontine O.</th>
                <th style="border:none;">Tontine S.</th>
            </tr>
        </thead>

        <?php
        $i = 1;
        $to = 0;
        $ts = 0;
        $sf = 0;
        foreach ($printlist as $mem) {
            ?>
            <tr class="animate">
                <td style="width:15%; text-align: center;"class="bord"><?= $i; ?></td>
                <td style="width:50%;"class="bord"> <?= $mem->getfullname(); ?> </td>
                <td style="width:25%;"class="bord"> <?= $mem->gettelno(); ?> </td>
                <td style="width:25%;"class="bord"> <?= $mem->getadresse(); ?> </td>
                <td style="width:18%; text-align: center;"class="bord"> <?= $mem->getfamilysituation(); ?> </td>
                <td style="width:18%; text-align: center;"class="bord"> <?= $mem->getordinarysharesno(); ?> </td>
                <td style="width:18%; text-align: center;"class="bord"> <?= $mem->getspecialsharesno(); ?></td>
            </tr>
            <?php
            $to += $mem->getordinarysharesno();
            $ts += $mem->getspecialsharesno();
            $sf += $mem->getfamilysituation();
            $i++;
        }
        ?>
        <tr style="border-radius: 2px 2px 0px 0px; background:#697889; text-align:center; color:white; ">
            <td colspan="4" style="width:10%; text-align: center;"class="bord">Totale</td>
            <td  style="width:10%; text-align: center;"class="bord"><?= number_format($sf) ?></td>
            <td  style="width:10%; text-align: center;"class="bord"><?= number_format($to) ?></td>
            <td  style="width:10%; text-align: center;"class="bord"><?= number_format($ts) ?></td>
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
    $pdf->output('list-membres.pdf', 'I');
} catch (HTML2PDF_exception $e) {
    die($e);
}
?>
