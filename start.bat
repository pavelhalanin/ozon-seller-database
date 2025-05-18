@echo off

d:
cd D:\_git\ozon-seller-database

echo %DATE% %TIME%

echo php main.php --download-all --normolize-all --save-to-sqlite
php main.php --download-all --normolize-all --save-to-sqlite

pause
