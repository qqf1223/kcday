<?php
namespace App\Http\Requests;

use App\Libs\Tool;

trait KcAdminRequest
{
    public function response(array $errors)
    {
        $error_data = [];
        foreach($errors as $k => $error){
            $error_data[$k] = $err[] =  is_array($error) && !empty($error) ? array_shift($error) : '';
        }
        if($this->expectsJson()){
            //return (new Tool())->setStatusCode(422)->responseError('出错!', $error_data);
            return (new Tool())->setStatusCode(422)->responseError(array_shift($err), $error_data);
        }

        return $this->redirector->to($this->getRedirectUrl)
            ->withInput($this->except($this->dontFlash))
            ->with('errors', $error_data);
    }
}