<?php
require_once 'config.php';
require 'model.php';

//Read Postman request
$json = (json_decode(file_get_contents("php://input"), true));
//var_dump($json);

$input = $json[0]['org_name'];
//$input = 'Black Banana';
$sisters = array();
$sistersCombined = array();

//Get all parents (model.php)
$apiParent = getParent($input, $conn);
foreach ($apiParent as $key => $parent) {
    //Get all organisations with the same parent
    $sisters = getSister($parent, $conn);
    foreach ($sisters as $key => $value) {
        array_push($sistersCombined, $value);
    }
}
//var_dump($sistersCombined);

//model.php
$apiChild = getChildren($input, $conn);
//var_dump($apiChild);

$arrayItem = array();
$results = array();

$parentsfiltered = array_unique($apiParent);

$sisters = array_unique($sistersCombined);

//Remove myself from sisters array
$sistersfiltered = array_diff($sisters, array($input));
    
$childrenfiltered = array_unique($apiChild);

$parentsfiltered = array_unique($apiParent);
//print_r($parentsfiltered);

//Combining results: parents, sisters, children
$i=0;
foreach ($parentsfiltered as $key => $value) {
    $arrayItem[$i]['relationship_type'] = 'parent';
    $arrayItem[$i]['org_name'] = $value;
    array_push($results, $arrayItem[$i]);
    $i++;
}

//var_dump($sistersfiltered);
$i=0;
foreach ($sistersfiltered as $key =>$value){
    $arrayItem[$i]['relationship_type'] = 'sister';
    $arrayItem[$i]['org_name'] = $value;
    array_push($results, $arrayItem[$i]);
    $i++;
}

$childrenfiltered = array_unique($apiChild);
$i=0;
foreach ($childrenfiltered as $key => $value) {
    $arrayItem[$i]['relationship_type'] = 'daugther';
    $arrayItem[$i]['org_name'] = $value;
    array_push($results, $arrayItem[$i]);
    $i++;
}

//Sorting by org_name
function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key => $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}

array_sort_by_column($results, 'org_name');

//json output                     
//$sample_data = json_encode($results);

//HTML output 100 results on a page with pagination
$raw_data = $results;

$page = !isset($_GET['page']) ? 1 : $_GET['page'];
$limit = 100;
$offset = ($page - 1) * $limit;
$total_items = count($raw_data);
$total_pages = ceil($total_items / $limit);
$final = array_splice($raw_data, $offset, $limit);

?>
<?php for($x = 1; $x <= $total_pages; $x++): ?>
    <a href='read.php?page=<?php echo $x; ?>'><?php echo $x; ?></a>
<?php endfor; ?>
<table border="1" cellpadding="10">
    <tr><th>relationship_type</th><th>org_name</th></tr>
    <?php foreach($final as $key => $value): ?>
        <tr>
        <?php foreach($value as $index => $element): ?>
            <td><?php echo !is_array($element) ? $element : implode(',', $element); ?></td>
        <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>