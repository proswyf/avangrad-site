<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$classes = [
    [
        'name' => 'Йога Balance',
        'slug' => 'yoga',
        'description' => 'Спокойная практика для гибкости, мобильности суставов и мягкого восстановления после рабочего дня.',
        'image' => 'yoga.jpg',
        'instructor' => 'Анна Миронова',
        'duration' => 60,
        'max_people' => 15,
        'schedule' => 'ПН, СР, ПТ | 19:00 - 20:00',
        'days' => ['monday', 'wednesday', 'friday'],
        'is_active' => true,
    ],
    [
        'name' => 'Пилатес Core',
        'slug' => 'pilates',
        'description' => 'Тренировка на осанку, контроль движения и укрепление глубоких мышц корпуса без ударной нагрузки.',
        'image' => 'pilates.jpg',
        'instructor' => 'Елена Крылова',
        'duration' => 55,
        'max_people' => 12,
        'schedule' => 'ВТ, ЧТ | 18:30 - 19:25',
        'days' => ['tuesday', 'thursday'],
        'is_active' => true,
    ],
    [
        'name' => 'Сайкл Ride',
        'slug' => 'cycling',
        'description' => 'Энергичная кардио-тренировка на велотренажерах для выносливости, рельефа и мощного заряда энергии.',
        'image' => 'cycling.jpg',
        'instructor' => 'Игорь Власов',
        'duration' => 45,
        'max_people' => 18,
        'schedule' => 'ПН, СР | 20:15 - 21:00',
        'days' => ['monday', 'wednesday'],
        'is_active' => true,
    ],
    [
        'name' => 'Функциональный тренинг',
        'slug' => 'crossfit',
        'description' => 'Интенсивная силовая работа в мини-группе: круговые комплексы, координация, выносливость и техника.',
        'image' => 'crossfit.jpg',
        'instructor' => 'Максим Орлов',
        'duration' => 50,
        'max_people' => 10,
        'schedule' => 'ВТ, ЧТ, СБ | 19:30 - 20:20',
        'days' => ['tuesday', 'thursday', 'saturday'],
        'is_active' => true,
    ],
    [
        'name' => 'Бокс Fit',
        'slug' => 'boxing',
        'description' => 'Драйвовая тренировка на технику ударов, реакцию, координацию и общую физическую подготовку.',
        'image' => 'boxing.jpg',
        'instructor' => 'Дмитрий Соколов',
        'duration' => 60,
        'max_people' => 14,
        'schedule' => 'СР, ПТ | 20:00 - 21:00',
        'days' => ['wednesday', 'friday'],
        'is_active' => true,
    ],
    [
        'name' => 'Зумба Dance',
        'slug' => 'zumba',
        'description' => 'Танцевальная кардио-программа с латинскими ритмами, легкой хореографией и очень живой атмосферой.',
        'image' => 'zumba.jpg',
        'instructor' => 'Мария Лебедева',
        'duration' => 50,
        'max_people' => 20,
        'schedule' => 'ВТ, ВС | 18:00 - 18:50',
        'days' => ['tuesday', 'sunday'],
        'is_active' => true,
    ],
];

foreach ($classes as $class) {
    App\Models\GroupClass::updateOrCreate(
        ['slug' => $class['slug']],
        $class
    );
}

$result = [
    'count' => App\Models\GroupClass::count(),
    'items' => App\Models\GroupClass::orderBy('id')
        ->get(['id', 'name', 'slug', 'description', 'instructor', 'duration', 'max_people', 'schedule'])
        ->toArray(),
];

file_put_contents(
    __DIR__ . '/../storage/app/group_classes_check.json',
    json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);

echo "done\n";
