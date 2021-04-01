<?php
function json_data($data,$msg = ""){
    header("content-type:application/json;chartset=uft-8");
    if ($data !== null) {
        echo json_encode(["code" => 200, "msg" => $msg, 'data' => $data]);
    } else {
        echo json_encode(["code" => 200, "msg" => $msg]);
    }
    die;
}
