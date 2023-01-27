<?php 

namespace Code\Security\Validator;

class Sanitizer 
{
    public static function sanitizeData($data, $sanitizeFilters)
    {
        return filter_var_array($data, $sanitizeFilters);
    }
}