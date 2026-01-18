<?php

declare(strict_types=1);

namespace  common\modules\vacancy\dto;

final class VacancyCreateDto
{
    public function __construct(
        public string $title,
        public string $description,
        public int $salary
    ) {}
}
