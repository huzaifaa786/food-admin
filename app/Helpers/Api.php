<?php

namespace App\Helpers;


class Api
{
    private $data = [
        'error' => false
    ];

    public static function failed($validator)
    {
        $obj = new Api();
        $obj->data['error'] = true;
        $obj->data['error_data'] = $validator->errors()->first();
        return response()->json($obj->data);
    }

    public static function setError($error)
    {
        $obj = new Api();
        $obj->data['error'] = true;
        $obj->data['error_data'] = $error;
        return response()->json($obj->data);
    }

    public static function setErrorWithData($index, $object)
    {
        $obj = new Api();
        $obj->data['error'] = true;
        $obj->data[$index] = $object;
        return response()->json($obj->data);
    }

    public static function setResponse($index, $object)
    {
        $obj = new Api();
        $obj->data[$index] = $object;
        return response()->json($obj->data);
    }

    public static function setMessage($message)
    {
        $obj = new Api();
        $obj->data['error_data'] = $message;
        return response()->json($obj->data);
    }

    public function add($index, $object)
    {
        $this->data[$index] = $object;
    }

    public function json()
    {
        return response()->json($this->data);
    }

    public function getKey($index)
    {
        return $this->data[$index];
    }


}
