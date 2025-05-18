<?php

$HOME = strlen($_SERVER['DOCUMENT_ROOT']) != 0 ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['PHP_CRON_HOME'];

class SaveNormalJsonToSqlite {
    static function main() {
        global $HOME;

        $folder = "$HOME/database";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true); 
        }

        $files = scandir($folder);
        $json_file_name_array = [];
        foreach ($files as $file) {
            if ($file != "." && $file != "..") { // Исключаем служебные элементы
                $json_file_name_array []= $file;
            }
        }

        echo "$folder: \n";
        print_r($json_file_name_array);
        echo "\n";

        $pdo = new PDO("sqlite:$HOME/database.sqlite");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        foreach ($json_file_name_array as $json_file_name) {
            $DB_NAME = str_replace(".json", "", $json_file_name);

            $file = "$HOME/database/$json_file_name";

            echo "open file $file \n";

            $json = file_get_contents($file);
            $array = json_decode($json, true);

            if (count($array) == 0) {
                echo "\n";
                continue;
            }

            $fields = array_keys($array[0]);

            echo "DROP TABLE IF EXISTS $DB_NAME \n";

            $sql = "DROP TABLE IF EXISTS $DB_NAME";
            $smth = $pdo->prepare($sql);
            $smth->execute();

            echo "CREATE TABLE $DB_NAME \n";

            $sql = "CREATE TABLE $DB_NAME";
            $sql .= "(";
            $sql .= implode(' TEXT,', $fields);
            $sql .= " TEXT)";

            $smth = $pdo->prepare($sql);
            $smth->execute();

            echo "INSERT INTO $DB_NAME \n";

            foreach($array AS $row) {
                $sql = "INSERT INTO $DB_NAME ";
                $sql .= "('";
                $sql .= implode("', '", $fields);
                $sql .= "') VALUES ('";
                $sql .= implode(
                    "','",
                    array_map(
                        function ($field) use ($row) {
                            return $row[$field];
                        },
                        $fields
                    )
                );
                $sql .= "')";

                $smth = $pdo->prepare($sql);
                $smth->execute();
            }

            echo "\n";
        }
    }
}
