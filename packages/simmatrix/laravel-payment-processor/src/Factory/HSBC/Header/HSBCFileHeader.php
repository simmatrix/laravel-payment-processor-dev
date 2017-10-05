<?php

namespace Simmatrix\PaymentProcessor\Factory\HSBC\Header;

use Simmatrix\PaymentProcessor\Line\Line;
use Simmatrix\PaymentProcessor\Beneficiary;
use Simmatrix\PaymentProcessor\BeneficiaryLines;
use Simmatrix\PaymentProcessor\Column\Date;
use Simmatrix\PaymentProcessor\Factory\Column\ConfigurableStringColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\EmptyColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\LeftPaddedDecimalWithoutDelimiterColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\PresetStringColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\RightPaddedStringColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\VariableLengthStringColumnFactory;

class HSBCFileHeader extends \Simmatrix\PaymentProcessor\Line\Header
{
    const FILE_REFERENCE_PREFIX = 'IFILEPYT_';

    /**
     * How many lines make up a beneficiary entry
     * @var int
     */
    protected $beneficiaryLineHeight = 3;
    
    /**
     * @return Line
     */
    public function getLine(){
        $line = new Line();
        $columns = [
            'record_type'               => PresetStringColumnFactory::create('IFH', $label = 'record_type'),
            'file_format'               => ConfigurableStringColumnFactory::create($config = $this -> config, 'file_format', $label = 'file_format'),
            'file_type'                 => ConfigurableStringColumnFactory::create($config = $this -> config, 'file_type', $label = 'file_type'),
            'hexagon_abc_customer_id'   => ConfigurableStringColumnFactory::create($config = $this -> config, 'hexagon_abc_customer_id', $label = 'hexagon_abc_customer_id'),
            'hsbcnet_id'                => ConfigurableStringColumnFactory::create($config = $this -> config, 'hsbcnet_id', $label = 'hsbcnet_id'),
            'file_reference'            => VariableLengthStringColumnFactory::create($this -> getFileReference(), 35, $label = 'file_reference'),
            'file_creation_date'        => VariableLengthStringColumnFactory::create(date('Y/m/d'), 10, $label = 'file_creation_date'),
            'file_creation_time'        => VariableLengthStringColumnFactory::create(date('H:i:s'), 8, $label = 'file_creation_time'),
            'authorization_type'        => PresetStringColumnFactory::create('P', $label = 'authorization_type'),
            'file_version'              => ConfigurableStringColumnFactory::create($config = $this -> config, 'file_version', $label = 'file_version'),
            'record_count'              => VariableLengthStringColumnFactory::create($this -> getTotalLines(), 7 , $label = 'record_count'),
        ];
        $line -> setColumns($columns);
        return $line;
    }

    /**
     * @return String
     */
    public function getFileReference(){
        //fix to the current minute
        $time = strtotime(date('Y-m-d H:i:00'));
        return self::FILE_REFERENCE_PREFIX.$time;
    }

}
