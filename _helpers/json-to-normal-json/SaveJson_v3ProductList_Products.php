<?php

$HOME = strlen($_SERVER['DOCUMENT_ROOT']) != 0 ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['PHP_CRON_HOME'];

include_once "$HOME/env.php";

class SaveJson_v3ProductList_Products {
    static function main() {
        global $HOME;

        $text = file_get_contents("$HOME/data/v3_product_list.json");
        $json = json_decode($text, true);
        $array = $json['data'];

        $OZN_v3ProductList_Products = array_map(function($element) {
            $data = [];

            $str_fields = ['product_id', 'offer_id'];

            $boolean_fields = ['has_fbo_stocks', 'has_fbs_stocks', 'archived', 'is_discounted'];

            $str_array_fields = [];

            $i_dont_now_fields = ['quants'];

            foreach ($str_fields as $current_field) {
                $data[$current_field] = "" . $element[$current_field];
            }

            foreach ($boolean_fields as $current_field) {
                $data[$current_field] = $element[$current_field] ? '1' : '0';
            }

            foreach ($str_array_fields as $current_field) {
                $data[$current_field] = implode(';', $element[$current_field]);
            }

            return $data;
        }, $array);

        $folder = "$HOME/database";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true); 
        }

        $JSON = $OZN_v3ProductList_Products;
        $FILE_PATH = "$HOME/database/OZN_v3ProductList_Products.json";
        $FILE_TEXT = json_encode($JSON, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        file_put_contents($FILE_PATH, $FILE_TEXT);
    }
}
