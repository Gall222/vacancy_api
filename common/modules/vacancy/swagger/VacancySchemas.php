<?php

namespace common\modules\vacancy\swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Vacancy",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="description", type="string"),
 *     @OA\Property(property="salary", type="number", format="float")
 * )
 *
 * @OA\Schema(
 *     schema="VacancyCreate",
 *     type="object",
 *     required={"title","description","salary"},
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="description", type="string"),
 *     @OA\Property(property="salary", type="number", format="float")
 * )
 */
class VacancySchemas {}
