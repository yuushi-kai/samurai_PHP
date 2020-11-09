# restaurants_searcher.php

<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

# 初期設定
$KEYID =  getenv('GRNB_ACCESS_KEY');
$HIT_PER_PAGE = 100;
$PREF = "PREF29";
$FREEWORD_CONDITION = 1;
$FREEWORD = "生駒駅";

$PARAMS = array("keyid"=> $KEYID, "hit_per_page"=>$HIT_PER_PAGE, "pref"=>$PREF, "freeword_condition"=>$FREEWORD_CONDITION, "freeword"=>$FREEWORD);

function write_data_to_csv($params){
    
    $restaurants = [];
    $client = new Client();
    try{
        $json_res = $client->request('GET', "https://api.gnavi.co.jp/RestSearchAPI/v3/", ['query' => $params])->getBody();
    }catch(Exception $e){
        return print("エラーが発生しました。");
    }
    $response = json_decode($json_res,true);
    
    if(isset($response["error"])){
        return(print("エラーが発生しました！"));
    }
    
    print_r($response);
    
    foreach($response["rest"] as &$restaurant){
        $restaurant_name = $restaurant["name"];
        $restaurants[] = $restaurant_name;
    }
    $handle = fopen("restaurants_list.csv", "wb");
    fputcsv($handle, $restaurants);
    fclose($handle);
    return print_r($restaurants);
}

write_data_to_csv($PARAMS);

?>