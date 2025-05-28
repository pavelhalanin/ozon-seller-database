<?php

$HOME = strlen($_SERVER['DOCUMENT_ROOT']) != 0 ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['PHP_CRON_HOME'];

include_once "$HOME/env.php";

class SaveJson_v3FinanceTransactionsList_Transactions {
    static function main() {
        global $HOME;

        $text = file_get_contents("$HOME/data/v3_finance_transaction_list.json");
        $json = json_decode($text, true);
        $array = $json['data'];

        $i = 0;
        foreach ($array as $element) {
            $data = [];

            $i += 1;
            $data['custom_auto_increment'] = $i;

            $str_fields = ['operation_id', 'operation_type', 'operation_date', 'operation_type_name', 'delivery_charge', 'return_delivery_charge', 'accruals_for_sale', 'sale_commission', 'amount', 'type'];

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

            $result_array []= $data;
        }

        $folder = "$HOME/database";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true); 
        }

        $JSON = $result_array;
        $FILE_PATH = "$HOME/database/OZN_v3FinanceTransactionsList_Transactions.json";
        $FILE_TEXT = json_encode($JSON, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        file_put_contents($FILE_PATH, $FILE_TEXT);
    }
}
