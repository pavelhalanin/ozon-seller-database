<?php

$HOME = strlen($_SERVER['DOCUMENT_ROOT']) != 0 ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['PHP_CRON_HOME'];

include_once "$HOME/env.php";

class SaveJson_v4ProductInfoAttributes_Attributes {
    static function main() {
        global $HOME;

        $text = file_get_contents("$HOME/data/v4_product_info_attributes.json");
        $json = json_decode($text, true);
        $array = $json['data'];

        $i = 0;
        foreach ($array as $element) {
            $product_id = $element['id'];
            $j = 0;
            foreach($element['attributes'] as $attribute) {
                $data = [];

                $i += 1;
                $j += 1;
                $data['custom_auto_increment'] = $i;
                $data['custom_id'] = "$product_id.attributes[$j]";
                $data['product_id'] = $product_id;

                $str_fields = ['id', 'complex_id'];

                $boolean_fields = [];

                $str_array_fields = [];

                $i_dont_now_fields = [];

                foreach ($str_fields as $current_field) {
                    $data[$current_field] = "" . $attribute[$current_field];
                }

                foreach ($boolean_fields as $current_field) {
                    $data[$current_field] = $attribute[$current_field] ? '1' : '0';
                }

                foreach ($str_array_fields as $current_field) {
                    $data[$current_field] = implode(';', $attribute[$current_field]);
                }

                $result_array []= $data;
            }
        }

        $folder = "$HOME/database";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true); 
        }

        $JSON = $result_array;
        $FILE_PATH = "$HOME/database/OZN_v4ProductInfoAttributes_Attributes.json";
        $FILE_TEXT = json_encode($JSON, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        file_put_contents($FILE_PATH, $FILE_TEXT);
    }
}
