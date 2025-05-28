## Что делает этот код

Этот код скачивает данные продавца по API в папку `data`.
Затем нормальзует данные из папки `data` в папку `database`.
После чего добавляет данные из папки `database` в базу данных `database.sqlite`.

## Как запустить

Добавить переменную окружения `PHP_CRON_HOME`.
Пример значения: `D:\_git\ozon-seller-database`.

Команда: `php main.php --download-all --normolize-all --save-to-sqlite`

## Как выполнять скрипт каждый час на Windows 10

1. Жмем `Win` + `R`
1. Откроется окно `Выполнить`
    1. Пишем `taskschd.msc`
    1. Жмем `Enter`
1. Откроется окно `Планировщик задач`
    1. В окне `Планировщик задач` выбрать `Библиотека планировщика задач`
    1. Жмем `Создать задачу ...`
    1. Откроется окно `Создание задачи`
        1. Заполняем вкладку `Общие`
            1. Имя `Ozon Seller API to sqlite`
            1. Описание `Парсинг OZON по его API себе в базу данных sqlite`
        1. Заполняем вкладку `Триггеры`
            1. Жмем `Создать ...`
            1. Откроется окно `Создание триггера`
                1. Настройки: `Однократно`
                1. Начать `18.05.2025` `23:25:00`
                1. Ставлю галку `Повторять задачу каждые` `1 ч.`
                1. Жмем `OK`
        1. Заполняем вкладку `Действия`
            1. Жмем `Создать ...`
            1. Откроется окно `Создание действия`
                1. Действие: `Запуск программы`
                1. Программа или сценарий: `D:\_git\ozon-seller-database\start.bat`
                1. Жмем `ОК`
        1. Жмем `ОК`

## Скачать только id продуктов

Команда: `php main.php --download-v3-product-list`

Результат: `/data/v3_product_list.json`

API:
- HTTP METHOD
- HTTP HOST: `https://api-seller.ozon.ru`
- HTTP URI: `/v3/product/list`
- HTTP HEADERS:
    - `Content-Type: application/json`
    - `Client-Id` указать в env.php `ozon-client-id`
    - `Api-Key` указать в env.php `ozon-api-key`
- HTTP BODY: 
    - `{"limit": 1000, "filter": {"visibility": "ALL"}}` - для скачивания 1000 карточек, кроме архивных
    - `{"limit": 1000, "filter": {"visibility": "ARCHIVED"}}` - для скачивания 1000 архивных карточек

<details>
<summary>Пример элемента массива</summary>

```json
{
    "product_id": 0,
    "offer_id": "",
    "has_fbo_stocks": false,
    "has_fbs_stocks": false,
    "archived": false,
    "is_discounted": false,
    "quants": []
}
```

</details>

## Скачать данные продуктов по их product_id

Команда: `php main.php --download-v3-product-info-list`

Результат: `/data/v3_product_info_list.json`

API:
- HTTP METHOD
- HTTP HOST: `https://api-seller.ozon.ru`
- HTTP URI: `/v3/product/info/list`
- HTTP HEADERS:
    - `Content-Type: application/json`
    - `Client-Id` указать в env.php `ozon-client-id`
    - `Api-Key` указать в env.php `ozon-api-key`
- HTTP BODY: 
    - `{"product_id": []}` - в массиве укажите id продуктов

<details>
<summary>Пример элемента массива</summary>

```json
{
    "id": 0,
    "name": "",
    "offer_id": "",
    "is_archived": false,
    "is_autoarchived": false,
    "barcodes": [
        ""
    ],
    "description_category_id": 0,
    "type_id": 0,
    "created_at": "YYYY-MM-DDTHH:II:SS.MMMMMMZ",
    "images": [
        ""
    ],
    "currency_code": "RUB",
    "marketing_price": "0.00",
    "min_price": "0.00",
    "old_price": "0.00",
    "price": "0.00",
    "sources": [
        {
            "sku": 0,
            "source": "sds",
            "created_at": "YYYY-MM-DDTHH:II:SS.MMMMMMZ",
            "shipment_type": "SHIPMENT_TYPE_GENERAL",
            "quant_code": ""
        }
    ],
    "model_info": {
        "model_id": 0,
        "count": 0
    },
    "commissions": [
        {
            "delivery_amount": 0.0,
            "percent": 0,
            "return_amount": 0,
            "sale_schema": "FBO",
            "value": 0.0
        },
        {
            "delivery_amount": 0.0,
            "percent": 0,
            "return_amount": 0,
            "sale_schema": "FBS",
            "value": 0
        },
        {
            "percent": 0,
            "sale_schema": "RFBS",
            "value": 0
        },
        {
            "percent": 0,
            "sale_schema": "FBP",
            "value": 0
        }
    ],
    "is_prepayment_allowed": false,
    "volume_weight": 0.2,
    "has_discounted_fbo_item": false,
    "is_discounted": false,
    "discounted_fbo_stocks": 0,
    "stocks": {
        "has_stock": false,
        "stocks": [
            {
                "present": 0,
                "reserved": 0,
                "sku": 0,
                "source": "fbs"
            }
        ]
    },
    "errors": [],
    "updated_at": "YYYY-MM-DDTHH:II:SS.MMMMMMZ",
    "vat": "0.0",
    "visibility_details": {
        "has_price": false,
        "has_stock": false
    },
    "price_indexes": {
        "color_index": "COLOR_INDEX_WITHOUT_INDEX",
        "external_index_data": {
            "minimal_price": "",
            "minimal_price_currency": "RUB",
            "price_index_value": 0
        },
        "ozon_index_data": {
            "minimal_price": "",
            "minimal_price_currency": "RUB",
            "price_index_value": 0
        },
        "self_marketplaces_index_data": {
            "minimal_price": "",
            "minimal_price_currency": "RUB",
            "price_index_value": 0
        }
    },
    "images360": [],
    "is_kgt": false,
    "color_image": [],
    "primary_image": [
        ""
    ],
    "statuses": {
        "status": "",
        "status_failed": "",
        "moderate_status": "",
        "validation_status": "",
        "status_name": "",
        "status_description": "",
        "is_created": false,
        "status_tooltip": "",
        "status_updated_at": "YYYY-MM-DDTHH:II:SS.MMMMMMZ"
    },
    "is_super": false,
    "is_seasonal": false
}
```

</details>

## Скачать атрибуты продуктов по их product_id

Команда: `php main.php --download-v4-product-info-attributes`

Результат: `/data/v4_product_info_attributes.json`

API:
- HTTP METHOD
- HTTP HOST: `https://api-seller.ozon.ru`
- HTTP URI: `/v4/product/info/attributes`
- HTTP HEADERS:
    - `Content-Type: application/json`
    - `Client-Id` указать в env.php `ozon-client-id`
    - `Api-Key` указать в env.php `ozon-api-key`
- HTTP BODY: 
    - `{"filter": {"product_id": []}, "limit": 1000}` - в массиве укажите id продуктов

<details>
<summary>Пример элемента массива</summary>

```json
{
    "id": 0,
    "barcode": "",
    "name": "",
    "offer_id": "",
    "height": 0,
    "depth": 0,
    "width": 0,
    "dimension_unit": "mm",
    "weight": 0,
    "weight_unit": "g",
    "description_category_id": 0,
    "type_id": 0,
    "primary_image": "",
    "model_info": {
        "model_id": 0,
        "count": 0
    },
    "images": [
        ""
    ],
    "pdf_list": [],
    "attributes": [
        {
            "id": 0,
            "complex_id": 0,
            "values": [
                {
                    "dictionary_value_id": 0,
                    "value": ""
                }
            ]
        }
    ],
    "complex_attributes": [],
    "color_image": "",
    "sku": 0,
    "barcodes": [
        ""
    ]
}
```

</details>

## Скачать транзакции

Команда: `php main.php --download-v3-finance-transaction-list`

Результат: `/data/v3_finance_transaction_list.json`

API:
- HTTP METHOD
- HTTP HOST: `https://api-seller.ozon.ru`
- HTTP URI: `/v3/finance/transaction/list`
- HTTP HEADERS:
    - `Content-Type: application/json`
    - `Client-Id` указать в env.php `ozon-client-id`
    - `Api-Key` указать в env.php `ozon-api-key`
- HTTP BODY: 
    - `{"filter": {"date": {"from" => "2025-05-01", "to" => "2025-05-31"}, "operation_type": [], "posting_number": "", "transaction_type": "all"}, "page" => 1, "page_size" => 1000}` - укажите from и to

<details>
<summary>Пример элемента массива</summary>

```json
{
    "operation_id": 0,
    "operation_type": "",
    "operation_date": "YYYY-MM-DD hh:ii:ss",
    "operation_type_name": "",
    "delivery_charge": 0,
    "return_delivery_charge": 0,
    "accruals_for_sale": 0,
    "sale_commission": 0.0,
    "amount": 0,
    "type": "",
    "posting": {
        "delivery_schema": "",
        "order_date": "YYYY-MM-DD hh:ii:ss",
        "posting_number": "",
        "warehouse_id": 0
    },
    "items": [
        {
            "name": "",
            "sku": 0
        }
    ],
    "services": [
        {
            "name": "",
            "price": 0
        }
    ]
}
```

</details>

## Приведение /v3/product/list/ в номарльную форму базы данных

База данных: `database.sqlite`
- Таблица: `OZN_v3ProductList_Products`
- Поля:
    - `product_id` - id продукта
    - `offer_id` - артикул продавца
    - `has_fbo_stocks` - имеются остатки на FBO ('0' - false, '1' - true)
    - `has_fbs_stocks` - имеются остатки на FBS ('0' - false, '1' - true)
    - `archived` - карточка в архиве ('0' - false, '1' - true)
    - `is_discounted` - ('0' - false, '1' - true)

## Приведение /v4/product/info/attributes/ в номарльную форму базы данных

База данных: `database.sqlite`
- Таблица: `OZN_v4ProductInfoAttributes_Products`
- Поля:
    - `id` - id продукта
    - `barcode` - штрихкод
    - `name` - наименование
    - `offer_id` - артикул продавца
    - `height` - высота
    - `depth` - глубина
    - `width` - ширина
    - `dimension_unit` - единица длины ('mm')
    - `weight` - вес
    - `weight_unit` - единица веса ('g')
    - `description_category_id` - id категории
    - `type_id` - id типа категории
    - `primary_image` - ссылка на картинку
    - `color_image` - ссылка на картинку цвета
    - `sku` - артикул OZON
    - `images` - ссылку на картинку через `;`
    - `barcodes` - штрихкоды через `;`

База данных: `database.sqlite`
- Таблица: `OZN_v4ProductInfoAttributes_ModelProducts`
- Поля:
    - `product_id` - id продукта
    - `model_id` - id модели
    - `count` - количество

База данных: `database.sqlite`
- Таблица: `OZN_v4ProductInfoAttributes_Attributes`
- Поля:
    - `custom_auto_increment` - авто инкремент
    - `custom_id` - мой произвольный id (`<product_id>.attributes[<j>]`)
    - `product_id` - id продукта
    - `id` - id атрибута
    - `complex_id` - id сложного атрибута

База данных: `database.sqlite`
- Таблица: `OZN_v4ProductInfoAttributes_AttributesValues`
- Поля:
    - `custom_auto_increment` - авто инкремент
    - `custom_id` - мой произвольный id (`<product_id>.attributes[<j>].values[<k>]`)
    - `product_id` - id продукта
    - `attribute_id` - id атрибута
    - `atribute_complex_id` - id сложного атрибута
    - `dictionary_value_id` - id значения словаря
    - `value` - значение

## Приведение /v3/product/info/list/ в номарльную форму базы данных

База данных: `database.sqlite`
- Таблица: `OZN_v3ProductList_Products`
- Поля:
    - `id` - id продукта
    - `name` - наименование
    - `offer_id` - артикул продавца
    - `description_category_id` - id категории
    - `type_id` - id типа категории
    - `created_at` - дата и время создания карточки
    - `currency_code` - валюта ('RUB')
    - `marketing_price` - цена для покупки по акции
    - `min_price` - минимальная цена
    - `old_price` - зачеркнутая цена
    - `price` - цена для покупки
    - `volume_weight` - объем в листрах
    - `discounted_fbo_stocks`
    - `updated_at` - дата и время обновления карточки
    - `vat` - НДС
    - `is_archived` - карточка в архиве (0 - false, 1 - true)
    - `is_autoarchived` - карточка добавлена в архив автоматически (0 - false, 1 - true)
    - `is_prepayment_allowed` - (0 - false, 1 - true)
    - `has_discounted_fbo_item` - (0 - false, 1 - true)
    - `is_discounted` - (0 - false, 1 - true)
    - `is_kgt` - это крупно габоритный товар (0 - false, 1 - true)
    - `is_super` - (0 - false, 1 - true)
    - `is_seasonal` - (0 - false, 1 - true)
    - `barcodes` - штрихкоды через `;`
    - `images` - ссылки на картинки через `;`
    - `images360` - ссылки на картинки через `;`
    - `color_image` - ссылка на картинку цвета
    - `primary_image` - ссылка на первую картинку

База данных: `database.sqlite`
- Таблица: `OZN_v3ProductInfoList_ModelProducts`
- Поля:
    - `product_id` - id продукта
    - `model_id` - id модели
    - `count` - количество

База данных: `database.sqlite`
- Таблица: `OZN_v3ProductInfoList_ProductCommissions`
- Поля:
    - `product_id` - id продукта
    - `delivery_amount`
    - `percent` - процент комиссии
    - `return_amount`
    - `sale_schema` - схема (FBO, FBS, RFBS, FBP)
    - `value`

База данных: `database.sqlite`
- Таблица: `OZN_v3ProductInfoList_ProductSources`
- Поля:
    - `product_id` - id продукта
    - `sku` - артикул OZON
    - `source`
    - `created_at`
    - `shipment_type`
    - `quant_code`

База данных: `database.sqlite`
- Таблица: `OZN_v3ProductInfoList_ProductStatuses`
- Поля:
    - `product_id` - id продукта
    - `status` - статус (price_sent)
    - `status_failed`
    - `moderate_status` - статус (approved)
    - `validation_status` - статус (success)
    - `status_name` - статус (Продается)
    - `status_description`
    - `status_tooltip`
    - `status_updated_at` - дата и время обновления статуса
    - `is_created` - создан (0 - false, 1 - true)

База данных: `database.sqlite`
- Таблица: `OZN_v3ProductInfoList_ProductVisabilityDetails`
- Поля:
    - `product_id` - id продукта
    - `has_price` - установлена цена (0 - false, 1 - true)
    - `has_stock` - есть остатки (0 - false, 1 - true)

## Приведение /v3/finance/transaction/list/ в номарльную форму базы данных

База данных: `database.sqlite`
- Таблица: `OZN_v3FinanceTransactionsList_Transactions`
- Поля:
    - `custom_auto_increment` - авто инкремент
    - `operation_id` - id транзакции
    - `operation_type` - код транзакции
        - `MarketplaceRedistributionOfAcquiringOperation`
        - `OperationAgentDeliveredToCustomer`
        - `ClientReturnAgentOperation`
        - `OperationAgentStornoDeliveredToCustomer`
        - `OperationReturnGoodsFBSofRMS`
        - `MarketplaceSellerCompensationOperation`
    - `operation_date` - дата транзакции
    - `operation_type_name` - наименование транзации:
        - `Оплата эквайринга`
        - `Доставка покупателю`
        - `Получение возврата, отмены, невыкупа от покупателя`
        - `Доставка покупателю — отмена начисления`
        - `Доставка и обработка возврата, отмены, невыкупа`
        - `Прочие компенсации`
    - `delivery_charge`
    - `return_delivery_charge`
    - `accruals_for_sale`
    - `sale_commission`
    - `amount` - итого (RUB)
    - `type` - тип
        - `other`
        - `orders`
        - `returns`
        - `compensation`

База данных: `database.sqlite`
- Таблица: `OZN_v3FinanceTransactionsList_TransactionPostings`
- Поля:
    - `custom_auto_increment` - авто инкремент
    - `operation_id` - id транзакции
    - `delivery_schema`
        - ` `
        - `FBS`
        - `FBO`
    - `order_date` - дата заказа
    - `posting_number` - номер заказа
    - `warehouse_id` - id склада

База данных: `database.sqlite`
- Таблица: `OZN_v3FinanceTransactionsList_TransactionItems`
- Поля:
    - `custom_auto_increment` - авто инкремент
    - `custom_id` - мой произвольный id (`<operation_id>.services[<i>]`)
    - `operation_id` - id транзакции
    - `name` - наименование продукта
    - `sku` - артикул OZON

База данных: `database.sqlite`
- Таблица: `OZN_v3FinanceTransactionsList_TransactionServices`
- Поля:
    - `custom_auto_increment` - авто инкремент
    - `custom_id` - мой произвольный id (`<operation_id>.services[<i>]`)
    - `operation_id` - id транзакции
    - `name` - наименование продукта
    - `price` - цена
