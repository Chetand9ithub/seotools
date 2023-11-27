<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class keywordController extends Controller
{


    public function list(Request $request)
    {
        $finalData =  $request->f_list;
        $array = [
            'f_duplicates' => function ($finalData) {
                return $this->checkDuplicates($finalData);
            },
            'f_sort' => function ($finalData) use($request) {
                return $this->checkSorting($request,$finalData);
            },
            'f_empty' => function ($finalData) {
                return $this->checkEmpty($finalData);
            },
            'f_alphanum' => function ($finalData) {
                return $this->checkAlphanum($finalData);
            },
            'f_toupper' => function ($rawData) {
                return $this->checkToupper($rawData);
            },
            'f_tolower' => function ($finalData) {
                return $this->checkTolower($finalData);
            },
            'f_emailsonly' => function ($finalData) {
                return $this->validateEmail($finalData);
            },
            'f_urlsonly' => function ($finalData) {
                return $this->validateUrl($finalData);
            }
        ];


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

        $string = explode("\n", $email);

        $sortedArray = [];
        foreach ($string as $values) {

            // Use the preg_match function to test if the email matches the pattern
            if (preg_match($pattern, $values)) {

                $sortedArray[] =  $values;
            }
        }
        $sorted = implode("\n", $sortedArray);
        return $sorted;
    }

    function validateUrl($url)
    {
        // Define a regular expression pattern for a valid url address
        $pattern = '/((http|https)\:\/\/)?[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/';

        $string = explode("\n", $url);

        $sortedArray = [];
        foreach ($string as $values) {

            // Use the preg_match function to test if the url matches the pattern
            if (preg_match($pattern, $values)) {

                $sortedArray[] =  $values;
            }
        }
        $sorted = implode("\n", $sortedArray);
        return $sorted;
    }

    function checkDuplicates($keyword)
    {
        $string = explode("\n", $keyword);

        $array = array_values(array_unique($string));

        $sortedArray  = implode("\n", $array);

        return $sortedArray;
    }

    function checkSorting($request, $rawData)
    {
        $string = explode("\n", $rawData);

        if(in_array('f_tolower', $request->check) ||  in_array('f_toupper',$request->check)){
            sort($string, SORT_NATURAL | SORT_STRING | SORT_FLAG_CASE | SORT_ASC);
        }else{
            sort($string, SORT_NATURAL | SORT_STRING |  SORT_ASC);
        }

        $sortedArray = implode("\n", $string);

        return $sortedArray;
    }

    function checkEmpty($rawData)
    {
        // Define a regular expression pattern for a check empty value
        $sortedArray = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $rawData);

        return $sortedArray;
    }

    function checkAlphanum($rawData)
    {
        $string = explode("\n", $rawData);

        $pattern = '/[^A-Za-z0-9 ]/';

        $array = preg_replace($pattern, '', $string);

        $sortedArray = implode("\n", $array);

        return $sortedArray;
    }

    function checkToupper($rawData)
    {
        $sortedArray = strtoupper($rawData);

        return $sortedArray;
    }

    function checkTolower($rawData)
    {

        $sortedArray = strtolower($rawData);

        return $sortedArray;
    }
}
