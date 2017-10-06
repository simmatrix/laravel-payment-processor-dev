<?php

namespace Simmatrix\PaymentProcessor\Factory\Column;

use Simmatrix\PaymentProcessor\Exceptions\PaymentProcessorColumnException;
use Simmatrix\PaymentProcessor\Column\Column;
use Simmatrix\PaymentProcessor\Line\Line;
use Config;

class ConfigurableStringColumnFactory
{
    /**
     * Creates a column with a value from config file.
     * Length will be set to the length of the configured value.
     * @param Line the parent line
     * @param String. Config key. The resolved value will be cast to a string.
     * @param String An optional label for the column, used in error messages.
     * @return Column
     */
    public static function create($config, $config_key, $label = '', $maximum_length = NULL, $chop_off_extra_characters = TRUE){
        if( !$config -> has($config_key)){
            throw new PaymentProcessorColumnException('Could not find the config option ' . $config_key);
        }
        $value = (string)$config -> get($config_key);
        if ( $maximum_length ) {
            if ( strlen( $value ) > $maximum_length ) {
                if ( $chop_off_extra_characters ) {
                    $value = substr( $value, 0, $maximum_length );
                } else {
                    throw new PaymentProcessorColumnException('The config key "' . $config_key . '" has exceeded the maximum length of ' . $maximum_length);
                }
            }
        }
        $column = new Column();
        $column -> setLabel($label);
        $column -> setValue($value);
        return $column;
    }
}
