<?php

try {
    $HOME = strlen($_SERVER['DOCUMENT_ROOT']) != 0 ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['PHP_CRON_HOME'];

    echo "HOME = $HOME \n";

    include_once "$HOME/_helpers/api-to-json/SaveJson_v3_product_info_list.php";
    include_once "$HOME/_helpers/api-to-json/SaveJson_v3_product_list.php";
    include_once "$HOME/_helpers/api-to-json/SaveJson_v4_product_info_attributes.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v3ProductList_Products.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v4ProductInfoAttributes_Products.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v4ProductInfoAttributes_ModelProducts.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v3ProductInfoList_Products.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v3ProductInfoList_ProductSources.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v3ProductInfoList_ProductCommissions.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v3ProductInfoList_ModelProducts.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v3ProductInfoList_ProductVisabilityDetails.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v3ProductInfoList_ProductStatuses.php";
    include_once "$HOME/_helpers/normal-json-to-database/SaveJsonToSqlite.php";
    include_once "$HOME/_helpers/normal-json-to-database/SaveNormalJsonToSqlite.php";

    for ($i = 0; $i < $argc; $i++) {
        switch($argv[$i]) {
            case '--download-all':
                SaveJson_v3_product_list::main();
                SaveJson_v3_product_info_list::main();
                SaveJson_v4_product_info_attributes::main();
                break;

            case '--normolize-all':
                SaveJson_v3ProductList_Products::main();
                SaveJson_v4ProductInfoAttributes_Products::main();
                SaveJson_v4ProductInfoAttributes_ModelProducts::main();
                SaveJson_v3ProductInfoList_Products::main();
                SaveJson_v3ProductInfoList_ProductSources::main();
                SaveJson_v3ProductInfoList_ProductCommissions::main();
                SaveJson_v3ProductInfoList_ModelProducts::main();
                SaveJson_v3ProductInfoList_ProductVisabilityDetails::main();
                SaveJson_v3ProductInfoList_ProductStatuses::main();
                break;

            case '--save-to-sqlite':
                SaveJsonToSqlite::main();
                SaveNormalJsonToSqlite::main();
                break;

            case '--download-v3-product-list':
                SaveJson_v3_product_list::main();
                break;

            case '--download-v3-product-info-list':
                SaveJson_v3_product_info_list::main();
                break;

            case '--download-v4-product-info-attributes':
                SaveJson_v4_product_info_attributes::main();
                break;
        }
    }
}
catch(Throwable $exception) {
    echo $exception;
}
