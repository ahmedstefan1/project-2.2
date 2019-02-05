<?php
/*
 * Validator class
 *
 * Validate elements and get errors
 *
 * @author: Bumbella
 * @contact: http://themeforest.net/user/bumbella
 * @license    MIT
 * 
 * */

class Validator
{

    const MIN = 8;

    private $errors = array();

    /**
     * __construct
     */
    public function __construct()
    {

    }

    /**
     * validate data
     * @param array $data
     * @param array $ruleset
     * @return boolean
     */
    public function validate(Array $data, Array $ruleset)
    {
        $valid = true;

        foreach ($ruleset as $item => $rules) {

            /* email|required|min:8 */
            $rules = explode('|', $rules);

            foreach ($rules as $rule) {

                $pos = strpos($rule, ':');

                if ($pos !== false) {
                    $param = substr($rule, $pos + 1, strlen($rule));
                    $rule = substr($rule, 0, $pos);
                } else {
                    $param = null;
                }

                $methodName = 'validate' . ucfirst($rule);

                $value = isset($data[$item]) ? $data[$item] : Null;

                if (method_exists($this, $methodName)) {
                    if (!$this->$methodName($item, $value, $param))
                        return false;
                } else
                    $valid = false;
            }
        }
        return $valid;
    }

    /**
     * validate email
     * @param string $item
     * @param string $value
     * @param string $param
     * @return boolean
     */
    private function validateEmail($item, $value, $param)
    {

        if ($value === '' || !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$item][] = "Not valid $item";
            return false;
        }

        return true;
    }

    /**
     * validate required
     * @param string $item
     * @param string $value
     * @param string $param
     * @return boolean
     */
    private function validateRequired($item, $value, $param)
    {

        if ($value === '' || $value === NULL) {
            $this->errors[$item][] = "This field $item is required!";
            return false;
        }

        return true;
    }

    /**
     * validate min
     * @param string $item
     * @param string $value
     * @param string $param
     * @return boolean
     */
    private function validateMin($item, $value, $param)
    {
        if ($value == '' || strlen($value) < $param) {
            $this->errors[$item][] = 'The password length must be minimum' . $param;
            return false;
        }

        return true;
    }

    /**
     * validate getErrors
     * @return string
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
