<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class keywordController extends Controller
{


    public function list(Request $request)
    {

        $keyword = $request->f_list;

        $array = [
            'f_duplicates' => function ($rawData) {
                return $this->checkDuplicates($rawData);
            },
            'f_sort' => function ($rawData) {
                return $this->checkSorting($rawData);
            },
            'f_empty' => function($rawData){
                return $this->checkEmpty($rawData);
            },
            'f_alphanum' => function($rawData){
                return $this->checkAlphanum($rawData);
            },
            'f_toupper' => function($rawData){
                return $this->checkToupper($rawData);
            },
            'f_tolower' => function($rawData){
                return $this->checkTolower($rawData);
            },
            'f_emailsonly' => function($rawData){
                return $this->validateEmail($rawData);
            },
            'f_urlsonly' => function($rawData){
                return $this->validateUrl($rawData);
            }
        ];

        $finalData =  $request->f_list;
        foreach ($request->check as $filed) {
            $finalData = $array[$filed]($finalData);
        }

        $result  =  $finalData;
        return view('viewbox', compact('result'));
    }


    function validateEmail($email)
    {
        // Define a regular expression pattern for a valid email address
        $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$/';

        // Use the preg_match function to test if the email matches the pattern
        if (preg_match($pattern, $email)) {
            return $email;
        } else {
            return " ";
        }
    }

    function validateUrl($url)
    {
        // Define a regular expression pattern for a valid url address
        $pattern = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        // Use the preg_match function to test if the url matches the pattern
        if (preg_match($pattern, $url)) {
            return $url;
        } else {
            return " ";
        }
    }

    function checkDuplicates($keyword)
    {
        $string = explode("\n", $keyword);

        $array = array_values(array_unique($string));

        $sortedArray  = implode("\n", $array);

        return $sortedArray;
    }

    function checkSorting($rawData)
    {
        $string = explode("\n", $rawData);

        sort($string,SORT_NATURAL | SORT_FLAG_CASE);

        $sortedArray = implode("\n", $string);

        return $sortedArray;

    }

    function checkEmpty($rawData)
    {
        // Define a regular expression pattern for a check empty value
        $sortedArray = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $rawData);

        return $sortedArray;
    }

    function checkAlphanum($rawData){
        $sortedArray = preg_replace("/[^a-zA-Z0-9]+/", "", $rawData);

        return $sortedArray;
    }

    function checkToupper($rawData){
        $sortedArray = strtoupper($rawData);

        return $sortedArray;
    }

    function checkTolower($rawData){

        $sortedArray = strtolower($rawData);

        return $sortedArray;
    }
}
