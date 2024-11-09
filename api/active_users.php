<?php
include_once('../bbs/_common.php');

header('Content-Type: application/json');

$list = array();

$sql = "select mb_id,mb_name from g5_member order by rand() limit 100";
$result = sql_query($sql);
for($i=0;$row=sql_fetch_array($result);$i++){
    $list[] = $row;
}

print_r($list);

?>


