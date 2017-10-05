<?php

namespace Simmatrix\PaymentProcessor\Factory\UOB\Header;

use Simmatrix\PaymentProcessor\Line\Line;
use Simmatrix\PaymentProcessor\Line\Header;
use Simmatrix\PaymentProcessor\Beneficiary;
use Simmatrix\PaymentProcessor\BeneficiaryLines;
use Simmatrix\PaymentProcessor\Column\Date;
use Simmatrix\PaymentProcessor\Factory\Column\ConfigurableStringColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\EmptyColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\LeftPaddedDecimalWithoutDelimiterColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\PresetStringColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\RightPaddedStringColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\VariableLengthStringColumnFactory;


class UOBBatchHeader extends Header
{
    protected $columnDelimiter = "";

    /**
     * @return Line
     */
    public function getLine(){
        $line = new Line();
        $line -> setColumnDelimiter("");
        $columns = [
            'record_type'                   => PresetStringColumnFactory::create('1', $label = 'record_type'),
            'batch_no'                      => RightPaddedStringColumnFactory::create('', 20, $label = 'batch_no'),
            'payment_advice_header_line1'   => RightPaddedStringColumnFactory::create( '', 105, $label = 'payment_advice_header_line1'),
            'payment_advice_header_line2'   => RightPaddedStringColumnFactory::create( '', 105, $label = 'payment_advice_header_line2'),
            'filler'                        => RightPaddedStringColumnFactory::create('', 669, $label = 'filler')
        ];
        $line -> setColumns($columns);
        return $line;
    }

}
