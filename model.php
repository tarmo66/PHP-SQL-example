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
    $child = $input;
    $apiParent = array();

    $sql = "SELECT * FROM apiTable WHERE CHILD = '$child'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            array_push($apiParent, $row['ORGANISATION']);
        }
    }

    mysqli_free_result($result);
    return $apiParent;
}

function getSister($parent, $conn)
{
    $apiSister = array();

    $sql = "SELECT * FROM apiTable WHERE ORGANISATION = '$parent'";

    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            array_push($apiSister, $row['CHILD']);
        }
    }

    mysqli_free_result($result);
    return $apiSister;
}

function getChildren($input, $conn)
{
    $apiChildren = array();

    $sql = "SELECT * FROM apiTable WHERE ORGANISATION = '$input'";

    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            array_push($apiChildren, $row['CHILD']);
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