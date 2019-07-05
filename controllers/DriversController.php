<?php


namespace app\controllers;


use yii\data\Pagination;

class DriversController extends BaseApiController
{
    /* @var string название класса модели */
    public $modelClass = 'app\models\Drivers';

    /**
     * Метод реализует конечную точку API для выборки всех водителей и времени проезда между переданными городами
     * В методе реализована сортировка по полю 'average_speed' => SORT_DESC,
     * что в свою очередь позволяет отсортировать результирующий массив по полю 'travel_time' => SORT_ASC
     *
     * @return array массив с данными о водителях и времени проезда между городами
     */
    public function actionTime()
    {
        $model = $this->modelClass;
        $query = $model::find();

        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $query->count(),
        ]);

        $drivers = $query
            ->joinWith('buses')
            ->orderBy(['average_speed' => SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->each();

        $allDriversInfo = BaseApiController::getListDriversWithTimeInfo($drivers);

        return $allDriversInfo;
    }
}