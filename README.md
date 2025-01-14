## Введение

Данная документация предназначена для разработчиков, которые хотят запустить тестовое веб-приложение, разработанное на Laravel. Проект был создан в рамках тестового задания от компании Атвинта и демонстрирует основные функции, такие как аутентификация, работа с API, взаимодействие с базой данных, работа с Docker, работа с Service layer,DTO, PhpStan и Provider layer, и работа с админ панелью Voyager.

## Описание

Проект представляет собой веб-приложение, в котором Laravel используется для обработки запросов, управления данными и отображения страницы. Приложение включает в себя функциональность для регистрации пользователей, входа в систему и выполнения CRUD операций с данными.

## Требования

Перед началом работы убедитесь, что у вас установлены следующие компоненты:
- PHP (версия 8.0 или выше);
- Composer (менеджер зависимостей для PHP);
- Установленный Git;
- Установленная база данных MySQL;
- Node.js и npm (для работы отображения стилей Tailwind);

## Шаги по запуску проекта

### 1. Клонирование репозитория

Сначала клонируйте репозиторий проекта с GitHub:
```
git clone https://github.com/oljuninnv/PasteBin.git
cd PasteBin
cd paste_bin
```

### 2. Установка зависимостей
После клонирования репозитория установите зависимости проекта с помощью Composer:
```
composer install
```
если не работает, то попробовать
```
composer install --ignore-platform-req=ext-sodium
```

### 3. Настройка окружения
Скопируйте файл .env.example в .env:
```
cp .env.example .env
```
Если необходимо настройки .env файла для работы с Docker, то необходимо скопировать файл .env.example_docker:
```
cp .env.example_docker .env
```

Откройте файл .env и настройте параметры подключения к базе данных в случае, если вы скопировали данные с env.example:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<your_database_name>
DB_USERNAME=<your_database_user>
DB_PASSWORD=<your_database_password>
```
Также в файле .env можете настроить параметры для отправки электронных писем на электронную почту (данная функция используется для восстановления пароля по электронной почте и подтверждения вашей электронной почты):
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=<your_mail_username>
MAIL_PASSWORD=<your_mail_password>
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=<your_mail_from_address>
MAIL_FROM_NAME="${APP_NAME}"
```

А также в файле .env можете настроить параметры для авторизации и регистрации в системе через google и github:
```
GITHUB_CLIENT_ID=<your_GitHub_Client_id>
GITHUB_CLIENT_SECRET=<your_GitHub_Client_Secret>
GOOGLE_CLIENT_ID=<your_Google_Client_id>
GOOGLE_CLIENT_SECRET=<your_Google_Client_Secret>
```

### 4. Генерация ключа приложения
Сгенерируйте ключ приложения Laravel:
```
php artisan key:generate
```
