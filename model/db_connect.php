<?php

function baseUrl()
{
    return "https://bmit.bitrix24.com.br/rest/1481/qg1as8kjsxnrthjs/";
}

function doRequest($queryUrl, $queryData)
{

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $queryUrl,
        CURLOPT_POSTFIELDS => $queryData,
    ));

    $result = curl_exec($curl);
    curl_close($curl);

    if ($result) {
        return $result;
    }

}


   
    function getTask($idTask)
    {

        $queryUrl = baseUrl() . '/tasks.task.get.json';
        $queryData = http_build_query(array(
            'taskId' => $idTask
            
        ));
        return doRequest($queryUrl, $queryData);

    }

    function searchTask($idTask)
    {

        $queryUrl = baseUrl() . '/tasks.task.list.json';
        $queryData = http_build_query(array(
            'filter' => array("PARENT_ID" => $idTask),
        ));
        return doRequest($queryUrl, $queryData);

    }

    function getDeal($idDeal)
    {

        $queryUrl = baseUrl() . '/crm.deal.get.json';
        $queryData = http_build_query(array(
            "ID" => $idDeal,
        ));
        return doRequest($queryUrl, $queryData);

    }

    function updateDeal($id,$tempo)
    {
        $queryUrl = baseUrl() . '/crm.deal.update.json';
        $queryData = http_build_query(array(
            'ID' => $id,
            'fields' => array(
                "UF_CRM_1595454596" => $tempo,
                
                ),
        ));

    return doRequest($queryUrl, $queryData);
}