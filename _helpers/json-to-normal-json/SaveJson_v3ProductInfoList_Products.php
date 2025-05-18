<?php

$HOME = strlen($_SERVER['DOCUMENT_ROOT']) != 0 ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['PHP_CRON_HOME'];

include_once "$HOME/env.php";

class SaveJson_v3ProductInfoList_Products {
    static function main() {
        global $HOME;
        $INPUT_FILE = "$HOME/data/v3_product_info_list.json";
        $OUTPUT_FILE = "$HOME/database/OZN_v3ProductInfoList_Products.json";

        $text = file_get_contents($INPUT_FILE);
        $json = json_decode($text, true);
        $array = $json['data'];

        $result = [];
        for ($i = 0; $i < count($array); $i++) {
            $element = $array[$i];

            $data = [];

            $str_fields = ['id', 'name', 'offer_id', 'description_category_id', 'type_id', 'created_at', 'currency_code', 'marketing_price', 'min_price', 'old_price', 'price', 'volume_weight', 'discounted_fbo_stocks', 'updated_at', 'vat'];

            $boolean_fields = ['is_archived', 'is_autoarchived', 'is_prepayment_allowed', 'has_discounted_fbo_item', 'is_discounted', 'is_kgt', 'is_super', 'is_seasonal'];

            $str_array_fields = ['barcodes', 'images', 'images360', 'color_image', 'primary_image'];

            $i_dont_now_fields = ['sources', 'model_info', 'commissions', 'stocks', 'visibility_details', 'price_indexes', 'statuses'];

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

        $folder = "$HOME/database";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true); 
        }

        $JSON = $result;
        $FILE_TEXT = json_encode($JSON, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        file_put_contents($OUTPUT_FILE, $FILE_TEXT);
    }
}
