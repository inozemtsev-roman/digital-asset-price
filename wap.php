<?php

function waves_asset( $atts ) {
    extract( shortcode_atts( array(
        'id' => '',
        'priceid' => '',
'fiat' => '',
    ), $atts, 'asset' ) );

    $demolph_output = waves_show( $id,$fiat,$priceid );  
    return $demolph_output;
}
add_shortcode( "asset", "waves_asset" );

function waves_show( $id,$fiat,$priceid ) { 
    $response = wp_remote_get( "http://marketdata.wavesplatform.com/api/ticker/$id/$priceid" );
    $body = wp_remote_retrieve_body( $response );
$data = json_decode($body, TRUE);
$cmcap = wp_remote_get("https://api.coinmarketcap.com/v1/ticker/waves/?convert=EUR");
$cmbody = wp_remote_retrieve_body($cmcap);
$cmdata = json_decode($cmbody, TRUE);
    $asset = array_search("$id", array_column($data, 'amountAssetID'));
    $price = $data['24h_close'];
    $pricein = $data["priceAssetID"];
    $pricename = $data["priceAssetName"];
    $wprice = $cmdata[0]["price_usd"];
    $btcprice = $cmdata[0]["price_btc"];
     $eurprice = $cmdata[0]["price_eur"];
     if ($pricein == "WAVES"){
    if($fiat == "waves"){
return $price;
    }  elseif ($fiat == "btc"){
        return number_format($price*$btcprice, 10);
    } elseif ($fiat == "eur"){
         return number_format($price*$eurprice, 10);
    }
    else{
         return number_format($price*$wprice, 10);

    }
     } else {
         return "$price $pricename";
     }
} 