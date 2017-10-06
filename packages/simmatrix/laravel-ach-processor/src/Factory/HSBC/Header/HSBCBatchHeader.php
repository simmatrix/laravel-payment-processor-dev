<?php

namespace Simmatrix\PaymentProcessor\Factory\HSBC\Header;

use Simmatrix\PaymentProcessor\Line\Line;
use Simmatrix\PaymentProcessor\Stringable;
use Simmatrix\PaymentProcessor\Beneficiary;
use Simmatrix\PaymentProcessor\BeneficiaryLines;
use Simmatrix\PaymentProcessor\Column\Date;
use Simmatrix\PaymentProcessor\Factory\Column\ConfigurableStringColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\EmptyColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\LeftPaddedDecimalWithoutDelimiterColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\LeftPaddedZerofillStringColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\PresetStringColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\RightPaddedStringColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\VariableLengthStringColumnFactory;


class HSBCBatchHeader extends \Simmatrix\PaymentProcessor\Line\Header implements Stringable
{
    const FIRST_PARTY_RECORD_TYPE = 1; // 1 stands for first party
    const GROUP_MEMBER = 'HSBC';
    const PAYMENT_SET_NUMBER = 'C01';
    const PAYMENT_TYPE = 'APO'; // Auto Pay Out, means debit 1st party, credit 2nd party
    const PAYMENT_SET_MAINTENANCE_MODE = ''; // to be left blank, indicating no checking would be done
    const HEXAGON_CUSTOMER_ID = ''; // For EBS Payment
    const HEXAGON_ACCOUNT_ID = '';
    const RESERVED = '';
    const AUTOPLAN_TYPE = 1;

    /**
     * @param Beneficiary
     * @return BeneficiaryLines
     */
    public function getLine(){
        $line = new Line();
        $columns = [
            'record_type'                       => PresetStringColumnFactory::create(SELF::FIRST_PARTY_RECORD_TYPE, $label = 'record_type'),
            'country_code'                      => ConfigurableStringColumnFactory::create($this -> config, $config_key = 'country_code', $label = 'country_code', $maximum_length = 2),
            'group_member'                      => PresetStringColumnFactory::create(SELF::GROUP_MEMBER, $label = 'group_member'),
            'first_party_account_branch'        => ConfigurableStringColumnFactory::create($this -> config, $config_key = 'first_party_account_branch', $label = 'first_party_account_branch', $maximum_length = 3),
            'first_party_account_serial'        => ConfigurableStringColumnFactory::create($this -> config, $config_key = 'first_party_account_serial', $label = 'first_party_account_serial', $maximum_length = 6),
            'first_party_account_suffix'        => ConfigurableStringColumnFactory::create($this -> config, $config_key = 'first_party_account_suffix', $label = 'first_party_account_suffix', $maximum_length = 3),
            // 'payment_set_number'                => PresetStringColumnFactory::create(SELF::PAYMENT_SET_NUMBER, $label = 'payment_set_number'),
            'batch_count_total'                 => LeftPaddedZerofillStringColumnFactory::create($this -> getBeneficiaryCount(), $max_length = 6, $label = 'batch_count_total'),
            'batch_amount_hash_total'           => LeftPaddedZerofillStringColumnFactory::create(number_format($this -> getTotalPaymentAmount(), 2), $max_length = 17, $label = 'batch_amount_hash_total'),
            // 'date_next_payment'                 =>
            'payment_type'                      => PresetStringColumnFactory::create(SELF::PAYMENT_TYPE, $label = 'payment_type'),
            'payment_description'               => RightPaddedStringColumnFactory::create($this -> config, $config_key = 'payment_description', $label = 'payment_description', $maximum_length = 24),
            'payment_set_maintenance_mode'      => RightPaddedStringColumnFactory::create(SELF::PAYMENT_SET_MAINTENANCE_MODE, $length = 1, $label = 'payment_set_maintenance_mode'),
            'hexagon_customer_id'               => RightPaddedStringColumnFactory::create(SELF::HEXAGON_CUSTOMER_ID, $length = 12, $label = 'hexagon_customer_id'),
            'hexagon_account_id'                => RightPaddedStringColumnFactory::create(SELF::HEXAGON_ACCOUNT_ID, $length = 4, $label = 'hexagon_account_id'),
            'reserved'                          => RightPaddedStringColumnFactory::create(SELF::RESERVED, $length = 37, $label = 'reserved'),
            'autoplan_type'                     => PresetStringColumnFactory::create(SELF::AUTOPLAN_TYPE, $label = 'autoplan_type'),
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
