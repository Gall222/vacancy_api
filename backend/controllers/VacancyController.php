<?php

declare(strict_types=1);

namespace backend\controllers;

use common\constants\ResponseCode;
use common\modules\vacancy\models\Vacancy;
use common\modules\vacancy\services\VacancyServiceInterface;
use Yii;
use yii\db\Exception;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use OpenApi\Annotations as OA;
use yii\filters\Cors;
use yii\web\Response;

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

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        unset($behaviors['authenticator']); // если есть

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['http://localhost:3000'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Max-Age' => 86400,
            ],
        ];

        return $behaviors;
    }

    public function actionOptions()
    {
        Yii::$app->response->statusCode = 204;
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
        $vacancy = $this->vacancyService->create($request->bodyParams);

        Yii::$app->response->setStatusCode(ResponseCode::CREATED);

        return $vacancy;
    }
}
