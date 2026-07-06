# Науковий парк «Поліський університет» — сайт

Сайт наукового парку на Laravel 13 з публічною частиною (Blade) та адмін-панеллю на Filament 3.

## Стек технологій

- PHP 8.3, Laravel 13
- Filament 3 — адмін-панель (`/admin`)
- MySQL 8 (у продакшн/докер-оточенні), Blade-шаблони
- Vite + Tailwind CSS 4 для фронтенд-збірки
- Docker / docker-compose (nginx + php-fpm + mysql) для локального запуску

## Вимоги

- PHP 8.3+, Composer
- Node.js 18+ і npm
- Docker і docker-compose (якщо запускаєте через контейнери)

## Встановлення

### 1. Клонування репозиторію

```bash
git clone <URL-цього-репозиторію>
cd <назва-папки>
```

### 2. Змінні середовища

```bash
cp .env.example .env
```

Відкрийте `.env` і заповніть реальні значення (пароль БД, `APP_URL` тощо). **Ніколи не комітьте `.env` у git** — файл вже додано до `.gitignore`.

### 3а. Запуск через Docker (рекомендовано)

```bash
docker compose build
docker compose up -d
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
docker compose exec app php artisan storage:link
docker compose exec app npm install
docker compose exec app npm run build
```

Сайт буде доступний на [http://localhost:8080](http://localhost:8080).

### 3б. Запуск без Docker (локальний PHP/MySQL)

```bash
composer install
php artisan key:generate
php artisan migrate
php artisan storage:link
npm install
npm run build
php artisan serve
```

Також можна одразу виконати `composer run setup`, який зробить установку, генерацію ключа, міграції та збірку фронтенду за один прохід.

Для розробки з автоперезбіркою фронтенду й логами одночасно: `composer run dev`.

## Структура проєкту

### `app/Http/Controllers/`

Логіка публічних сторінок сайту.

- `HomeController.php` — головна сторінка
- `NewsController.php` — список новин (пошук, фільтри, пагінація), сторінка окремої новини
- `SitemapController.php` — `/sitemap.xml`
- `RobotsController.php` — `/robots.txt`

### `app/Filament/`

Адмін-панель (на бібліотеці Filament, доступна на `/admin`, окремих маршрутів у `routes/web.php` для неї не потрібно — реєструється автоматично через `app/Providers/Filament/AdminPanelProvider.php`).

- `Resources/` — по одному ресурсу на кожну сутність: `ActivityResource`, `CapabilityResource`, `NewsCategoryResource`, `NewsResource`, `SlideResource`, `UserResource`. У кожного є файл `*Resource.php` (таблиця, форма, фільтри) і папка `*Resource/Pages/` зі сторінками списку/створення/редагування — так Filament генерує ресурси, це нормально.
- `Pages/SiteSettings.php` — сторінка налаштувань сайту (соцмережі, контакти тощо).
- `Pages/DatabaseBackup.php` — кнопка вивантаження бекапу БД (`mysqldump`).

Вхід в адмінку — через звичайну таблицю `users` (Filament-логін), а не окремий хардкоджений пароль.

### `app/Models/`

Класи, що описують таблиці бази даних (News, Slide, Activity, ActivityDirection, Capability, NewsCategory, NewsGallery, SiteSetting, User). Якщо потрібно додати нове поле в БД — спочатку міграція (`database/migrations`), потім додати поле у відповідну модель сюди.

### `resources/views/`

HTML-шаблони публічних сторінок (Blade-файли):

- `home.blade.php` — головна сторінка
- `news/index.blade.php` — список новин
- `news/show.blade.php` — окрема новина
- `sitemap.blade.php` — шаблон `/sitemap.xml`
- `layouts/app.blade.php` — загальна "рамка" сайту (шапка, підключення стилів/скриптів) — її підключають усі інші сторінки
- `pagination/site.blade.php` — вигляд пагінації (номери сторінок), підключається автоматично через `->links()`
- `filament/pages/` — шаблони сторінок адмінки (налаштування, бекап)

Адмінка на Filament генерує свою верстку сама, окремих Blade-файлів на кшталт `admin/dashboard.blade.php` у проєкті більше немає.

### `public/`

Усе, що напряму віддається браузеру:

- `images/` — фотографії новин, іконки напрямів/можливостей, логотип
- `css/` — стилі сайту
- `js/` — слайдер і загальні скрипти
- це єдина папка, яку потрібно вказати як кореневу при налаштуванні домену на хостингу

### `database/migrations/`

Опис структури таблиць БД. Виконуються командою `php artisan migrate`. Файл `database/database.sqlite` у репозиторій не входить (див. `.gitignore`) — якщо потрібна sqlite для локальної розробки, створіть порожній файл командою `touch database/database.sqlite` і вкажіть `DB_CONNECTION=sqlite` у `.env`.

### `routes/web.php`

Список усіх адрес сайту (які URL існують і яким контролерам вони передаються). Адмінка сюди не входить — її маршрути реєструє Filament окремо.

### `.env`

Налаштування підключення до бази даних та інші конфігураційні дані. **Не викладайте цей файл у відкритий доступ** — у ньому реальний пароль від БД. Файл вже в `.gitignore` і не потрапляє в репозиторій; орієнтир для потрібних змінних — `.env.example`.

---

- `vendor/` — бібліотеки Laravel, встановлені через Composer (не в git, встановлюється командою `composer install`).
- `node_modules/` — залежності npm (не в git, встановлюється командою `npm install`).
- `bootstrap/cache/`, `config/` — системні налаштування Laravel.
- `storage/` — тимчасові файли, кеш, логи, завантажені файли (вміст не в git, самі папки збережено через `.gitignore`-заглушки).

## Безпека

Перед публікацією репозиторію **обов'язково змініть цей пароль** (і в БД, і в новому `.env`).
