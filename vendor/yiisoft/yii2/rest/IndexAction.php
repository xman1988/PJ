<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\rest;

use app\controllers\BaseApiController;
use Yii;
use yii\data\Pagination;

/**
 * IndexAction реализует конечную точку API для  нескольких моделей.
 *
 */
class IndexAction extends Action
{

    /**
     * Метод реализует конечную точку API для нескольких моделей.
     *
     */
    public function run()
    {
        /**
         * @var $modelClass \yii\db\BaseActiveRecord
         */
        $modelClass = $this->modelClass;

        if ($modelClass === 'app\models\Drivers' ) {

            $query = $modelClass::find();

            $pagination = new Pagination([
                'defaultPageSize' => 10,
                'totalCount' => $query->count(),
            ]);

            $drivers = $query
                ->with('buses')
                ->orderBy(['name' => SORT_ASC])
                ->offset($pagination->offset)
                ->limit($pagination->limit)
                ->each();

            $allDriversInfo = BaseApiController:: getListDrivers($drivers);


            return $allDriversInfo;

        } elseif ($modelClass === 'app\models\Buses') {


            $query = $modelClass::find();

            $pagination = new Pagination([
                'defaultPageSize' => 10,
                'totalCount' => $query->count(),
            ]);

            $buses = $query
                ->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();

            return $buses;

        }
    }
}
