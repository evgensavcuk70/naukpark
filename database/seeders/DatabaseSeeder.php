<?php

// Сідер початкових даних бази даних.
namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Capability;
use App\Models\User;
use App\Models\NewsCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {


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
    }
}
