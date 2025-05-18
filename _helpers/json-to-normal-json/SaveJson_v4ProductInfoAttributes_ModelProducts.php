<?php

$HOME = strlen($_SERVER['DOCUMENT_ROOT']) != 0 ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['PHP_CRON_HOME'];

include_once "$HOME/env.php";

class SaveJson_v4ProductInfoAttributes_ModelProducts {
    static function main() {
        global $HOME;

        $text = file_get_contents("$HOME/data/v4_product_info_attributes.json");
        $json = json_decode($text, true);
        $array = $json['data'];

        $OZN_v4ProductInfoAttributes_ModelProducts = array_map(function($element) {
            $data['product_id'] = '' . $element['id'];

            $element = $element['model_info'];

            $str_fields = ['model_id', 'count'];

            $boolean_fields = [];

            $str_array_fields = [];

            $i_dont_now_fields = [];

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

        $JSON = $OZN_v4ProductInfoAttributes_ModelProducts;
        $FILE_PATH = "$HOME/database/OZN_v4ProductInfoAttributes_ModelProducts.json";
        $FILE_TEXT = json_encode($JSON, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        file_put_contents($FILE_PATH, $FILE_TEXT);
    }
}
