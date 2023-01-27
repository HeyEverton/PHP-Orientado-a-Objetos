<?php

namespace Code\Security\Validator;

class Validator
{
    public static function validateRequiredFields(array $data): bool
    {
        foreach ($data as $key => $value) {
            if (!$data[$key]) return false;
            break;
        }
        return true;
    }

    public static function validatePasswordConfirm($password, $confirmPassword): bool
    {
        return $password == $confirmPassword;
    }

    public static function validatePasswordMinStringLength($string): bool
    {
        return strlen($string) >= 6;
    }

    public static function validateImageFiles($files = []): bool
    {
        $isValidImages = true;
        $allowedImagesFiles = ['image/png', 'image/jpg', 'image/jpeg'];
        
        for ($i=0; $i < count($files['type']); $i++) { 
            if(!in_array($files['type'][$i], $allowedImagesFiles)) {
                $isValidImages = false;
            }
        }

        return $isValidImages;
    }
}
