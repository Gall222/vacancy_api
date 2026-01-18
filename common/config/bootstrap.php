<?php

use common\modules\vacancy\mappers\ActionMapper;
use common\modules\vacancy\mappers\ActionMapperInterface;
use common\modules\vacancy\repositories\VacancyRepository;
use common\modules\vacancy\repositories\VacancyRepositoryInterface;
use common\modules\vacancy\services\VacancyService;
use common\modules\vacancy\services\VacancyServiceInterface;

defined('YII_DEBUG') or define('YII_DEBUG', false);

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

Yii::$container->set(VacancyServiceInterface::class, VacancyService::class);
Yii::$container->set(VacancyRepositoryInterface::class, VacancyRepository::class);
Yii::$container->set(ActionMapperInterface::class, ActionMapper::class);
