<?php

require 'vendor/autoload.php';
use BenFryer\BenFryer;

$ip = $_SERVER['REMOTE_ADDR'];
$json_str = file_get_contents('php://input');
$data = json_decode($json_str);
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
$fryer = new BenFryer();

if (isset($data)) {
    $returnarray = array();
    foreach ($data as $parse){
        $fryer->saveIp($ip,$parse);
        $check = $fryer->checkDat($parse);
        if ($check) {
            $returnarray[] = $fryer->getDat($parse);
        } else {
            if (filter_var($parse, FILTER_VALIDATE_URL)) {
                if (substr($parse, -4, 4) == '.svg' || substr($parse, -4, 4) == '.gif') {
                    $returnarray = [
                        false,
                        'invalid format'
                    ];
                } else {
                    $size = $fryer->misEnPlace($parse);
                    if (is_numeric($size)) {
                        if ($size < 400000) {
                            $file = $fryer->grabImage($parse);
                            $fryer->dropIn($file);
                            $fryer->fry(100);
                            $fryer->moreDeepNibba();
                            $fryer->sharpen();
                            $returned = $fryer->takeOut();
                            $fryer->saveDat($parse, $returned);
                            $returnarray[] = $returned;
                            $fryer->acetone($parse);
                        } else {
                            $returnarray = [
                                false,
                                $size . 'Is too large'
                            ];
                        }
                    } else {
                        $returnarray = [
                            false,
                            $size
                        ];
                    }
                }
            }
        }
    }
} else {
    $returnarray = [
        false,
        'Image provided was not found!'
    ];
}
$json = json_encode($returnarray, JSON_FORCE_OBJECT);

echo $json;
