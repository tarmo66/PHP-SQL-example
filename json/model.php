<?php
function insertData($data, $conn)
{
    $organisation = $data['organisation'];
    $child = $data['child'];

    $sql = "INSERT INTO apiTable (ORGANISATION, CHILD) VALUES ('$organisation', '$child')";
    mysqli_query($conn, $sql);
}


function getParent($input, $conn)
{
    /*
    $this->db->select("ORGANISATION");
    $this->db->from('organisations');
    $this->db->where('CHILD', 'Black Banana');
    $this->db->limit(100);
    //$sql = $this->db->get_compiled_select();
    //$this->db->order_by('ORGANISATION DESC');
    $query = $this->db->get();
    return $query->result_array();
    */

    $child = $input;
    $apiParent = array();

    $sql = "SELECT * FROM apiTable WHERE CHILD = '$child'";
    //$sql = "SELECT * FROM apiTable";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            array_push($apiParent, $row['ORGANISATION']);
        // Free result set
        //mysqli_free_result($result);
        }
    }

    /*
    if(mysqli_num_rows($result) > 0){
        echo "<table>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
                echo "<td>" . $row['ID'] . "</td>";
                echo "<td>" . $row['ORGANISATION'] . "</td>";
                array_push($apiParent, $row['ORGANISATION']);
                echo "<td>" . $row['CHILD'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    */
    mysqli_free_result($result);
    return $apiParent;
}

function getSister($parent, $conn)
{
    $apiSister = array();

    $sql = "SELECT * FROM apiTable WHERE ORGANISATION = '$parent'";
    //$sql = "SELECT * FROM apiTable";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            array_push($apiSister, $row['CHILD']);
        // Free result set
        //mysqli_free_result($result);
        }
    }

    mysqli_free_result($result);
    return $apiSister;
}

function getChildren($input, $conn)
{
    $apiChildren = array();

    $sql = "SELECT * FROM apiTable WHERE ORGANISATION = '$input'";
    //$sql = "SELECT * FROM apiTable";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            array_push($apiChildren, $row['CHILD']);
        // Free result set
        //mysqli_free_result($result);
        }
    }

    mysqli_free_result($result);
    return $apiChildren;
}

function deleteData($conn)
{
    $sql = "TRUNCATE TABLE apiTable";
    mysqli_query($conn, $sql);
}