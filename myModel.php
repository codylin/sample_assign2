<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



class myModel {

// put your code here
    protected $series;
    protected $certificates;
    protected $transactions;
    protected $series_data;
    protected $certificates_data;
    protected $transaction_data;

    function __construct() {
        parent::__construct();
        $this->series = 'http://botcards.jlparry.com/data/series';
        $this->certificates = 'http://botcards.jlparry.com/data/certificates';
        $this->transactions = 'http://botcards.jlparry.com/data/transactions';
        $this->series_data = _retrieve_data($this->series);
        $this->certificates_data = _retrieve_data($this->certificates);
        $this->transactions_data = _retrieve_data($this->transactions);
    }
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

}

