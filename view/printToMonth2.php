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
        <h1>BILAN FINANCIER CUMULATIVE <?= '<br>'.$beginame.'==>'.$currentname ?> </h1>
    </div>
    <table style="width: 400px; margin-top:60px; margin-left: 0px;">
        <thead>
            <tr style="border-radius: 2px 2px 0px 0px; background:#697889; text-align:center; color:white; ">
                <th colspan="3"><H4>TONTINE SPECIALE</H4></th>
            </tr>
            <tr style="border-radius: 2px 2px 0px 0px; background:#697889; text-align:center; color:white; ">
                <th>#</th>
                <th style="height:35px;border:none;">Libellés</th>
                <th style="text-align: center;border:none;">Montant (FCFA)</th>
            </tr>
        </thead>

        <tr>
            <td style="text-align: center;text-align: center; width:40%;"class="bord" colspan="2"> SOLDE INITIAL </td>
            <td style="text-align: center;width:60%;"class="bord" ><?= number_format($soldesinitial); ?> </td>
        </tr>

        <tr>
            <td style="text-align: center;width:10%;"class="bord"> 1 </td>
            <td style="width:80%;"class="bord" > CONTRIBUTIONS TONTINE SPECIALE </td>
            <td style="text-align: center;width:60%;"class="bord" ><?= number_format($specialactual); ?> </td>
        </tr>

        <tr>
            <td style="text-align: center;width:10%;"class="bord"> 2 </td>
            <td style="width:40%;"class="bord"> SORTIE </td>
            <td style="text-align: center;width:60%;"class="bord"><?= number_format($ts_salesactual); ?> </td>
        </tr>

        <tr>
            <td style="text-align: center;width:10%;"class="bord"> 3 </td>
            <td style="width:80%;"class="bord"> INTERET TONTINE SPECIALE </td>
            <td style="text-align: center;width:75%;"class="bord"> <?= number_format($ts_interest); ?> </td>
        </tr>

        <tr>
            <td style="text-align: center;width:10%;"class="bord" > 4 </td>
            <td style="width:80%;"class="bord" > PENALITE </td>
            <td style="text-align: center;width:60%;"class="bord"><?= number_format(0); ?> </td>
        </tr>

        <tr>
            <td style="text-align: center;width:10%;"class="bord" > 5 </td>
            <td style="width:80%;"class="bord"> FRAIS FONTIONNEMENT BUREAU ET PRIME BUREAU </td>
            <td style="text-align: center;width:60%;"class="bord" ><?= number_format($comission); ?> </td>
        </tr>
        
        <tr>
            <td style="text-align: center;width:10%;"class="bord"> 6 </td>
            <td style="width:80%;"class="bord"> CHARGES FONTIONNEMENT</td>
            <td style="text-align: center;width:60%;"class="bord"><?= number_format(0); ?> </td>
        </tr>
        
        <tr>
            <td style="text-align: center;width:10%;"class="bord" >7</td>
            <td style="width:40%;"class="bord"> SOLDES FINAL </td>
            <td style="text-align: center;width:60%;"class="bord"><?= number_format($soldefinal); ?> </td>
        </tr>
        
        <tr style="border-radius: 2px 2px 0px 0px; background:#697889; text-align:center; color:white; ">
            <td style="width:40%;"class="bord" colspan="2"> RESULTAT D'EXPLOITATION </td>
            <td style="text-align: center;width:60%;"class="bord"><?= number_format($ts_interest-$comission); ?> </td>
        </tr>

    </table>
    
    <!--***************************************** Ordinary Table ******************************************-->
    <table style="width: 400px; margin-top:219px; margin-left: 0px;">
        <thead>
            <tr style="border-radius: 2px 2px 0px 0px; background:#697889; text-align:center; color:white; ">
                <th colspan="3"><H4>TONTINE ORDINAIRE</H4></th>
            </tr>
            <tr style="border-radius: 2px 2px 0px 0px; background:#697889; text-align:center; color:white; ">
                <th>#</th>
                <th style="height:35px;border:none;">Libellés</th>
                <th style="text-align: center;border:none;">Montant (FCFA)</th>
            </tr>
        </thead>

        <tr>
            <td style="text-align: center;text-align: center; width:40%;"class="bord" colspan="2"> SOLDE INITIAL </td>
            <td style="text-align: center;width:60%;"class="bord" ><?= number_format($ordinaireinitial); ?> </td>
        </tr>

        <tr>
            <td style="text-align: center;width:10%;"class="bord"> 1 </td>
            <td style="width:80%;"class="bord" > CONTRIBUTIONS TONTINE ORDINAIRE </td>
            <td style="text-align: center;width:60%;"class="bord" ><?= number_format($cotissation); ?> </td>
        </tr>

        <tr>
            <td style="text-align: center;width:10%;"class="bord"> 2 </td>
            <td style="width:40%;"class="bord"> SORTIE </td>
            <td style="text-align: center;width:60%;"class="bord"><?= number_format($ventes); ?> </td>
        </tr>

        <tr>
            <td style="text-align: center;width:10%;"class="bord"> 3 </td>
            <td style="width:40%;"class="bord"> INTERET TONTINE ORDINAIRE </td>
            <td style="text-align: center;width:75%;"class="bord"> <?= number_format($interest); ?> </td>
        </tr>
         <tr>
            <td style="text-align: center;width:10%;"class="bord" >4</td>
            <td style="width:40%;"class="bord"> SOLDES FINAL </td>
            <td style="text-align: center;width:60%;"class="bord"><?= number_format($final); ?> </td>
        </tr>
        <!-- SEPERATOR -->
        <tr>
            <td style="text-align: center;text-align: center; width:40%;"class="bord" colspan="3"> </td> 
        </tr>
        <!--Next-->
        <tr>
            <td style="text-align: center;width:10%;"class="bord"> 5 </td>
            <td style="width:40%;"class="bord"> INTERET PRÊT </td>
            <td style="text-align: center;width:75%;"class="bord"> <?= number_format($loaninterest); ?> </td>
        </tr>
        <tr>
            <td style="text-align: center;width:10%;"class="bord" > 6 </td>
            <td style="width:40%;"class="bord" > PENALITE ET ARRONDIS </td>
            <td style="text-align: center;width:60%;"class="bord"><?= number_format($penalte); ?> </td>
        </tr>

        <tr>
            <td style="text-align: center;width:10%;"class="bord" > 7 </td>
            <td style="width:40%;"class="bord"> AUTRE PRODUITS FRAIS FONTIONNEMENT </td>
            <td style="text-align: center;width:60%;"class="bord" ><?= number_format($comission); ?> </td>
        </tr>
        <tr>
            <td style="text-align: center;text-align: center; width:40%;"class="bord" colspan="2">TOTAL PRODUITS </td> 
            <td style="text-align: center;width:60%;"class="bord"><?= number_format($produit); ?> </td>
        </tr>
        
          <!-- SEPERATOR -->
        <tr>
            <td style="text-align: center;text-align: center; width:40%;"class="bord" colspan="3"> </td> 
        </tr>
        <!--Next-->
        
        <tr>
            <td style="text-align: center;width:10%;"class="bord"> 6 </td>
            <td style="width:80%;"class="bord">TOTAL CHARGES FONTIONNEMENT</td>
            <td style="text-align: center;width:60%;"class="bord"><?= number_format($depense); ?> </td>
        </tr>
        
         <!-- SEPERATOR -->
        <tr>
            <td style="text-align: center;text-align: center; width:40%;"class="bord" colspan="3"> </td> 
        </tr>
        <!--Next-->
        
        <tr style="border-radius: 2px 2px 0px 0px; background:#697889; text-align:center; color:white; ">
            <td style="width:40%;"class="bord" colspan="2"> RESULTAT D'EXPLOITATION </td>
            <td style="text-align: center;width:60%;"class="bord"><?= number_format($resultat); ?> </td>
        </tr>

    </table>
    
    <!--***************************************ADHESION RIGHTS********************************************-->
     <table style="width: 400px; margin-top:230px; margin-left: 0px;">
        <thead>
            <tr style="border-radius: 2px 2px 0px 0px; background:#697889; text-align:center; color:white; ">
                <th colspan="3"><H4>DROITS D'ADHESION</H4></th>
            </tr>
            <tr style="border-radius: 2px 2px 0px 0px; background:#697889; text-align:center; color:white; ">
                <th>#</th>
                <th style="height:35px;border:none;">Libellés</th>
                <th style="text-align: center;border:none;">Montant (FCFA)</th>
            </tr>
        </thead>


        <tr>
            <td style="text-align: center;width:10%;"class="bord"> 1 </td>
            <td style="width:80%;"class="bord" > DROITS D'ADHESION </td>
            <td style="text-align: center;width:75%;"class="bord" ><?= number_format($adhesion); ?> </td>
        </tr>

        <tr>
            <td style="text-align: center;width:10%;"class="bord" > 2 </td>
            <td style="width:40%;"class="bord" > DROITS D'ADHESION SORTIE </td>
            <td style="text-align: center;width:60%;"class="bord" >/</td>
        </tr>

    </table>
    <!--***************************************FONDS SOCIAL********************************************-->
    <table style="width: 400px; margin-top:60px; margin-left: 0px;">
        <thead>
            <tr style="border-radius: 2px 2px 0px 0px; background:#697889; text-align:center; color:white; ">
                <th colspan="3"><H4>FONDS SOCIAL</H4></th>
            </tr>
            <tr style="border-radius: 2px 2px 0px 0px; background:#697889; text-align:center; color:white; ">
                <th>#</th>
                <th style="height:35px;border:none;">Libellés</th>
                <th style="text-align: center;border:none;">Montant (FCFA)</th>
            </tr>
        </thead>

        <tr>
            <td style="text-align: center;text-align: center; width:40%;"class="bord" colspan="2"> SOLDE INITIAL </td>
            <td style="text-align: center;width:60%;"class="bord" ><?= number_format($socialinitial); ?> </td>
        </tr>

        <tr>
            <td style="text-align: center;width:10%;"class="bord"> 1 </td>
            <td style="width:40%;"class="bord" > TOTAL ENTREES </td>
            <td style="text-align: center;width:60%;"class="bord" ><?= number_format($depot); ?> </td>
        </tr>

        <tr>
            <td style="text-align: center;width:10%;"class="bord"> 2 </td>
            <td style="width:80%;"class="bord"> TOTAL DEPENSES </td>
            <td style="text-align: center;width:60%;"class="bord"><?= number_format($help); ?> </td>
        </tr>

        <tr style="border-radius: 2px 2px 0px 0px; background:#697889; text-align:center; color:white; ">
            <td style="width:40%;"class="bord" colspan="2"> SOLDE FINAL </td>
            <td style="text-align: center;width:75%;"class="bord"><?= number_format($depot-$help); ?> </td>
        </tr>

    </table>
    <!--***************************************Meal**************************************************-->
     <table style="width: 400px; margin-top:60px; margin-left: 0px;">
        <thead>
            <tr style="border-radius: 2px 2px 0px 0px; background:#697889; text-align:center; color:white; ">
                <th colspan="3"><H4>REPAS</H4></th>
            </tr>
            <tr style="border-radius: 2px 2px 0px 0px; background:#697889; text-align:center; color:white; ">
                <th>#</th>
                <th style="height:35px;border:none;">Libellés</th>
                <th style="text-align: center;border:none;">Montant (FCFA)</th>
            </tr>
        </thead>

        <tr>
            <td style="text-align: center;text-align: center; width:40%;"class="bord" colspan="2"> SOLDE INITIAL </td>
            <td style="text-align: center;width:60%;"class="bord" ><?= number_format($meal_initialsolde); ?> </td>
        </tr>

        <tr>
            <td style="text-align: center;width:10%;"class="bord"> 1 </td>
            <td style="width:40%;"class="bord" > TOTAL ENTREES </td>
            <td style="text-align: center;width:60%;"class="bord" ><?= number_format($mealentry); ?> </td>
        </tr>

        <tr>
            <td style="text-align: center;width:10%;"class="bord"> 2 </td>
            <td style="width:80%;"class="bord"> TOTAL SORTIES </td>
            <td style="text-align: center;width:60%;"class="bord"><?= number_format($mealexit); ?> </td>
        </tr>

        <tr style="border-radius: 2px 2px 0px 0px; background:#697889; text-align:center; color:white; ">
            <td style="width:40%;"class="bord" colspan="2"> SOLDE FINAL </td>
            <td style="text-align: center;width:75%;"class="bord"><?= number_format($mealsolde); ?> </td>
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
                Copyright &copy; 2018 Tontine. All rights reserved. Visitez nous sur : www.eyocreative.com
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
    $pdf->output('Sanctions.pdf', 'I');
} catch (HTML2PDF_exception $e) {
    die($e);
}
?>

