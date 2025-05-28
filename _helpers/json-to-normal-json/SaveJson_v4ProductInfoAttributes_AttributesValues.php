<?php

$HOME = strlen($_SERVER['DOCUMENT_ROOT']) != 0 ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['PHP_CRON_HOME'];

include_once "$HOME/env.php";

class SaveJson_v4ProductInfoAttributes_AttributesValues {
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

                $j += 1;
                $k = 0;
                foreach($attribute['values'] AS $value) {
                    $i += 1;
                    $data['custom_auto_increment'] = $i;
                    $k += 1;
                    $data['custom_id'] = "$product_id.attributes[$j].values[$k]";
                    $data['product_id'] = $product_id;
                    $data['attribute_id'] = $attribute['id'];
                    $data['atribute_complex_id'] = $attribute['complex_id'];
                    $data['dictionary_value_id'] = $value['dictionary_value_id'];
                    $data['value'] = $value['value'];
                    $result_array []= $data;
                }
            }
        }

        $folder = "$HOME/database";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true); 
        }

        $JSON = $result_array;
        $FILE_PATH = "$HOME/database/OZN_v4ProductInfoAttributes_AttributesValues.json";
        $FILE_TEXT = json_encode($JSON, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        file_put_contents($FILE_PATH, $FILE_TEXT);
    }
}
