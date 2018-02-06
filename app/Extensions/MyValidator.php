<?php

/**
 * Created by PhpStorm.
 * User: qinqinfeng
 * Date: 17/8/18
 * Time: 下午4:08
 */
namespace App\Extensions;

use Illuminate\Validation\Validator;

class MyValidator extends Validator
{
    /**
     * 验证11位手机号
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function validateMobile($attribute, $value)
    {
        if (is_null($value)) {
            return false;
        }
        return isMobile($value);
    }
}