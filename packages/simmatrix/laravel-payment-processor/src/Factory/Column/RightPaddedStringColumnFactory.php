<?php

namespace Simmatrix\PaymentProcessor\Factory\Column;

use Simmatrix\PaymentProcessor\Column\Column;

class RightPaddedStringColumnFactory
{
    /**
     * Creates a column with a string value that is right padded to the length. E.g. "Timothy" with a length of 10 would become "Timothy   "
     * @param String. Any passed value will be cast to a string. E.g. 0 will be cast to "0"
     * @param int. The fixed length of the string
     * @param String An optional label for the column, used in error messages.
     * @return Column
     */
    public static function create($value, $length, $label = ''){
        $value = (string)$value;
        $column = new Column();
        $column -> setFixedLength($length);
        $column -> setLabel($label);
        $column -> setValue($value);
        $column -> setPaddingType(Column::PADDING_RIGHT);
        return $column;
    }
}
