<?php

class ValController
{

    //Sanitize data
    public function sanitization($value)
    {
        $value = trim($value); // Delete spaces before and after
        $value = stripslashes($value); // Delete \/
        $value = htmlspecialchars($value); // Convert special characters to HTML entities
        return $value;
    }

    // Validate required fields
    public function validateRequired($value)
    {
        if ($value != "") {
            return true;
        } else {
            return false;
        }
    }

    public function validateLength($value, $options)
    {

        $length = strlen($value);

        if (filter_var($length, FILTER_VALIDATE_INT, $options) === false) {
            return false;
        } else {
            return true;
        }
    }

    public function validateEmail($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            return false;
        } else {
            return true;
        }
    }

    public function validatePasswordStrength($value)
    {
        if (preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[!@#$%])[0-9A-Za-z!@#$%]{8,12}$/', $value)) {
            return true;
        } else {
            return false;
        }
    }
}
