# House Search App (Backend)

Это серверная часть приложения House Search, разработанная с использованием Laravel.

## Описание

Это веб-приложение предоставляет API для поиска домов на основе различных параметров, таких как количество спален, ванных комнат, этажность, гаражи и цена. Данные о домах хранятся в базе данных.

## Используемые технологии

- **Laravel:** PHP-фреймворк для разработки веб-приложений.
- **MySQL:** СУБД для хранения данных о домах.

## Запуск бэкенда

1. Клонируйте репозиторий на свой локальный компьютер. `git clone https://github.com/Vanya9422/house-search-test.git`
2. Установите зависимости с помощью команды `composer install`.
3. Создайте базу данных MySQL и настройте соединение в файле `cp .env.example .env`.
4. Генерируйте ключ проекта `php artisan key:generate`.
5. Выполните миграции с помощью команды `php artisan migrate --seed`.
6. Запустите сервер с помощью команды `php artisan serve`.
7. Фронт находится в папке `client`

### API будет доступно по адресу `http://localhost:8000`

## Разработчик

- **Vanya Grigoryan**  [Telegram](https://t.me/grigoryan366)
