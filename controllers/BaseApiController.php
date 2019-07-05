<?php


namespace app\controllers;

use GuzzleHttp;
use Yii;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Response;

/**
 * BaseApiController общий контроллер для контроллеров DriversController и BusesController
 */
class BaseApiController extends ActiveController
{
    /**
     * Константа, указывает продолжительность рабочего времени водителя
     */
    const WORK_HOURS = 8;

    /**
     * @var string Ключ apiGoogleMaps
     */
    private static $apiKey;

    /**
     * Метод принимает объект данных и создает новый результирующий массив данных для отправки клиенту.
     * Метод заполняет массив данными водителей из переданного объекта и иными данными, которыми необходимо дополнить ответ.
     * Метод добавляет в массив ответа время водителем расстояние между переданными городами.
     *
     * @param object $drivers Объект данных водителей из БД.
     * @return array Массив данных водителей
     */
    public static function getListDriversWithTimeInfo($drivers)
    {
        // Расстояние между городами
        $distanceKM = self::getDistance();

        $arrResult = self::getListDrivers($drivers);
        foreach ($drivers as $keyDriver => $driver) {
            // Считаем количество дней в пути
            $countTravelDays = self::getCountTravelDays($driver, $distanceKM);
            $arrResult[$keyDriver]['travel_time'] = $countTravelDays;
        }
        
        return $arrResult;
    }

    /**
     * Метод отдает расстояние по автодорогам в км между переданными двумя городами.
     * Значение расстояния метод получает от сервера GoogleMaps по API.
     * Для отправки запроса к GoogleMaps используется библиотека GuzzleHttp.
     * При отправке запроса к серверу GoogleMaps ОБЯЗАТЕЛЬНО нужно передать в параметре 'key' - ваш ключь apiKey от GoogleMaps
     *
     * @return integer Расстояние в километрах
     */

    public static function getDistance()
    {

        self::$apiKey = Yii::$app->params['apiKey'];

        $params = Yii::$app->getRequest()->getQueryParams();

        $client = new GuzzleHttp\Client();

        // Делаем запрос к серверу и передаем города
        $response = $client->request('GET', 'https://maps.googleapis.com/maps/api/distancematrix/json',
            [
                "query" => [
                    'key' => self::$apiKey, // здесь нужно вставить ваш ключь apiKey от GoogleMaps
                    'units' => 'metric',
                    'origins' => $params['from'],
                    'destinations' => $params['to'],
                    'language' => 'ru',
                    'mode' => 'driving'
                ]

            ]);

        $responseString = $response->getBody();

        // Получаем ассоциативный массив данных
        $data = json_decode($responseString, true);

        // Выбираем необходимое значение в метрах
        $distanceM = $data["rows"][0]["elements"][0]["distance"]["value"];

        // Переводим расстояние из метров в километры
        $distanceKM = $distanceM / 1000;

        return (integer)$distanceKM;

    }

    /**
     * Метод принимает объект данных и создает новый результирующий массив данных для отправки клиенту.
     * Метод заполняет массив данными водителей из переданного объекта и иными данными, которыми необходимо дополнить ответ.
     *
     * @param object $drivers Объект данных водителей из БД.
     * @return array Массив данных водителей
     */
    public static function getListDrivers($drivers)
    {
        $arrResult = [];

        foreach ($drivers as $keyDriver => $driver) {

            // Вычисляем возраст водителя
            $age = self::getAge($driver->birth_year);

            // Заполняем массив данными водителя и новыми расчитанными выше данными
            $arrResult[$keyDriver]['id'] = $driver->id;
            $arrResult[$keyDriver]['name'] = $driver->name;
            $arrResult[$keyDriver]['birth_date'] = $driver->birth_year;
            $arrResult[$keyDriver]['age'] = $age;
        }

        return $arrResult;
    }

    /**
     * Метод вычисляет возраст водителя, считая от года его рождения до текущего года
     *
     * @param integer $birthYear год рождения водителя
     * @return integer возраст водителя
     */

    public static function getAge($birthYear)
    {
        $intBirthYear = (int)$birthYear;
        $currentYear = (int)date('Y');
        $age = $currentYear - $intBirthYear;

        return $age;
    }

    /**
     * Метод отдает количество дней, требуемых водителю для проезда переданного расстояния.
     * Остаток неполного дня округляется до целого дня.
     *
     * @param object $driver Объект данных одного водителя
     * @param integer $distanceKM Расстояние между городами
     * @return integer Время водителя в пути в сутках, округленное в большую сторону
     */

    public static function getCountTravelDays($driver, $distanceKM)
    {
        if (empty($driver->buses)) {
            return null;
        }

        foreach ($driver->buses as $keyBus => $bus) {
            $busArr[$keyBus] = (integer)$bus['average_speed'];
        }

        if (count($busArr) === 1) {
            $speedKMH = (integer)$bus['average_speed'];
        } else {
            $speedKMH = (integer)max($busArr);
        }

        $division = $distanceKM / $speedKMH;

        if (empty($distanceKM)) {
            return null;
        } elseif ($division <= self::WORK_HOURS) {
            return 1;
        }
        $daysTravel = $division / self::WORK_HOURS;

        return ceil($daysTravel);
    }

    /**
     * Метод принимает объект данных и создает новый результирующий массив данных для отправки клиенту.
     * Метод заполняет массив данными одного водителя из переданного объекта и иными данными, которыми необходимо дополнить ответ.
     *
     * @param object $driver Объект данных водителя из БД.
     * @return array Массив данных водителя
     */

    public static function getOneDriverInfo($driver)
    {

        $distanceKM = self::getDistance();
        $arrResult = [];

        $countTravelDays = self::getCountTravelDays($driver, $distanceKM);

        $age = self::getAge($driver->birth_year);

        $arrResult['id'] = $driver->id;
        $arrResult['name'] = $driver->name;
        $arrResult['birth_date'] = $driver->birth_year;
        $arrResult['age'] = $age;

        $params = Yii::$app->getRequest()->getQueryParams();
        if(isset($params['from']) and isset($params['to'])){
            $arrResult['travel_time'] = $countTravelDays;
        }

        return $arrResult;
    }


    /**
     * Метод возвращает настройки формата передачи данных клиенту
     *
     * @return array Массив настроек
     */
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formatParam' => '_format',
                'formats' => [
                    'json' => Response::FORMAT_JSON,
                    'xml' => Response::FORMAT_XML,
                ],
            ],
        ];
    }


}

