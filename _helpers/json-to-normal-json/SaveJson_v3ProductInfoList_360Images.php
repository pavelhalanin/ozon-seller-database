<?php

$HOME = strlen($_SERVER['DOCUMENT_ROOT']) != 0 ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['PHP_CRON_HOME'];

include_once "$HOME/env.php";

class SaveJson_v3ProductInfoList_360Images {
    static function main() {
        global $HOME;

        $text = file_get_contents("$HOME/data/v3_product_info_list.json");
        $json = json_decode($text, true);
        $array = $json['data'];

        $ai = 0;
        for ($i = 0; $i < count($array); $i++) {
            $element = $array[$i];

            $product_id = $element['id'];
            $j = 0;
            for ($j = 0; $j < count($element['images360']); $j++) {
                $image360 = $element['images360'][$j];

                $data = [];
                $ai += 1;
                $data['custom_auto_increment'] = $ai;
                $data['custom_id'] = "[$i].images360[$j]";
                $data['product_id'] = $product_id;
                $data['image360'] = $image360;

                $result_array []= $data;
            }
        }

        $folder = "$HOME/database";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true); 
        }

        $JSON = $result_array;
        $FILE_PATH = "$HOME/database/OZN_v3ProductInfoList_360Images.json";
        $FILE_TEXT = json_encode($JSON, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        file_put_contents($FILE_PATH, $FILE_TEXT);
    }
}
