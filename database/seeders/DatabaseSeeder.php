<?php

// Сідер початкових даних бази даних.
namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Capability;
use App\Models\User;
use App\Models\NewsCategory;
// >>> ТЕСТОВІ ДАНІ ДЛЯ ПЕРЕВІРКИ ПАГІНАЦІЇ (можна видалити разом з блоком нижче) >>>
use App\Models\Slide;
use App\Models\News;
use App\Models\NewsGallery;
// <<< кінець імпортів для тестових даних <<<
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        // firstOrCreate замість factory()->create(), щоб повторний запуск
        // db:seed не падав через дублікат email (унікальне поле в users).
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password')]
        );

        $categories = [
            ['name_ua' => 'Новини Наукового парку',    'name_en' => 'Science Park News'],
            ['name_ua' => 'Наукові дослідження',        'name_en' => 'Scientific Research'],
            ['name_ua' => 'Інновації та стартапи',      'name_en' => 'Innovations and Startups'],
            ['name_ua' => 'Гранти та проєкти',          'name_en' => 'Grants and Projects'],
            ['name_ua' => 'Освітні заходи',             'name_en' => 'Educational Events'],
            ['name_ua' => 'Тренінги та семінари',       'name_en' => 'Trainings and Seminars'],
            ['name_ua' => 'Співпраця з бізнесом',       'name_en' => 'Business Cooperation'],
            ['name_ua' => 'Міжнародна діяльність',      'name_en' => 'International Activities'],
            ['name_ua' => 'Цифрова трансформація',      'name_en' => 'Digital Transformation'],
            ['name_ua' => 'Зелена трансформація',       'name_en' => 'Green Transformation'],
            ['name_ua' => 'Події та анонси',            'name_en' => 'Events and Announcements'],
        ];

        foreach ($categories as $cat) {
            NewsCategory::firstOrCreate(
                ['slug' => Str::slug($cat['name_en'])],
                $cat
            );
        }

        $activities = [
            [
                'icon_path'       => 'icon4.svg',
                'title_ua'        => 'Цифрова та зелена трансформація',
                'title_en'        => 'Digital and Green Transformation',
                'description_ua'  => 'Розробка інноваційних рішень, що поєднують цифрові технології з принципами сталого розвитку.',
                'description_en'  => 'Development of innovative solutions that combine digital technologies with the principles of sustainable development.',
                'sort_order'      => 1,
                'is_visible'      => true,
            ],
            [
                'icon_path'       => 'icon3.svg',
                'title_ua'        => 'Екологія, біоекономіка та агротехнології',
                'title_en'        => 'Ecology, Bioeconomy and Agrotechnologies',
                'description_ua'  => 'Дослідження та впровадження технологій раціонального використання природних ресурсів, розвитку біоекономіки.',
                'description_en'  => 'Research and implementation of technologies for the rational use of natural resources, development of the bioeconomy and biomass processing.',
                'sort_order'      => 2,
                'is_visible'      => true,
            ],
            [
                'icon_path'       => 'icon2.svg',
                'title_ua'        => 'Цифровізація громад та бізнесу',
                'title_en'        => 'Digitalization of Communities and Business',
                'description_ua'  => 'Створення цифрових сервісів, геоінформаційних систем, платформ моніторингу та автоматизації для громад і бізнесу.',
                'description_en'  => 'Creation of digital services, geoinformation systems, monitoring platforms and automation solutions for communities and businesses.',
                'sort_order'      => 3,
                'is_visible'      => true,
            ],
            [
                'icon_path'       => 'icon1.svg',
                'title_ua'        => 'Інновації та стартапи',
                'title_en'        => 'Innovation and Startups',
                'description_ua'  => 'Підтримка молодих інноваторів, розвиток стартапів, комерціалізація наукових досліджень та залучення інвестицій.',
                'description_en'  => 'Support for young innovators, startup development, commercialization of scientific research and attraction of investments.',
                'sort_order'      => 4,
                'is_visible'      => true,
            ],
            [
                'icon_path'       => 'icon5.svg',
                'title_ua'        => 'Освіта та розвиток талантів',
                'title_en'        => 'Education and Talent Development',
                'description_ua'  => 'Практико-орієнтована освіта, інноваційні освітні програми, стажування та можливості професійного зростання.',
                'description_en'  => 'Practice-oriented education, innovative educational programs, internships and opportunities for professional growth.',
                'sort_order'      => 5,
                'is_visible'      => true,
            ],
        ];

        foreach ($activities as $activity) {
            Activity::firstOrCreate(
                ['title_ua' => $activity['title_ua']],
                $activity
            );
        }

        $capabilities = [
            [
                'icon_path'      => 'cap_1781541808.jpg',
                'title_ua'       => 'Підтримка стартапів',
                'title_en'       => 'Startup support',
                'description_ua' => 'Допомога у розробці, тестуванні та масштабуванні інноваційних проєктів і стартапів.',
                'description_en' => 'Support for innovative projects and startups.',
                'sort_order'     => 1,
                'is_visible'     => true,
            ],
            [
                'icon_path'      => 'cap_1781766033.jpg',
                'title_ua'       => 'Грантові програми',
                'title_en'       => 'Grant programs',
                'description_ua' => 'Інформаційна та консультаційна підтримка у пошуку грантів і фінансування наукових досліджень.',
                'description_en' => 'Grant programs and research funding.',
                'sort_order'     => 2,
                'is_visible'     => true,
            ],
            [
                'icon_path'      => 'icon1.svg',
                'title_ua'       => 'Інтелектуальна власність',
                'title_en'       => 'Intellectual property consulting',
                'description_ua' => 'Супровід патентування, реєстрації торгових марок та захисту авторських прав.',
                'description_en' => 'Intellectual property consulting.',
                'sort_order'     => 3,
                'is_visible'     => true,
            ],
            [
                'icon_path'      => 'icon4.svg',
                'title_ua'       => 'Коворкінг та інфраструктура',
                'title_en'       => 'Coworking and infrastructure',
                'description_ua' => 'Робочі простори, лабораторне та технічне обладнання для реалізації проєктів.',
                'description_en' => 'Access to coworking spaces and innovation infrastructure.',
                'sort_order'     => 4,
                'is_visible'     => true,
            ],
            [
                'icon_path'      => 'icon2.svg',
                'title_ua'       => 'Партнерства та співпраця',
                'title_en'       => 'Partnerships and cooperation',
                'description_ua' => 'Налагодження партнерств для спільних проєктів і обміну досвідом.',
                'description_en' => 'Cooperation with businesses, communities and international partners.',
                'sort_order'     => 5,
                'is_visible'     => true,
            ],
            [
                'icon_path'      => 'icon5.svg',
                'title_ua'       => 'Тренінги та форуми',
                'title_en'       => 'Trainings and forums',
                'description_ua' => 'Освітні події для розвитку компетенцій науковців, студентів та підприємців.',
                'description_en' => 'Organization of trainings, forums and educational events.',
                'sort_order'     => 6,
                'is_visible'     => true,
            ],
        ];

        foreach ($capabilities as $capability) {
            Capability::firstOrCreate(
                ['title_ua' => $capability['title_ua']],
                $capability
            );
        }

        // ============================================================
        // >>> ТЕСТОВІ ДАНІ ДЛЯ ПЕРЕВІРКИ ПАГІНАЦІЇ (ПОЧАТОК) >>>
        // Мета блоку: наповнити базу "під зав'язку", щоб вручну перевірити,
        // чи коректно працює пагінація/обмеження кількості записів:
        //  - слайди, можливості, напрями діяльності — доводяться до стелі
        //    (Slide::maxActiveRecords() / Capability::maxActiveRecords() /
        //    Activity::maxActiveRecords(), зараз це 10 — див. HasContentLimits);
        //  - новини — додається стільки, щоб список новин (по 6 на сторінку,
        //    див. NewsController::index) розбився мінімум на 2 сторінки,
        //    частина новин отримує вкладені фото (галерею).
        // Використовуються реальні файли зображень, що вже лежать у
        // public/images і ніде раніше в коді не використовувались.
        //
        // Щоб прибрати ці тестові дані — видаліть увесь блок між цією міткою
        // та міткою "КІНЕЦЬ ТЕСТОВИХ ДАНИХ" нижче (а також відповідні
        // use-імпорти Slide/News/NewsGallery на початку файлу, якщо вони
        // більше ніде не потрібні).
        // ============================================================

        // --- Слайди головного слайдера (доводимо до максимуму — 10 шт.) ---
        $slides = [
            ['image_path' => 'photo_1782390344.jpg',              'title_ua' => 'Науковий парк «Поліський університет»',        'title_en' => 'Science Park "Polissia University"',        'sort_order' => 1,  'is_active' => true],
            ['image_path' => 'photo_1782390362.jpg',              'title_ua' => 'Простір для наукових досліджень',              'title_en' => 'Space for scientific research',             'sort_order' => 2,  'is_active' => true],
            ['image_path' => 'photo_1782769548.jpg',              'title_ua' => 'Підтримка інновацій та стартапів',             'title_en' => 'Support for innovation and startups',       'sort_order' => 3,  'is_active' => true],
            ['image_path' => '01KWBKVMW0N1BR1CTJ7HVAVCWN.jpg',      'title_ua' => 'Сучасна лабораторна інфраструктура',           'title_en' => 'Modern laboratory infrastructure',          'sort_order' => 4,  'is_active' => true],
            ['image_path' => '01KWBM7AF7RQ8YZG5K54T05Z7J.jpg',      'title_ua' => 'Команда науковців та експертів',               'title_en' => 'Team of scientists and experts',            'sort_order' => 5,  'is_active' => true],
            ['image_path' => '01KWBM7AHWSGCYQ5V1V0F303DR.png',      'title_ua' => 'Освітні програми та стажування',               'title_en' => 'Educational programs and internships',      'sort_order' => 6,  'is_active' => true],
            ['image_path' => '01KWK7T7V53B29TTK9JT4W0HRE.jpg',      'title_ua' => 'Співпраця з бізнесом і громадами',             'title_en' => 'Cooperation with business and communities', 'sort_order' => 7,  'is_active' => true],
            ['image_path' => '01KWK7T7Y70QYT4KM8TXG7W1V1.png',      'title_ua' => 'Грантові та міжнародні проєкти',               'title_en' => 'Grant and international projects',          'sort_order' => 8,  'is_active' => true],
            ['image_path' => '01KWK7T81EH7RFM4FV8W52PW1T.png',      'title_ua' => 'Заходи, тренінги та форуми',                   'title_en' => 'Events, trainings and forums',              'sort_order' => 9,  'is_active' => true],
            ['image_path' => 'cap_1781541808.jpg',                 'title_ua' => 'Разом до нових досягнень',                     'title_en' => 'Together towards new achievements',         'sort_order' => 10, 'is_active' => true],
            // 11-й слайд навмисно вимкнений (is_active = false), щоб активних
            // залишалось рівно 10 і не було конфлікту з Slide::maxActiveRecords().
            ['image_path' => 'cap_1781766033.jpg',                 'title_ua' => 'Резервний слайд (вимкнено)',                   'title_en' => 'Reserve slide (disabled)',                  'sort_order' => 11, 'is_active' => false],
        ];

        foreach ($slides as $slide) {
            Slide::firstOrCreate(
                ['image_path' => $slide['image_path']],
                $slide
            );
        }

        // --- Додаткові "можливості" (в базовому масиві вище вже 6 — додаємо ще 4, разом 10) ---
        $extraCapabilities = [
            [
                'icon_path'      => 'icon3.svg',
                'title_ua'       => 'Консультаційний супровід проєктів',
                'title_en'       => 'Project consulting support',
                'description_ua' => 'Індивідуальні консультації щодо запуску та розвитку наукових і бізнес-проєктів.',
                'description_en' => 'Individual consulting on launching and developing scientific and business projects.',
                'sort_order'     => 7,
                'is_visible'     => true,
            ],
            [
                'icon_path'      => 'icon1.svg',
                'title_ua'       => 'Доступ до обладнання',
                'title_en'       => 'Access to equipment',
                'description_ua' => 'Використання спеціалізованого наукового та лабораторного обладнання Наукового парку.',
                'description_en' => 'Use of specialized scientific and laboratory equipment of the Science Park.',
                'sort_order'     => 8,
                'is_visible'     => true,
            ],
            [
                'icon_path'      => 'icon4.svg',
                'title_ua'       => 'Міжнародні обміни',
                'title_en'       => 'International exchange programs',
                'description_ua' => 'Участь у програмах академічної мобільності та міжнародних стажуваннях.',
                'description_en' => 'Participation in academic mobility programs and international internships.',
                'sort_order'     => 9,
                'is_visible'     => true,
            ],
            [
                'icon_path'      => 'icon2.svg',
                'title_ua'       => 'Промоція проєктів',
                'title_en'       => 'Project promotion',
                'description_ua' => 'Допомога у презентації проєктів інвесторам, партнерам та на публічних заходах.',
                'description_en' => 'Assistance in presenting projects to investors, partners and at public events.',
                'sort_order'     => 10,
                'is_visible'     => true,
            ],
            // 11-та можливість навмисно вимкнена (is_visible = false), щоб активних
            // залишалось рівно 10 і не було конфлікту з Capability::maxActiveRecords().
            [
                'icon_path'      => 'icon5.svg',
                'title_ua'       => 'Резервна можливість (вимкнено)',
                'title_en'       => 'Reserve capability (disabled)',
                'description_ua' => 'Запасний запис для перевірки ліміту активних можливостей.',
                'description_en' => 'Reserve record for testing the active-capabilities limit.',
                'sort_order'     => 11,
                'is_visible'     => false,
            ],
        ];

        foreach ($extraCapabilities as $capability) {
            Capability::firstOrCreate(
                ['title_ua' => $capability['title_ua']],
                $capability
            );
        }

        // --- Додаткові "напрями діяльності" (в базовому масиві вище вже 5 — додаємо ще 5, разом 10) ---
        $extraActivities = [
            [
                'icon_path'       => 'icon3.svg',
                'title_ua'        => 'Наукові дослідження та розробки',
                'title_en'        => 'Scientific research and development',
                'description_ua'  => 'Проведення прикладних досліджень у партнерстві з бізнесом та державними установами.',
                'description_en'  => 'Conducting applied research in partnership with business and government institutions.',
                'sort_order'      => 6,
                'is_visible'      => true,
            ],
            [
                'icon_path'       => 'icon1.svg',
                'title_ua'        => 'Трансфер технологій',
                'title_en'        => 'Technology transfer',
                'description_ua'  => 'Впровадження наукових розробок у реальний сектор економіки.',
                'description_en'  => 'Implementation of scientific developments in the real economy.',
                'sort_order'      => 7,
                'is_visible'      => true,
            ],
            [
                'icon_path'       => 'icon2.svg',
                'title_ua'        => 'Підтримка молодих науковців',
                'title_en'        => 'Support for young scientists',
                'description_ua'  => 'Гранти, стипендії та менторська підтримка для молодих дослідників.',
                'description_en'  => 'Grants, scholarships and mentoring support for young researchers.',
                'sort_order'      => 8,
                'is_visible'      => true,
            ],
            [
                'icon_path'       => 'icon4.svg',
                'title_ua'        => 'Розвиток інфраструктури',
                'title_en'        => 'Infrastructure development',
                'description_ua'  => 'Модернізація лабораторій, коворкінгів та іншої матеріально-технічної бази.',
                'description_en'  => 'Modernization of laboratories, coworking spaces and other infrastructure.',
                'sort_order'      => 9,
                'is_visible'      => true,
            ],
            [
                'icon_path'       => 'icon5.svg',
                'title_ua'        => 'Публічна аналітика та звітність',
                'title_en'        => 'Public analytics and reporting',
                'description_ua'  => 'Підготовка аналітичних матеріалів та публічних звітів про діяльність парку.',
                'description_en'  => 'Preparation of analytical materials and public reports on the park activities.',
                'sort_order'      => 10,
                'is_visible'      => true,
            ],
            // 11-й напрям навмисно вимкнений (is_visible = false), щоб активних
            // залишалось рівно 10 і не було конфлікту з Activity::maxActiveRecords().
            [
                'icon_path'       => 'icon3.svg',
                'title_ua'        => 'Резервний напрям діяльності (вимкнено)',
                'title_en'        => 'Reserve activity direction (disabled)',
                'description_ua'  => 'Запасний запис для перевірки ліміту активних напрямів діяльності.',
                'description_en'  => 'Reserve record for testing the active-directions limit.',
                'sort_order'      => 11,
                'is_visible'      => false,
            ],
        ];

        foreach ($extraActivities as $activity) {
            Activity::firstOrCreate(
                ['title_ua' => $activity['title_ua']],
                $activity
            );
        }

        // --- Новини: додаємо стільки записів, щоб список (6 на сторінку) зайняв 2 сторінки ---
        $newsCategoryIds = NewsCategory::pluck('id', 'slug');
        $fallbackCategoryId = $newsCategoryIds->first();

        $newsItems = [
            [
                'slug'                 => 'naukovyi-park-zapuskaie-novu-laboratoriiu',
                'category_slug'        => 'scientific-research',
                'image_main'           => 'news_1781541088.jpg',
                'title_ua'             => 'Науковий парк запускає нову дослідницьку лабораторію',
                'title_en'             => 'Science Park launches a new research laboratory',
                'excerpt_ua'           => 'Нова лабораторія відкриває доступ до сучасного обладнання для студентів і науковців.',
                'excerpt_en'           => 'The new laboratory provides access to modern equipment for students and researchers.',
                'content_ua'           => 'Науковий парк «Поліський університет» відкрив нову дослідницьку лабораторію, оснащену сучасним обладнанням. Це дозволить розширити спектр прикладних досліджень і залучити більше студентських команд до реальних наукових проєктів.',
                'content_en'           => 'Science Park "Polissia University" has opened a new research laboratory equipped with modern devices. This will expand the range of applied research and involve more student teams in real scientific projects.',
                'is_pinned'            => true,
                'is_archived'          => false,
                'published_at'         => now()->subDays(3),
                'gallery'              => [],
            ],
            [
                'slug'                 => 'startap-vikend-zibrav-ponad-50-uchasnykiv',
                'category_slug'        => 'innovations-and-startups',
                'image_main'           => 'news_1781541131.jpg',
                'title_ua'             => 'Стартап-вікенд зібрав понад 50 учасників',
                'title_en'             => 'Startup weekend gathered over 50 participants',
                'excerpt_ua'           => 'Учасники презентували проєкти у сферах агротеху, ІТ та зеленої енергетики.',
                'excerpt_en'           => 'Participants presented projects in agrotech, IT and green energy.',
                'content_ua'           => 'У Науковому парку відбувся черговий стартап-вікенд, який зібрав понад 50 учасників з різних міст. За два дні команди розробили прототипи рішень у сферах агротеху, інформаційних технологій та зеленої енергетики, а найкращі проєкти отримали менторську підтримку.',
                'content_en'           => 'The Science Park hosted another startup weekend that gathered over 50 participants from different cities. Over two days, teams developed prototype solutions in agrotech, IT and green energy, and the best projects received mentoring support.',
                'is_pinned'            => false,
                'is_archived'          => false,
                'published_at'         => now()->subDays(10),
                'gallery'              => ['news_1781541422.jpg', 'news_1781541482.jpg', 'news_1781541506.jpg'],
            ],
            [
                'slug'                 => 'vidkryto-nabir-na-hrantovu-prohramu',
                'category_slug'        => 'grants-and-projects',
                'image_main'           => 'news_1781541728.jpg',
                'title_ua'             => 'Відкрито набір заявок на грантову програму',
                'title_en'             => 'Applications open for the grant program',
                'excerpt_ua'           => 'Науковці та підприємці можуть подати заявки на фінансування дослідницьких проєктів.',
                'excerpt_en'           => 'Researchers and entrepreneurs can apply for funding of research projects.',
                'content_ua'           => 'Розпочався прийом заявок на нову грантову програму для науковців і підприємців. Учасники зможуть отримати фінансування на реалізацію дослідницьких і прикладних проєктів, а також консультаційну підтримку на всіх етапах.',
                'content_en'           => 'Applications have opened for a new grant program for researchers and entrepreneurs. Participants will be able to receive funding for research and applied projects, as well as consulting support at every stage.',
                'is_pinned'            => false,
                'is_archived'          => false,
                'published_at'         => now()->subDays(18),
                'gallery'              => [],
            ],
            [
                'slug'                 => 'osvitnii-forum-dlia-studentiv-ta-vykladachiv',
                'category_slug'        => 'educational-events',
                'image_main'           => 'news_1781542366.jpg',
                'title_ua'             => 'Освітній форум для студентів і викладачів',
                'title_en'             => 'Educational forum for students and lecturers',
                'excerpt_ua'           => 'Форум об’єднав понад 100 учасників з різних факультетів університету.',
                'excerpt_en'           => 'The forum brought together over 100 participants from different faculties.',
                'content_ua'           => 'У Науковому парку відбувся освітній форум, присвячений практико-орієнтованому навчанню. Захід відвідали понад 100 студентів і викладачів, які обговорили нові підходи до підготовки фахівців та можливості для стажувань.',
                'content_en'           => 'The Science Park hosted an educational forum dedicated to practice-oriented learning. Over 100 students and lecturers attended the event and discussed new approaches to professional training and internship opportunities.',
                'is_pinned'            => false,
                'is_archived'          => false,
                'published_at'         => now()->subDays(25),
                'gallery'              => ['news_1781542438.jpg', 'news_1781542537.jpg'],
            ],
            [
                'slug'                 => 'treninh-z-zakhystu-intelektualnoi-vlasnosti',
                'category_slug'        => 'trainings-and-seminars',
                'image_main'           => 'news_1781619585.jpg',
                'title_ua'             => 'Тренінг із захисту інтелектуальної власності',
                'title_en'             => 'Training on intellectual property protection',
                'excerpt_ua'           => 'Учасники дізналися, як правильно оформити патент та захистити торгову марку.',
                'excerpt_en'           => 'Participants learned how to properly file a patent and protect a trademark.',
                'content_ua'           => 'Для науковців і підприємців провели тренінг з питань патентування та захисту інтелектуальної власності. Експерти розповіли про типові помилки під час реєстрації прав та відповіли на запитання учасників.',
                'content_en'           => 'A training on patenting and intellectual property protection was held for researchers and entrepreneurs. Experts discussed common mistakes during rights registration and answered participants questions.',
                'is_pinned'            => false,
                'is_archived'          => false,
                'published_at'         => now()->subDays(33),
                'gallery'              => [],
            ],
            [
                'slug'                 => 'pidpysano-memorandum-z-biznes-partneramy',
                'category_slug'        => 'business-cooperation',
                'image_main'           => 'news_1781765828.jpg',
                'title_ua'             => 'Підписано меморандум про співпрацю з бізнес-партнерами',
                'title_en'             => 'Memorandum of cooperation signed with business partners',
                'excerpt_ua'           => 'Угода передбачає спільні проєкти у сфері цифровізації та підтримки стартапів.',
                'excerpt_en'           => 'The agreement covers joint projects in digitalization and startup support.',
                'content_ua'           => 'Науковий парк підписав меморандум про співпрацю з групою регіональних компаній. Сторони домовились про спільні проєкти у сфері цифровізації бізнес-процесів, підтримки стартапів та обміну експертизою.',
                'content_en'           => 'The Science Park signed a memorandum of cooperation with a group of regional companies. The parties agreed on joint projects in business process digitalization, startup support and expertise exchange.',
                'is_pinned'            => false,
                'is_archived'          => false,
                'published_at'         => now()->subDays(40),
                'gallery'              => ['news_1781765864.jpg', 'news_1781765870.jpg', 'news_1781766178.jpg', 'news_1781766189.jpg'],
            ],
            [
                'slug'                 => 'mizhnarodnyi-vizyt-partneriv-z-yevropy',
                'category_slug'        => 'international-activities',
                'image_main'           => 'news_1781766216.jpg',
                'title_ua'             => 'Міжнародний візит партнерів з Європи',
                'title_en'             => 'International visit of partners from Europe',
                'excerpt_ua'           => 'Делегація ознайомилась з проєктами Наукового парку та обговорила спільні ініціативи.',
                'excerpt_en'           => 'The delegation reviewed Science Park projects and discussed joint initiatives.',
                'content_ua'           => 'Науковий парк відвідала делегація партнерів з європейських університетів. Гості ознайомились із поточними проєктами та обговорили можливості спільних грантових заявок і обмінних програм.',
                'content_en'           => 'The Science Park was visited by a delegation of partners from European universities. The guests reviewed current projects and discussed opportunities for joint grant applications and exchange programs.',
                'is_pinned'            => false,
                'is_archived'          => false,
                'published_at'         => now()->subDays(47),
                'gallery'              => [],
            ],
            [
                'slug'                 => 'zapuscheno-servis-tsyfrovoi-monitorynhu-hromad',
                'category_slug'        => 'digital-transformation',
                'image_main'           => 'news_1781766267.jpg',
                'title_ua'             => 'Запущено сервіс цифрового моніторингу для громад',
                'title_en'             => 'Digital monitoring service launched for communities',
                'excerpt_ua'           => 'Новий сервіс допоможе громадам відстежувати стан інфраструктурних проєктів онлайн.',
                'excerpt_en'           => 'The new service helps communities track infrastructure projects online.',
                'content_ua'           => 'Команда Наукового парку розробила цифровий сервіс моніторингу для територіальних громад. Інструмент дозволяє відстежувати стан реалізації інфраструктурних проєктів у реальному часі та формувати звіти.',
                'content_en'           => 'The Science Park team developed a digital monitoring service for territorial communities. The tool allows tracking the implementation status of infrastructure projects in real time and generating reports.',
                'is_pinned'            => false,
                'is_archived'          => false,
                'published_at'         => now()->subDays(54),
                'gallery'              => [],
            ],
            [
                'slug'                 => 'zelenyi-proiekt-pererobky-biomasy',
                'category_slug'        => 'green-transformation',
                'image_main'           => 'news_1781766327.jpg',
                'title_ua'             => 'Стартував зелений проєкт з переробки біомаси',
                'title_en'             => 'Green biomass processing project launched',
                'excerpt_ua'           => 'Проєкт спрямований на розвиток біоекономіки та зменшення відходів агросектору.',
                'excerpt_en'           => 'The project aims to develop the bioeconomy and reduce agricultural waste.',
                'content_ua'           => 'Науковий парк розпочав реалізацію проєкту з переробки біомаси в межах напряму зеленої трансформації. Мета проєкту — зменшити обсяги відходів агросектору та створити нові джерела відновлюваної енергії.',
                'content_en'           => 'The Science Park has launched a biomass processing project as part of the green transformation direction. The project aims to reduce agricultural waste volumes and create new renewable energy sources.',
                'is_pinned'            => false,
                'is_archived'          => false,
                'published_at'         => now()->subDays(61),
                'gallery'              => ['news_1781766358.jpg', 'news_1781766388.jpg'],
            ],
            [
                'slug'                 => 'vidkryto-koorking-prostir-dlia-startapiv',
                'category_slug'        => 'innovations-and-startups',
                'image_main'           => 'news_1781541422.jpg',
                'title_ua'             => 'Відкрито коворкінг-простір для стартапів',
                'title_en'             => 'A coworking space for startups has opened',
                'excerpt_ua'           => 'Новий простір надає командам робочі місця, обладнання та доступ до менторів.',
                'excerpt_en'           => 'The new space gives teams workstations, equipment, and access to mentors.',
                'content_ua'           => 'У Науковому парку відкрито новий коворкінг-простір для молодих команд і стартапів. Учасники отримають доступ до робочих місць, необхідного обладнання та регулярних консультацій з менторами.',
                'content_en'           => 'The Science Park has opened a new coworking space for young teams and startups. Participants get access to workstations, necessary equipment, and regular mentor consultations.',
                'is_pinned'            => false,
                'is_archived'          => false,
                'published_at'         => now()->subDays(68),
                'gallery'              => [],
            ],
            [
                'slug'                 => 'rezultaty-konkursu-innovatsiinykh-idei',
                'category_slug'        => 'grants-and-projects',
                'image_main'           => 'news_1781541482.jpg',
                'title_ua'             => 'Оголошено результати конкурсу інноваційних ідей',
                'title_en'             => 'Results of the innovative ideas competition announced',
                'excerpt_ua'           => 'Переможці отримають фінансування та супровід для реалізації своїх проєктів.',
                'excerpt_en'           => 'Winners will receive funding and support to implement their projects.',
                'content_ua'           => 'Науковий парк підбив підсумки щорічного конкурсу інноваційних ідей. Переможці отримають грантове фінансування та супровід команди парку на етапі впровадження проєктів.',
                'content_en'           => 'The Science Park has summed up the results of the annual innovative ideas competition. Winners will receive grant funding and support from the park team at the implementation stage.',
                'is_pinned'            => false,
                'is_archived'          => false,
                'published_at'         => now()->subDays(75),
                'gallery'              => [],
            ],
            [
                'slug'                 => 'seminar-z-tsyfrovoi-bezpeky-dlia-hromad',
                'category_slug'        => 'trainings-and-seminars',
                'image_main'           => 'news_1781541506.jpg',
                'title_ua'             => 'Проведено семінар з цифрової безпеки для громад',
                'title_en'             => 'A digital security seminar for communities was held',
                'excerpt_ua'           => 'Учасники дізналися про базові практики захисту цифрових сервісів громад.',
                'excerpt_en'           => 'Participants learned basic practices for protecting community digital services.',
                'content_ua'           => 'Для представників територіальних громад проведено семінар з цифрової безпеки. Учасники ознайомились із базовими практиками захисту даних та цифрових сервісів громад.',
                'content_en'           => 'A digital security seminar was held for representatives of territorial communities. Participants learned basic practices for protecting data and community digital services.',
                'is_pinned'            => false,
                'is_archived'          => false,
                'published_at'         => now()->subDays(82),
                'gallery'              => [],
            ],
            [
                'slug'                 => 'novyi-partner-z-tsyfrovoi-transformatsii',
                'category_slug'        => 'digital-transformation',
                'image_main'           => 'news_1781542438.jpg',
                'title_ua'             => 'Науковий парк уклав угоду з новим партнером із цифрової трансформації',
                'title_en'             => 'Science Park signs agreement with new digital transformation partner',
                'excerpt_ua'           => 'Співпраця передбачає спільні проєкти з цифровізації послуг для громад і бізнесу.',
                'excerpt_en'           => 'The cooperation includes joint projects to digitalize services for communities and business.',
                'content_ua'           => 'Науковий парк «Поліський університет» уклав угоду про співпрацю з новим партнером у сфері цифрової трансформації. Сторони планують спільно реалізовувати проєкти з цифровізації послуг для громад і бізнесу.',
                'content_en'           => 'Science Park "Polissia University" has signed a cooperation agreement with a new digital transformation partner. The parties plan to jointly implement projects to digitalize services for communities and businesses.',
                'is_pinned'            => false,
                'is_archived'          => false,
                'published_at'         => now()->subDays(90),
                'gallery'              => [],
            ],
        ];

        foreach ($newsItems as $item) {
            $galleryImages = $item['gallery'] ?? [];
            unset($item['gallery']);

            $categorySlug = $item['category_slug'];
            unset($item['category_slug']);

            $item['category_id'] = $newsCategoryIds[$categorySlug] ?? $fallbackCategoryId;

            $news = News::firstOrCreate(
                ['slug' => $item['slug']],
                $item
            );

            foreach ($galleryImages as $imagePath) {
                NewsGallery::firstOrCreate([
                    'news_id'    => $news->id,
                    'image_path' => $imagePath,
                ]);
            }
        }
        // <<< ТЕСТОВІ ДАНІ ДЛЯ ПЕРЕВІРКИ ПАГІНАЦІЇ (КІНЕЦЬ) <<<
        // ============================================================
    }
}