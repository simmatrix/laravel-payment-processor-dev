<?php

namespace Simmatrix\PaymentProcessor\Factory\UOB\Header;

use Simmatrix\PaymentProcessor\Line\Line;
use Simmatrix\PaymentProcessor\Line\Header;
use Simmatrix\PaymentProcessor\Beneficiary;
use Simmatrix\PaymentProcessor\BeneficiaryLine;
use Simmatrix\PaymentProcessor\Column\Date;
use Simmatrix\PaymentProcessor\Factory\Column\ConfigurableStringColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\EmptyColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\LeftPaddedDecimalWithoutDelimiterColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\LeftPaddedZerofillStringColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\PresetStringColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\RightPaddedStringColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\VariableLengthStringColumnFactory;

/**
 * For UOB, a batch trailer comes at the end of the file.
 */
class UOBBatchTrailer extends Header
{
    protected $columnDelimiter = "";

    /**
     * @return Line
     */
    public function getLine(){
        $line = new Line();
        $line -> setColumnDelimiter("");
        $columns = [
            'record_type'       => PresetStringColumnFactory::create('9', $label = 'record_type'),
            'no_trans'          => LeftPaddedZerofillStringColumnFactory::create( $this -> getBeneficiaryCount(), $length = 8, $label = 'no_trans'),
            'ttl_payment_amt'   => LeftPaddedDecimalWithoutDelimiterColumnFactory::create( $this -> getTotalPaymentAmount(), $length = 15 , $label = 'ttl_payment_amt'),
            'filler'            => RightPaddedStringColumnFactory::create('', $length = 876 , $label = 'filler')
        ];
        $line -> setColumns($columns);
        return $line;
    }

}
