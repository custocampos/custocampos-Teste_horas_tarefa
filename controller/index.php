<?php

require_once __DIR__ ."./../model/db_connect.php";

function foo($seconds) {
    $t = round($seconds);
    return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
  }

if(isset($_GET['id'])){

    $idDeal=$_GET['id'];
    $resultDeal=getDeal($idDeal);
    $resultDecodDeal=(array)json_decode($resultDeal);
    $resultDecodDeal=$resultDecodDeal["result"] -> UF_CRM_1595371666;
    $posicao = strpos($resultDecodDeal, 'task/view/');
    $idField = substr($resultDecodDeal, $posicao+10);
    $idTask = str_replace("/","",$idField);


    //$idTask="4465";
    $result1=getTask($idTask);
    $resultDecod1=(array)json_decode($result1);

    $tempoPrinc = (int) $resultDecod1["result"] -> task -> timeSpentInLogs;

    $result2=searchTask($idTask);
    $resultDecod2=(array)json_decode($result2);
    $resultDecod2=$resultDecod2["result"];

    $tempoSum=0;
    $tempoSum2=0;


    if(!empty($resultDecod2 -> tasks)){
        $resultDecod2=$resultDecod2->tasks;

        foreach($resultDecod2 as $dado){
            $tempo =(int) $dado -> timeSpentInLogs;
            $tempoSum=$tempoSum+$tempo;

            $idSub= $dado -> id;
            $result3=searchTask($idSub);
            $resultDecod3=(array)json_decode($result3);
            $resultDecod3=$resultDecod3["result"];

            if(!empty($resultDecod3 -> tasks)){
                $resultDecod3=$resultDecod3->tasks;

                foreach($resultDecod3 as $dado2){
                    $tempo2 =(int) $dado2 -> timeSpentInLogs;
                    $tempoSum2=$tempoSum2+$tempo2;
                }
            }
        }
        
    }

    $tempoTotal= $tempoPrinc + $tempoSum + $tempoSum2;
    $tempoTotal=foo($tempoTotal);

    $fim=updateDeal($idDeal,$tempoTotal);

    echo $fim;
}else{
    echo "não foi passado nenhum id";
}

?>




