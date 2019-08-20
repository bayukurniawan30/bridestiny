<?php

namespace Bridestiny\Functions;

use Cake\Cache\Cache;
use Cake\Http\ServerRequest;
use \BenMajor\ExchangeRatesAPI\ExchangeRatesAPI;
use \BenMajor\ExchangeRatesAPI\Response;
use \BenMajor\ExchangeRatesAPI\Exception;
use Steevenz\Rajaongkir;

class GlobalFunctions
{
    private $pluginName = 'Bridestiny';

    public function routePrefix()
    {
        $prefix = 'bridestiny';
        return $prefix;
    }
    public function formatRupiah($number, $symbol = 'IDR')
    {
        if ($symbol == 'IDR') {
            $result = 'IDR ' . number_format($number, 0, '', '.');
        }
        elseif ($symbol == 'Rp') {
            $result = 'Rp ' . number_format($number, 2, ',', '.');
        }
        elseif ($symbol == false) {
            $result = number_format($number, 0, '', '.');
        }

        return $result;
    }
    public function availableCurrencies()
    {
        $options = [
            'USD' => 'United States dollar (USD)', 
            'JPY' => 'Japanese yen (JPY)', 
            'GBP' => 'Pound sterling (GBP)', 
            'EUR' => 'Euro (EUR)', 
            'HKD' => 'Hong Kong dollar (HKD)', 
            'MYR' => 'Malaysian ringgit (MYR)', 
            'SGD' => 'Singapore dollar (SGD)', 
            'AUD' => 'Australian dollar (AUD)', 
            'INR' => 'Indian rupee (INR)'
        ];

        return $options;
    }
    public function formatCurrency($number, $currency)
    {
        $currency = strtoupper($currency);

        if ($currency == 'USD') {
            $result = '$'.$number;
        }
        elseif ($currency == 'AUD') {
            $result = '$'.$number;
        }
        elseif ($currency == 'SGD') {
            $result = '$'.$number;
        }
        elseif ($currency == 'HKD') {
            $result = '$'.$number;
        }
        elseif ($currency == 'JPY') {
            $result = '¥'.$number;
        }
        elseif ($currency == 'MYR') {
            $result = 'RM'.$number;
        }
        elseif ($currency == 'EUR') {
            $result = '€'.$number;
        }
        elseif ($currency == 'GBP') {
            $result = '£'.$number;
        }
        elseif ($currency == 'INR') {
            $result = '₹'.$number;
        }

        return $result;
    }
    public function currencySymbol($currency)
    {
        $currency = strtoupper($currency);

        if ($currency == 'IDR') {
            $result = 'IDR ';
        }
        elseif ($currency == 'USD') {
            $result = '$';
        }
        elseif ($currency == 'AUD') {
            $result = '$';
        }
        elseif ($currency == 'SGD') {
            $result = '$';
        }
        elseif ($currency == 'JPY') {
            $result = '¥';
        }
        elseif ($currency == 'KRW') {
            $result = '₩';
        }
        elseif ($currency == 'KRW') {
            $result = '₩';
        }
        elseif ($currency == 'THB') {
            $result = '฿';
        }
        elseif ($currency == 'EUR') {
            $result = '€';
        }

        return $result;        
    }
    public function currencyConverterCache($currency)
    {
        $currency = strtoupper($currency);

        if (($converter = Cache::read($this->pluginName . '.currencyConverter'.$currency)) === false) {
            $lookup = new ExchangeRatesAPI();
            $rates  = $lookup->setBaseCurrency($currency)->convert('IDR', 1);
            Cache::write($this->pluginName . '.currencyConverter'.$currency, $rates);
        }
        else {
            $rates  = Cache::read($this->pluginName . '.currencyConverter'.$currency);
        }

        return $rates;
    }
    public function currencyConverter($from, $to, $value)
    {
        $currencyFrom = strtoupper(trim($from));
        $currencyTo   = strtoupper(trim($to));
        $lookup       = new ExchangeRatesAPI();
        $rates        = $lookup->setBaseCurrency($currencyFrom)->convert($currencyTo, $value);

        return $rates;
    }
    public function rajaongkirProvinces($apiKey, $accountType)
    {
        $config['api_key']      = trim($apiKey);
        $config['account_type'] = trim(strtolower($accountType));
 
        $rajaongkir = new Rajaongkir($config);
        $provinces  = $rajaongkir->getProvinces();

        return $provinces;
    }
    public function rajaongkirProvinceDetail($apiKey, $accountType, $id)
    {
        $config['api_key']      = trim($apiKey);
        $config['account_type'] = trim(strtolower($accountType));
 
        $rajaongkir = new Rajaongkir($config);
        $province   = $rajaongkir->getProvince($id);

        return $province;
    }
    public function rajaongkirCities($apiKey, $accountType, $provinceId = NULL)
    {
        $config['api_key']      = trim($apiKey);
        $config['account_type'] = trim(strtolower($accountType));
 
        $rajaongkir = new Rajaongkir($config);
        if ($provinceId == NULL) {
            $cities     = $rajaongkir->getCities();
        }
        else {
            $cities     = $rajaongkir->getCities($provinceId);
        }

        return $cities;
    }
    public function rajaongkirCityDetail($apiKey, $accountType, $id)
    {
        $config['api_key']      = trim($apiKey);
        $config['account_type'] = trim(strtolower($accountType));
 
        $rajaongkir = new Rajaongkir($config);
        $city       = $rajaongkir->getCity($id);

        return $city;
    }
}