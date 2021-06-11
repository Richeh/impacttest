<?php 
/**
 * Reads in the entire CSV at the given
 *
 * @todo Error handling would be nice?
 * 
 * @param $path string
 * @return $csvArray Array
 */
function readEntireCsv( $path ){
    $csvArray = Array();
    if( file_exists($path) ){
        $handle = fopen($path, "r");
        while( $row = fgetcsv($handle) ){
            $csvArray[] = $row;
        }
    }    
    return $csvArray;
}