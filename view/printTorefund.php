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
        <h1>Journal Individuel : Suivi Des Prêts</h1>
    </div>
    <table style="width: 400px; margin-top:30px; ">
        <thead>
            <tr style="border-radius: 2px 2px 0px 0px; background:#697889; text-align:center; color:white; ">
                <th>#</th>
                <th style="height:35px; border:none;">Noms Complet</th>
                <th style="border:none;">Totale prêté</th>
                <th style="border:none;">Totale Interêts</th>
                <th style="border:none;">Totale Principale</th>
                <th style="border:none;">Soldes</th>
                <th style="border:none;">Situation</th>
            </tr>
        </thead>

        <?php
        $i = 1;
        $amt = 0;
        $int = 0;
        $prin = 0;
        $soldes = 0;


        foreach ($loans as $mem) {
            $j = 0;
            $k = 0;
            $temp = 0;
            ?>
            <tr class="animate">
                <td style="width:10%; text-align: center;"class="bord"><?= $i; ?></td>
                <td style="width:30%;text-align: center;"class="bord"> <?= $mem->getfullname() ?> </td>
                <td style="width:25%;text-align: center;"class="bord"> <?= number_format($mem->getamount()) ?> </td>
                <!-- INTERET -->
                <td style="width:30%;text-align: center;"class="bord">
                    <?php
                    while (true) {
                        if (isset($interests[$j])) {
                            if ($mem->getfullname() == $interests[$j]->getfullname()) {
                                $int += $interests[$j]->getamount();
                                echo number_format($interests[$j]->getamount());
                                break;
                            } else {
                                $j++;
                            }
                        } else {
                            echo 0;
                            break;
                        }
                    }
                    ?>
                </td>
                <!-- PRINCIPALE -->
                <td style="width:30%;text-align: center;"class="bord">
                    <?php
                        while (true) {
                            if (isset($principal[$k])) {
                                if ($mem->getfullname() == $principal[$k]->getfullname()) {
                                    $prin += $principal[$k]->getamount();
                                    $temp = $principal[$k]->getamount();
                                    echo number_format($principal[$k]->getamount());
                                    break;
                                } else {
                                    $k++;
                                }
                            } else {
                                echo 0;
                                $temp = 0;
                                break;
                            }
                        }
                    ?>
                </td>
                <!-- SOLDES -->
                <td style="width:25%;text-align: center;"class="bord">
                    <?php
                    $soldes += ($mem->getamount() - $temp);
                    echo number_format($mem->getamount() - $temp);
                    ?>
                </td>
                <td style="width:20%;text-align: center;"class="bord">
                    <?php 
                       if(($mem->getamount() - $temp)<=0){
                           echo '<p style="color:blue">Régulière</p>';
                       }else{
                            echo '<p style="color:red">Irrégulière</p>';
                       }
                    ?>
                </td>
            </tr>
            <?php
            $i++;
            $amt += $mem->getamount();
        }
        ?>
        <tr style="border-radius: 2px 2px 0px 0px; background:#697889; text-align:center; color:white; ">
            <td colspan="2" style="width:10%; text-align: center;"class="bord">Total</td>
            <td  style="width:10%; text-align: center;"class="bord"><?=  number_format($amt) ?></td>
            <td  style="width:10%; text-align: center;"class="bord"><?=  number_format($int) ?></td>
            <td  style="width:10%; text-align: center;"class="bord"><?= number_format($prin) ?></td>
            <td  style="width:10%; text-align: center;"class="bord"><?= number_format($soldes) ?></td>
            <td  style="width:10%; text-align: center;"class="bord">/</td>
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
    $pdf->output('Journal individuel prêts.pdf', 'I');
} catch (HTML2PDF_exception $e) {
    die($e);
}
?>

