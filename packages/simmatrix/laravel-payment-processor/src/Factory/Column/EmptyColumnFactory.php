<?php

namespace Simmatrix\PaymentProcessor\Factory\Column;

use Simmatrix\PaymentProcessor\Column\Column;

class EmptyColumnFactory
{
    /**
     * Returns an empty column. This is not padded
     * @param String An optional label for the column, used in error messages.
     * @return Column
     */
    public static function create($label = ''){
        $column = new Column();
        $column -> setLabel($label);
        return $column;
    }
}
