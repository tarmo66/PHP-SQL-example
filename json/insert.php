<?php
require_once 'config.php';
require 'model.php';

deleteData($conn);

$json = (json_decode(file_get_contents("php://input"), true));
//var_dump($json);

foreach($json as $elem)  {
    echo( $elem['org_name']. " child " );
        if (isset($elem['daugthers'])) {
        foreach ($elem['daugthers'] as $child ) {
            echo($child['org_name']. "<br>");
            $data = array(
                'organisation' => $elem['org_name'],
                'child' => $child['org_name']
            );
            insertData($data, $conn);
                if (isset($child['daugthers'])) {
                foreach ($child['daugthers'] as $grandchild) {
                echo($child['org_name'] . ' child ' . $grandchild['org_name']. "<br>");
                $data = array(
                    'organisation' => $child['org_name'],
                    'child' => $grandchild['org_name']
                    );
                insertData($data, $conn);
                    if (isset($grandchild['daugthers'])) {
                    foreach ($grandchild['daugthers'] as $grandgrandchild) {
                        if (isset($grandchild['daugthers'])) echo($grandchild['org_name'] . ' child ' . $grandgrandchild['org_name']. "<br>");
                        $data = array(
                        'organisation' => $grandchild['org_name'],
                        'child' => $grandgrandchild['org_name']
                        );
                        insertData($data, $conn);   
                    }
                    }
                }
                }
        }
        echo("<br/>");
    }
}

//$json = 'test';


// Takes raw data from the request


//$this->apiItem = $this->Api_model->clearTable(); 

?>