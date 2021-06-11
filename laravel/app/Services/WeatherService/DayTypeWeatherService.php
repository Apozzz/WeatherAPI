<?php declare(strict_types=1);


namespace App\Services\WeatherService;


use App\Exceptions\CannotConnectToMeteoAPIException;
use App\Exceptions\CityNotFoundException;

class DayTypeWeatherService implements APIInterface
{
    protected MeteoApiClient $meteoApi;

    public function __construct(MeteoApiClient $meteo)
    {
        $this->meteoApi = $meteo;
    }

    /**
     * Function that returns array filled with weather types that were the most
     * common during the day together with the date. First element is always the
     * correct name of city that was analized.
     * @param string $city
     * @return string[]
     * @throws CannotConnectToMeteoAPIException
     * @throws CityNotFoundException
     */
    public function getProcessedAPIData(string $city): array
    {
        return $this->transform($this->meteoApi->callAPI($city));
    }

    /**
     * Function that transforms initial API data to array of weather type and date elements.
     * @param array $data
     * @return string[]
     */
    protected function transform(array $data): array
    {
        // Returns array with data - weather type => day of that weather ('sunny' => 2021-05-01)
        $weatherTypes = ['place' => $this->getCityName($data)];

        // Holds the amount of each weather types that occured during the hours
        $dayTypes = $this->getInitialCounter();

        $dayCounter = 0;

        // A day string, to know when to reset array that holds
        // ongoing days weather types counts
        // Initial day value
        $temp = strtotime($data['forecastTimestamps'][0]['forecastTimeUtc']);
        $currentDay = date('d', $temp);

        // Iterating through all values of weather
        foreach ($data['forecastTimestamps'] as $forecastTimestamp) {

            // Break condition, if the data of three days
            // is found, we dont need to calculate anymore
            if ($dayCounter >= 3){
                break;
            }

            $forecastTimeUtc = strtotime($forecastTimestamp['forecastTimeUtc']);
            $forecastConditionCode = $forecastTimestamp['conditionCode'];
            $dayChecker = date('d', $forecastTimeUtc);

            if ($this->isNotCurrentDay($dayChecker, $currentDay)) {
                $currentDay = $dayChecker;
            }

            $currentHour = date('H', $forecastTimeUtc);
            $dayTypes[$forecastConditionCode] += 1;

            // If its the last checking element of the day (one that contains 21st hour),
            // we add highest found weatherType to the weatherTypes array before the array
            // gets reseted
            if ($currentHour === '21') {
                arsort($dayTypes);
                $weather = array_keys($dayTypes)[0];
                $weatherTypes[] = [$weather => date('Y-m-d', $forecastTimeUtc)];
                $dayTypes = $this->getInitialCounter();
                $dayCounter += 1;
            }
        }
        return $weatherTypes;
    }

    /**
     * Function that returns initial counter
     * to calculate the most common weather types
     * @return int[]
     */
    protected function getInitialCounter(): array
    {
        return [
            'clear' => 0,
            'isolated-clouds' => 0,
            'scattered-clouds' => 0,
            'overcast' => 0,
            'light-rain' => 0,
            'moderate-rain' => 0,
            'heavy-rain' => 0,
            'sleet' => 0,
            'light-snow' => 0,
            'moderate-snow' => 0,
            'heavy-snow' => 0,
            'fog' => 0,
            'na' => 0,
        ];
    }

    /**
     * Function that checks if two given dates in string format
     * are the same ones
     * @param string $dayChecker
     * @param string $currentDay
     * @return bool
     */
    protected function isNotCurrentDay(string $dayChecker, string $currentDay): bool
    {
        return $dayChecker != $currentDay;
    }

    /**
     * Function that returns city name that API called
     * @param $dataArray
     * @return string
     */
    protected function getCityName($dataArray): string
    {
        return $dataArray['place']['name'];
    }
}
