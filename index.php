<?php
$memberStateCode = $_POST['memberStateCode'] ;
$vat = $_POST['vat'] ;
$leVat.= $memberStateCode;
$leVat.=$vat;

//die();
$vatid = $leVat; // replace for the VAT-ID you would like to check
$vatid = str_replace(array(' ', '.', '-', ',', ', '), '', trim($vatid));
$cc = substr($vatid, 0, 2);
$vn = substr($vatid, 2);
$client = new SoapClient("http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl");

if($client){
    $valide="Numeros de TVA existe !";
    $params = array('countryCode' => $cc, 'vatNumber' => $vn);
    try{
        $r = $client->checkVat($params);
        if($r->valid == true){
            // VAT-ID is valid 
        } else {
            // VAT-ID is NOT valid
        }

        // This foreach shows every single line of the returned information
       $tableauJson= json_encode($r);

        foreach($r as $k=>$prop){

            echo $k . ': ' . $prop.'<br>';
        }

    } catch(SoapFault $e) {
        echo 'Erreur, voir message: '.$e->faultstring;
    }
} else {
    // Connection to host not possible, europe.eu down?
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body>
<form action="index.php" method="post" accept-charset="utf-8">
<select name="memberStateCode" >
                                    <option value="">--</option>
                                
                                    <option value="AT">AT-Autriche</option>
                                
                                    <option value="BE">BE-Belgique</option>
                                
                                    <option value="BG">BG-Bulgarie</option>
                                
                                    <option value="CY">CY-Chypre</option>
                                
                                    <option value="CZ">CZ-République tchèque</option>
                                
                                    <option value="DE">DE-Allemagne</option>
                                
                                    <option value="DK">DK-Danemark</option>
                                
                                    <option value="EE">EE-Estonie</option>
                                
                                    <option value="EL">EL-Grèce</option>
                                
                                    <option value="ES">ES-Espagne</option>
                                
                                    <option value="FI">FI-Finlande</option>
                                
                                    <option value="FR">FR-France</option>
                                
                                    <option value="GB">GB-Royaume-Uni</option>
                                
                                    <option value="HR">HR-Croatie</option>
                                
                                    <option value="HU">HU-Hongrie</option>
                                
                                    <option value="IE">IE-Irlande</option>
                                
                                    <option value="IT">IT-Italie</option>
                                
                                    <option value="LT">LT-Lituanie</option>
                                
                                    <option value="LU">LU-Luxembourg</option>
                                
                                    <option value="LV">LV-Lettonie</option>
                                
                                    <option value="MT">MT-Malte</option>
                                
                                    <option value="NL">NL-Pays-Bas</option>
                                
                                    <option value="PL">PL-Pologne</option>
                                
                                    <option value="PT">PT-Portugal</option>
                                
                                    <option value="RO">RO-Roumanie</option>
                                
                                    <option value="SE">SE-Suède</option>
                                
                                    <option value="SI">SI-Slovénie</option>
                                
                                    <option value="SK">SK-Slovaquie</option>
                                
                            </select>
    <input type="number" name="vat" value="" placeholder="Le numero">   
    <input type="submit" name="" value="Envoyer">
</form> 

<script>
    var data = <?php         echo $tableauJson= json_encode($r); ?>; //Don't forget the extra semicolon!
    for (var key in data) {
    console.log(key + ' => ' + data[key]);
    // key is key
    // value is p[key]
}
</script>
</body>
</html>