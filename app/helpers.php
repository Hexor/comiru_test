<?php

use Illuminate\Validation\Validator;
use Illuminate\Contracts\Validation\Factory;
use Symfony\Component\HttpFoundation\Response;

if (!function_exists('inputAll')) {
    /**
     * @return array
     */
    function inputAll()
    {
        return request()->all();
    }
}

if (!function_exists('requestOnly')) {
    function requestOnly($array)
    {
        $result = [];

        foreach ($array as $one) {
            $result[$one] = inputGet($one);
        }

        return $result;
    }
}

if (!function_exists('inputGet')) {
    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    function inputGet($key, $default = null)
    {
        return request()->get($key, $default);
    }
}


if (!function_exists('bcrypt')) {
    /**
     * Hash the given value.
     *
     * @param  string $value
     * @param  array $options
     * @return string
     */
    function bcrypt($value, $options = [])
    {
        return app('hash')->make($value, $options);
    }
}

// Validate
if (!function_exists('validationFactory')) {

    /**
     * Get a validation factory instance.
     *
     * @return Factory
     */
    function validationFactory()
    {
        return app('validator');
    }
}

if (!function_exists('formatValidationErrors')) {

    /**
     * @param Validator $validator
     * @return array
     */
    function formatValidationErrors(Validator $validator)
    {
//    return $validator->errors()->getMessages();
        $messages = $validator->errors()->getMessages();
        $firstMessage = array_get($messages, array_keys($messages)[0]);

        //dd($firstMessage);

        return array_get($firstMessage, '0');
    }
}

if (!function_exists('responseNotFound')) {
    function responseNotFound($message)
    {
        return responseError($message, Response::HTTP_NOT_FOUND);
    }
}

if (!function_exists('responseUnauthorized')) {
    function responseUnauthorized($message)
    {
        return responseError($message, Response::HTTP_UNAUTHORIZED);
    }
}

if (!function_exists('responseUnprocessable')) {
    function responseUnprocessable($message)
    {
        return responseError($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

if (!function_exists('throwSaveFailedException')) {
    /**
     * @param $message
     * @throws Exception
     */
    function throwSaveFailedException($message = '操作失败, 数据存储出现问题')
    {
        throw new Exception($message, Response::HTTP_INSUFFICIENT_STORAGE);
    }
}
if (!function_exists('responseError')) {
    /**
     * @param string $errors
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    function responseError($errors = 'Error', $code = 200, $redirectPath = null)
    {
        $data = [
            'message' => $errors,
        ];
        if (!empty($redirectPath)) {
            $data['redirect_path'] = $redirectPath;
        }
        return response()->json($data, $code);
    }
}

if (!function_exists('responseSuccess')) {
    function responseSuccess($data = '')
    {
        return response()->json($data);
    }
}

if (!function_exists('getTokenProvider')) {
    function getTokenProvider($request)
    {
        $tokenProvider = "";
        if ($request->sign_type === 'teacher') {
            $tokenProvider = 'teachers';
        } elseif ($request->sign_type === 'student') {
            $tokenProvider = 'students';
        }

        return $tokenProvider;
    }
}
if (!function_exists('is_int_type')) {
    function isIntType($value)
    {
        if (filter_var($value, FILTER_VALIDATE_INT) === false) {
            return false;
        }

        return true;
    }
}

if (!function_exists('randomkeys')) {
    function randomkeys($length)
    {
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
        $key = '';
        for ($i = 0; $i < $length; $i++) {
            $key .= $pattern{mt_rand(0, 35)};
        }

        return $key;
    }
}

if (!function_exists('getAdminAccessTokenJWTKey')) {
    function getAdminAccessTokenJWTKey()
    {
        $appKey = env('APP_KEY');
    }
}

if (!function_exists('generateAdminAccessToken')) {
    function generateAdminAccessToken()
    {
        return str_random(env('ADMIN_TOKEN_STR_LENGTH')) . strval(time());
    }
}
