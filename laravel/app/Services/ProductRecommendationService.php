<?php

namespace App\Services;

use App\Exceptions\WeatherTypeNotInDataBaseException;
use App\Models\Product;
use App\Models\Weather;
use App\Services\WeatherService\APIInterface;
use Exception;
use Illuminate\Support\Collection;

class ProductRecommendationService implements ServicesInterface
{
    protected APIInterface $apiData;

    public function __construct(APIInterface $apiType)
    {
        $this->apiData = $apiType;
    }

    /**
     * Function that returns processed data array, that is ready
     * to be outputted in controller.
     * @param string $city
     * @return array
     * @throws WeatherTypeNotInDataBaseException
     */
    public function getServiceData(string $city): array
    {
        return $this->transform($this->apiData->getProcessedAPIData($city));
    }

    /**
     * Function that processes given array of weather types and assigns corresponding
     * products to the given weather.
     * @param array $data
     * @return array
     * @throws WeatherTypeNotInDataBaseException
     */
    protected function transform(array $data): array
    {
        // Formatted array that will be returned
        $processedArray = [];

        $processedArray['city'] = $data['place'];
        array_shift($data);

        // Creating recommendations array
        $recommendationsArray = [];
        foreach ($data as $weatherType) {
            $partialRecommendations = [];
            try {
                $products = Weather::where('name', '=', array_keys($weatherType)[0])->first()->products;
            } catch (Exception $e) {
                throw new WeatherTypeNotInDataBaseException('Weather type of \''.array_keys($weatherType)[0].'\' was not found in database');
            }

            $productsArray = $this->generateArrayOfTwoRandomProducts($products);
            $partialRecommendations['weather_forecast'] = array_keys($weatherType)[0];
            $partialRecommendations['date'] = array_values($weatherType)[0];
            $partialRecommendations['products'] = $productsArray;
            array_push($recommendationsArray, $partialRecommendations);
        }

        $processedArray['recommendations'] = $recommendationsArray;
        return $processedArray;
    }

    /**
     * Function, that generates two random products to offer, so there is less
     * chance to propose same products over and over again.
     * @param Collection $productsArray
     * @return array
     * @throws Exception
     * @throws Exception
     */
    protected function generateArrayOfTwoRandomProducts(Collection $productsArray): array
    {
        if ($productsArray->isEmpty()) {
            return [];
        }
        $generatedProductsArray = [];
        $firstItemIndex = random_int(0, count($productsArray) - 1);
        array_push($generatedProductsArray, $this->refineProductModel($productsArray[$firstItemIndex]));
        if (count($productsArray) == 1) {
            array_push($generatedProductsArray, $this->refineProductModel($productsArray[$firstItemIndex]));
            return $generatedProductsArray;
        }
        $secondItemIndex = random_int(0, count($productsArray) - 1);
        while ($secondItemIndex == $firstItemIndex) {
            $secondItemIndex = random_int(0, count($productsArray) - 1);
        }
        array_push($generatedProductsArray, $this->refineProductModel($productsArray[$secondItemIndex]));

        return $generatedProductsArray;
    }

    /**
     * Function that returns data refined from Product model
     * @param Product $productModel
     * @return array
     */
    protected function refineProductModel(Product $productModel): array
    {
        return [
            'sku' => $productModel->sku,
            'name' => $productModel->name,
            'price' => number_format(($productModel->price/100), 2, '.', ' '),
        ];
    }
}
