<?php

declare(strict_types=1);

use App\Models\Course;
use App\Models\Devoir;
use App\Models\GoldTransaction;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Student;

return [
    Course::class => 'CO',
    Devoir::class => 'GT',
    Payment::class => 'PY',
    Student::class => 'ET',
    // ajoute ici les autres modèles selon besoin
];
