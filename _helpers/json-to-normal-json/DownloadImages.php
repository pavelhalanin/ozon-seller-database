<?php

$HOME = strlen($_SERVER['DOCUMENT_ROOT']) != 0 ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['PHP_CRON_HOME'];


class DownloadImages {
    static function getAllImages() {
        try {
            global $HOME;

            $pdo = new PDO("sqlite:$HOME/database.sqlite");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT
                        DISTINCT
                        image
                    FROM (
                        SELECT image360 AS image FROM OZN_v3ProductInfoList_360Images
                        UNION
                        SELECT color_image AS image FROM OZN_v3ProductInfoList_ColorImages
                        UNION
                        SELECT image AS image FROM OZN_v3ProductInfoList_Images
                        UNION
                        SELECT primary_image AS image FROM OZN_v3ProductInfoList_PrimaryImages
                        UNION
                        SELECT image AS image FROM OZN_v4ProductInfoAttributes_Images
                    )
                    ";

            $smth = $pdo->prepare($sql);
            $smth->execute();
            $result = $smth->fetchAll();

            $result_array = [];
            for ($i = 0; $i < count($result); $i++) {
                $filename = $result[$i]['image'];
                $filename = str_replace("/", "_", $filename);
                $filename = str_replace(":", "_", $filename);

                $result_array [] = [
                    'custom_auto_increment' => $i + 1,
                    'image_path' => $filename,
                    'image_href' => $result[$i]['image'],
                ];
            }

            $folder = "$HOME/database";
            if (!is_dir($folder)) {
                mkdir($folder, 0777, true); 
            }

            $JSON = $result_array;

            $FILE_PATH = "$folder/OZN_Images.json";
            $FILE_TEXT = json_encode($JSON, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            file_put_contents($FILE_PATH, $FILE_TEXT);

            return $result_array;
        }
        catch(Throwable $exception) {
            return [];
        }
    }
}