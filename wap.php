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