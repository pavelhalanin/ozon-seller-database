<?php

try {
    $HOME = strlen($_SERVER['DOCUMENT_ROOT']) != 0 ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['PHP_CRON_HOME'];

    echo "HOME = $HOME \n";

    include_once "$HOME/_helpers/api-to-json/SaveJson_v3_product_info_list.php";
    include_once "$HOME/_helpers/api-to-json/SaveJson_v3_product_list.php";
    include_once "$HOME/_helpers/api-to-json/SaveJson_v4_product_info_attributes.php";
    include_once "$HOME/_helpers/api-to-json/SaveJson_v3_finance_transaction_list.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v3ProductList_Products.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v4ProductInfoAttributes_Products.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v4ProductInfoAttributes_ModelProducts.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v4ProductInfoAttributes_Attributes.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v4ProductInfoAttributes_AttributesValues.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v3ProductInfoList_Products.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v3ProductInfoList_ProductSources.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v3ProductInfoList_ProductCommissions.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v3ProductInfoList_ModelProducts.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v3ProductInfoList_ProductVisabilityDetails.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v3ProductInfoList_ProductStatuses.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v3FinanceTransactionsList_Transactions.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v3FinanceTransactionsList_TransactionPostings.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v3FinanceTransactionsList_TransactionItems.php";
    include_once "$HOME/_helpers/json-to-normal-json/SaveJson_v3FinanceTransactionsList_TransactionServices.php";
    include_once "$HOME/_helpers/normal-json-to-database/SaveJsonToSqlite.php";
    include_once "$HOME/_helpers/normal-json-to-database/SaveNormalJsonToSqlite.php";

    for ($i = 0; $i < $argc; $i++) {
        switch($argv[$i]) {
            case '--download-all':
                SaveJson_v3_product_list::main();
                SaveJson_v3_product_info_list::main();
                SaveJson_v4_product_info_attributes::main();
                SaveJson_v3_finance_transaction_list::main();
                break;

            case '--normolize-all':
                SaveJson_v3ProductList_Products::main();
                SaveJson_v4ProductInfoAttributes_Products::main();
                SaveJson_v4ProductInfoAttributes_ModelProducts::main();
                SaveJson_v4ProductInfoAttributes_Attributes::main();
                SaveJson_v4ProductInfoAttributes_AttributesValues::main();
                SaveJson_v3ProductInfoList_Products::main();
                SaveJson_v3ProductInfoList_ProductSources::main();
                SaveJson_v3ProductInfoList_ProductCommissions::main();
                SaveJson_v3ProductInfoList_ModelProducts::main();
                SaveJson_v3ProductInfoList_ProductVisabilityDetails::main();
                SaveJson_v3ProductInfoList_ProductStatuses::main();
                SaveJson_v3FinanceTransactionsList_Transactions::main();
                SaveJson_v3FinanceTransactionsList_TransactionPostings::main();
                SaveJson_v3FinanceTransactionsList_TransactionItems::main();
                SaveJson_v3FinanceTransactionsList_TransactionServices::main();
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
