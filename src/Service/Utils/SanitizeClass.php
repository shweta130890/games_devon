<?php
namespace App\Service\Utils;

class SanitizeClass
{
    /*
     * Apply this to strings type
     * */
    public function onlyString($v, $sub = null)
    {
        if ($sub) {
            if (strlen($v)>$sub) {
                $v = substr($v, 0, $sub);
            }
        }
        return filter_var($v, FILTER_SANITIZE_STRING);
    }
    /*
     * Apply this to integers
     * */
    public function onlyInteger($v)
    {
        return filter_var($v, FILTER_SANITIZE_NUMBER_INT);
    }
    /**
     * Apply this to floats
     *
     * @param $v
     * @return mixed
     */
    public function onlyFloat($v)
    {
        return filter_var($v, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }
    /*
     * Apply this to bool type
     * */
    public function onlyBool($v)
    {
        return filter_var($v, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
    /*
     * Apply this to emails
     * */
    public function onlyEmail($v)
    {
        return filter_var($v, FILTER_SANITIZE_EMAIL);
    }
    /**
     * Apply this to Arrays
     *
     * @param $v
     * @return mixed
     */
    public function onlyArray($v)
    {
        return filter_var($v, FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
    }

    /**
     * @param $v
     * @return mixed
     */
    public function onlyUrl($v)
    {
        return filter_var($v, FILTER_SANITIZE_URL);
    }
}