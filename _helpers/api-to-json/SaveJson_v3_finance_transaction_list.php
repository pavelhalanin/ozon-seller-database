<?php

$HOME = strlen($_SERVER['DOCUMENT_ROOT']) != 0 ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['PHP_CRON_HOME'];

include_once "$HOME/env.php";

class SaveJson_v3_finance_transaction_list {
    static function main() {
        global $HOME;

        $data = SaveJson_v3_finance_transaction_list::getAll();

        $folder = "$HOME/data";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true); 
        }

        $JSON = [
            'updated_at' => date('Y-m-d_H-i-s'),
            'data' => $data,
        ];

        $FILE_PATH = "$HOME/data/v3_finance_transaction_list.json";
        $FILE_TEXT = json_encode($JSON, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        file_put_contents($FILE_PATH, $FILE_TEXT);
    }

    static function getAll() {
        $startDate = '2024-01-10';
        $endDate = (new DateTime('tomorrow'))->format('Y-m-d');

        $result = SaveJson_v3_finance_transaction_list::getData($startDate, $endDate);

        $resultArray = [];
        for ($i = 0; $i < count($result); $i++) {
            $data = SaveJson_v3_finance_transaction_list::fetchJson__getTransactionsOnPeriod($result[$i]['start'], $result[$i]['end']);
            $arr = $data['result']['operations'];
            for ($j = 0; $j < count($arr); $j++) {
                $resultArray []= $arr[$j];
            }
        }

        return $resultArray;
    }

    static function getData($startDate, $endDate) {
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);
        $end->modify('last day of this month'); // Получаем последний день месяца для конечной даты
        $data = [];

        while ($start <= $end) {
            $startOfMonth = $start->format('Y-m-01\T00:00:00.000\Z');
            $endOfMonth = $start->format('Y-m-t\T23:59:59.999\Z');

            $data[] = [
                'start' => $startOfMonth,
                'end' => $endOfMonth
            ];

            // Переход к следующему месяцу
            $start->modify('first day of next month');
        }

        return $data;
    }

    static function fetchJson__getTransactionsOnPeriod($dateFrom, $dateTo) {        
        return SaveJson_v3_finance_transaction_list::fetchJson([
            "filter" => [
                "date" => [
                    "from" => $dateFrom,
                    "to" => $dateTo,
                ],
                "operation_type" => [],
                "posting_number" => "",
                "transaction_type" => "all",
            ],
            "page" => 1,
            "page_size" => 1000,
        ]);
    }

    static function fetchJson($data) {
        global $env;

        $URI = "/v3/finance/transaction/list";
        $FETCH_URL = "https://api-seller.ozon.ru$URI";

        $json_string = json_encode($data);
        $http_data = $json_string;

        $ozonClientId = $env['ozon-client-id'];
        $ozonApiKey = $env['ozon-api-key'];

        $http_headers = [
            "Content-Type: application/json",
            "Client-Id: $ozonClientId",
            "Api-Key: $ozonApiKey",
        ];

        $http_cookie = implode("; ", [
            "Client-Id=$ozonClientId",
            "Api-Key=$ozonApiKey",
        ]);

        if ($env['log']) {
            echo "\nPOST $FETCH_URL\n$http_data\n";
        }

        $ch = curl_init($FETCH_URL);                            // Инициализируем cURL сессии
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);                   // Устанавливаем метод POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $http_data);       // Тело запроса
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_headers);    // Устанавливаем заголовки
        curl_setopt($ch, CURLOPT_COOKIE, $http_cookie);         // Передаем куки
        $response = curl_exec($ch);                             // Выполняем запрос и получаем ответ

        if (curl_errno($ch)) {                                  // Проверяем на наличие ошибок
            $err = curl_error($ch);                             // Получаем сообщение об ошибке
            curl_close($ch);                                    // Закрываем cURL сессию
            throw new Error("Fetch error: $err");
        }

        curl_close($ch);                                        // Закрываем cURL сессию
        $json_string = $response;
        $php_object = json_decode($json_string, true);
        return $php_object;
    }
}
