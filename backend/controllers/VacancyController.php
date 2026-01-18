<?php

declare(strict_types=1);

namespace backend\controllers;

use common\constants\ResponseCode;
use common\modules\vacancy\models\Vacancy;
use common\modules\vacancy\services\VacancyServiceInterface;
use Yii;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use OpenApi\Annotations as OA;


final class VacancyController extends Controller
{
    public $enableCsrfValidation = false;
    private VacancyServiceInterface $vacancyService;

    public function __construct(
        $id,
        $module,
        VacancyServiceInterface $vacancyService,
        $config = []
    ) {
        $this->vacancyService = $vacancyService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @OA\Get(
     *     path="/api/vacancies",
     *     tags={"Vacancies"},
     *     summary="Список вакансий",
     *     @OA\Response(
     *         response=200,
     *         description="Список вакансий",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Vacancy"))
     *     )
     * )
     */
    public function actionIndex(): array
    {
        return $this->vacancyService->getAll();
    }

    /**
     * @OA\Get(
     *     path="/api/vacancies/{id}",
     *     tags={"Vacancies"},
     *     summary="Получить вакансию",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Вакансия",
     *         @OA\JsonContent(ref="#/components/schemas/Vacancy")
     *     ),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function actionView(int $id): Vacancy
    {
        return $this->vacancyService->get($id);
    }

    /**
     * @OA\Post(
     *     path="/api/vacancies",
     *     tags={"Vacancies"},
     *     summary="Создать вакансию",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/VacancyCreate")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Создано",
     *         @OA\JsonContent(ref="#/components/schemas/Vacancy")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function actionCreate(Request $request): Vacancy
    {
        $vacancy = $this->vacancyService->create($request->post());
        Yii::$app->response->setStatusCode(ResponseCode::CREATED);

        return $vacancy;
    }
}
