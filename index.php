<?php

/*
  use myModel;
  $ins = new myModel();
 */

$series = 'http://botcards.jlparry.com/data/series';
$certificates = 'http://botcards.jlparry.com/data/certificates';
$transactions = 'http://botcards.jlparry.com/data/transactions';
$series_data = _retrieve_data($series);
//print_r($series_data);
$certificates_data = _retrieve_data($certificates);
//                 print_r($certificates_data);
$transactions_data = _retrieve_data($transactions);
print_r(get_all_bot_names($series_data));

function get_all_bot_names($array) {
    $_arr;
    foreach ($array as $t) {

        $_arr[] = $t['description'];
    }
    return $_arr;
}

function get_all_bot_codes($array) {
    $_arr;
    foreach ($array as $t) {

        $_arr[] = $t['code'];
    }
    return $_arr;
}

/*
  function get_bot_by_code($code){
  $_arr;
  foreach($array as $t){

  $_arr[]= $t['code'];
  }
  return $_arr;
  }
 * */

/*
  function get_all_players() {
  $list = [];
  foreach ($this->certificates_data as $c) {
  $list[] = $c['player'];
  }
  $list = array_unique($list);
  return $list;
  }
 */

function _retrieve_data($url) {
    $response = get_data($url);
    $arr = format_content($response);
    return $arr;
}

function format_content($response) {
    $_arr = [];
    $Data = str_getcsv($response, "\n"); //parse the rows 
    foreach ($Data as &$Row) {
        $Row = str_getcsv($Row);
        $_arr[] = $Row;
    }
    $arr = _format($_arr);
    return $arr;
}

function _format($arr) {
    //$_arr = [];
    $_arr_list = [];
    //echo count(array_keys($arr));
    for ($x = 1; $x < count(array_keys($arr)); $x++) {

        $_arr_list[] = array_combine($arr[0], $arr[$x]);
        //print_r($_arr);
    }
    return $_arr_list;
}

function get_data($url) {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
?>

