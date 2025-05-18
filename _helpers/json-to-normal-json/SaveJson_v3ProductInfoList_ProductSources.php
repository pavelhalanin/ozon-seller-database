<?php

$HOME = strlen($_SERVER['DOCUMENT_ROOT']) != 0 ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['PHP_CRON_HOME'];

include_once "$HOME/env.php";

class SaveJson_v3ProductInfoList_ProductSources {
    static function main() {
        global $HOME;
        $INPUT_FILE = "$HOME/data/v3_product_info_list.json";
        $OUTPUT_FILE = "$HOME/database/OZN_v3ProductInfoList_ProductSources.json";

        $text = file_get_contents($INPUT_FILE);
        $json = json_decode($text, true);
        $array = $json['data'];

        $result = [];
        for ($i = 0; $i < count($array); $i++) {
            $element_1 = $array[$i];

            $product_id = $element_1['id'];
            $list = $element_1['sources'];
            for ($j = 0; $j < count($list); $j++) {
                $element = $list[$j];

                $data = [];
                $data['product_id'] = $product_id;

                $str_fields = ['sku', 'source', 'created_at', 'shipment_type', 'quant_code'];

                $boolean_fields = [];

                $str_array_fields = [];

                $i_dont_now_fields = [];

                foreach ($str_fields as $current_field) {
                    $data[$current_field] = "";
                    if (array_key_exists($current_field, $element)) {
                        $data[$current_field] = "" . $element[$current_field];
                    }
                }

                foreach ($boolean_fields as $current_field) {
                    $data[$current_field] = $element[$current_field] ? '1' : '0';
                }

                foreach ($str_array_fields as $current_field) {
                    $data[$current_field] = implode(';', $element[$current_field]);
                }

                $result []= $data;
            }
        }

        $folder = "$HOME/database";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true); 
        }

        $JSON = $result;
        $FILE_TEXT = json_encode($JSON, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        file_put_contents($OUTPUT_FILE, $FILE_TEXT);
    }
}
