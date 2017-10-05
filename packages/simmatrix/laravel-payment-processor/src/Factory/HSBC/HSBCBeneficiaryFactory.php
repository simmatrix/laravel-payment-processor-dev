<?php

namespace Simmatrix\PaymentProcessor\Factory\HSBC;

use Simmatrix\PaymentProcessor\Line\Line;
use Simmatrix\PaymentProcessor\Beneficiary;
use Simmatrix\PaymentProcessor\BeneficiaryLines;
use Simmatrix\PaymentProcessor\Adapter\Beneficiary\BeneficiaryAdapterInterface;
use Simmatrix\PaymentProcessor\Factory\Column\EmptyColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\PresetStringColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\VariableLengthStringColumnFactory;
use Simmatrix\PaymentProcessor\Factory\Column\ConfigurableStringColumnFactory;

class HSBCBeneficiaryFactory
{
    /**
     * @var an Eloquent Model
     */
    protected $model;
    /**
     * @param BeneficiaryAdapterInterface
     * @param String The key to read the config from
     * @return BeneficiaryLines
     */
    public static function create(BeneficiaryAdapterInterface $beneficiary, $config_key){
        $beneficiary_lines = new BeneficiaryLines($beneficiary);

        $beneficiary_lines -> addLine(static::createCOSDetailsRecordLine($beneficiary, $config_key));
        $beneficiary_lines -> addLine(static::createBeneficiaryRecordLine($beneficiary, $config_key));
        $beneficiary_lines -> addLine(static::createAdvisingRecordLine($beneficiary, $config_key));
        return $beneficiary_lines;
    }

    /**
     * @param BeneficiaryAdapterInterface
     * @param String The key to read the config from
     */
    public static function createCOSDetailsRecordLine(BeneficiaryAdapterInterface $beneficiary, $config_key ){
        $line = new Line($config_key);

        $columns = [
            'record_type'                       => PresetStringColumnFactory::create('COS', $label = 'record_type'),
            'batch_instruction_indicator'       => PresetStringColumnFactory::create('I', $label = 'batch_instruction_indicator'),
            'payment_type'                      => PresetStringColumnFactory::create('ICO', $label = 'payment_type'),
            'debit_acc_country'                 => ConfigurableStringColumnFactory::create( $config = $line -> config, 'debit_acc_country', $label = 'debit_acc_country'),
            'debit_acc_institution'             => ConfigurableStringColumnFactory::create( $config = $line -> config, 'debit_acc_institution', $label = 'debit_acc_institution'),
            'debit_acc_number'                  => ConfigurableStringColumnFactory::create( $config = $line -> config, 'debit_acc_number', $label = 'debit_acc_number'),
            'debit_acc_product_type'            => EmptyColumnFactory::create($label = 'debit_acc_product_type'),
            'debit_currency'                    => ConfigurableStringColumnFactory::create( $config = $line -> config, 'debit_currency', $label = 'debit_currency'),
            'instruction_currency'              => ConfigurableStringColumnFactory::create( $config = $line -> config, 'instruction_currency', $label = 'instruction_currency'),
            'instrument_amount'                 => VariableLengthStringColumnFactory::create( $beneficiary -> getPaymentAmount(), $max_length= 20, $label = 'instrument_amount'),
            'instrument_amount_debit_currency'  => EmptyColumnFactory::create( $label = 'instrument_amount_debit_currency'),
            'instrument_date'                   => EmptyColumnFactory::create( $label = 'instrument_date'),
            'clearing_bank_country'             => ConfigurableStringColumnFactory::create( $config = $line -> config, 'clearing_bank_country', $label = 'clearing_bank_country'),
            'customer_reference'                => VariableLengthStringColumnFactory::create($beneficiary -> getPaymentId(), $max_length = 35, $label = 'customer_reference'),
            'layout_template_id'                => ConfigurableStringColumnFactory::create( $config = $line -> config, 'layout_template_id', $label = 'layout_template_id'),
            'bene_id'                           => EmptyColumnFactory::create( $label = 'bene_id'),
            'payment_details'                   => EmptyColumnFactory::create( $label = 'payment_details', $label = 'payment_details'),
            'remarks_1'                         => EmptyColumnFactory::create( $label = 'remarks_1', $label = 'remarks_1'),
            'remarks_2'                         => EmptyColumnFactory::create( $label = 'remarks_2', $label = 'remarks_2'),
            'deduction_charge_flag'             => PresetStringColumnFactory::create('C', $label = 'deduction_charge_flag'),
            'show_order_customer_flag'          => PresetStringColumnFactory::create('Y', $label = 'show_order_customer_flag'),
            'override duplication_flag'         => PresetStringColumnFactory::create('N', $label = 'override duplication_flag'),
            'number_of_recipients'              => PresetStringColumnFactory::create('1', $label = 'number_of_recipients'),
            'first_contract_number'             => EmptyColumnFactory::create( $label = 'first_contract_number'),
            'first_contract_takeup_amount'      => EmptyColumnFactory::create( $label = 'first_contract_takeup_amount'),
            'second_contract_number'            => EmptyColumnFactory::create( $label = 'second_contract_number'),
            'second_contract_takeup_amount'     => EmptyColumnFactory::create( $label = 'second_contract_takeup_amount'),
            'key_in_rate'                       => EmptyColumnFactory::create( $label = 'key_in_rate'),
            'dealer_reference'                  => EmptyColumnFactory::create( $label = 'dealer_reference'),
            'exchange_control'                  => EmptyColumnFactory::create( $label = 'exchange_control'),
            'drawee_bank_country'               => EmptyColumnFactory::create( $label = 'drawee_bank_country'),
            'drawee_bank_branch'                => EmptyColumnFactory::create( $label = 'drawee_bank_branch'),
            'dd_purpose_of_payment_1'           => EmptyColumnFactory::create( $label = 'dd_purpose_of_payment_1'),
            'dd_purpose_of_payment_2'           => EmptyColumnFactory::create( $label = 'dd_purpose_of_payment_2'),
            'signature_id_1'                    => EmptyColumnFactory::create( $label = 'signature_id_1'),
            'signature_id_2'                    => EmptyColumnFactory::create( $label = 'signature_id_2'),
            'signature_id_3'                    => EmptyColumnFactory::create( $label = 'signature_id_3'),
            'template_id'                       => EmptyColumnFactory::create( $label = 'template_id'),
            'template_record_type'              => EmptyColumnFactory::create( $label = 'template_record_type'),
            'template_description'              => EmptyColumnFactory::create( $label = 'template_description'),
            'payment_code'                      => EmptyColumnFactory::create( $label = 'payment_code'),
            'payment_info_1'                    => EmptyColumnFactory::create( $label = 'payment_info_1'),
            'payment_info_2'                    => EmptyColumnFactory::create( $label = 'payment_info_2'),
            'payment_info_3'                    => EmptyColumnFactory::create( $label = 'payment_info_3'),
            'drawing_location'                  => ConfigurableStringColumnFactory::create($config = $line -> config, 'drawing_location', $label = 'drawing_location'),
        ];
        $line -> setColumns($columns);
        return $line;
    }

    /**
     * The Beneficiary Information Record
     * @param Beneficiary
     * @param String The key to read the config from
     * @return Line a line
     */
    public static function createBeneficiaryRecordLine(BeneficiaryAdapterInterface $beneficiary, $config_key){
        $line = new Line($config_key);

        $columns = [
            'record_type'                           => PresetStringColumnFactory::create('COS-BEN', $label = 'record_type'),
            'template_indicator'                    => PresetStringColumnFactory::create('I', $label = 'template_indicator'),
            'action_code'                           => EmptyColumnFactory::create( $label = 'action_code'),
            'bene_id'                               => EmptyColumnFactory::create( $label = 'bene_id'),
	        'bene_name'                             => VariableLengthStringColumnFactory::create($beneficiary -> getFullname(), $max_length = 100 , $label = 'bene_name'),
            'bene_address_1'                        => VariableLengthStringColumnFactory::create( $beneficiary -> getAddress1(), $max_length = 40, $label = 'bene_address_1'),
            'bene_address_2'                        => VariableLengthStringColumnFactory::create( $beneficiary -> getAddress2(), $max_length = 40, $label = 'bene_address_2'),
            'bene_address_3'                        => VariableLengthStringColumnFactory::create( $beneficiary -> getAddress3(), $max_length = 40, $label = 'bene_address_3'),
            'bene_address_4'                        => VariableLengthStringColumnFactory::create( '', $max_length = 40, $label = 'bene_address_4'),
            'bene_address_5'                        => VariableLengthStringColumnFactory::create( '', $max_length = 40, $label = 'bene_address_5'),
            'bene_zipcode'                          => VariableLengthStringColumnFactory::create( $beneficiary -> getPostcode(), $max_length = 20, $label = 'bene_zipcode'),
            'bene_country'                          => ConfigurableStringColumnFactory::create($config = $line -> config, 'bene_country', $label = 'bene_country'),
            'payee_name'                            => EmptyColumnFactory::create( $label = 'payee_name'),
            'delivery_to_cc'                        => EmptyColumnFactory::create( $label = 'delivery_to_cc'),
            'third_party_name__cc'                  => EmptyColumnFactory::create( $label = 'third_party_name__cc'),
            'third_party_add_1_cc'                  => EmptyColumnFactory::create( $label = 'third_party_add_1_cc'),
            'third_party_add_2_cc'                  => EmptyColumnFactory::create( $label = 'third_party_add_2_cc'),
            'third_party_add_3_cc'                  => EmptyColumnFactory::create( $label = 'third_party_add_3_cc'),
            'third_party_add_4_cc'                  => EmptyColumnFactory::create( $label = 'third_party_add_4_cc'),
            'third_party_add_5_cc'                  => EmptyColumnFactory::create( $label = 'third_party_add_5_cc'),
	        'third_party_zipcode_cc'                => EmptyColumnFactory::create( $label = 'third_party_zipcode_cc'),
            'third_party_countryname_cc'            => EmptyColumnFactory::create( $label = 'third_party_countryname_cc'),
	        'delivery_to'                           => PresetStringColumnFactory::create('B', $label = 'delivery_to'),
            'third_party_name'                      => EmptyColumnFactory::create( $label = 'third_party_name'),
            'third_party_add_a1'                    => EmptyColumnFactory::create( $label = 'third_party_add_a1'),
            'third_party_add_a2'                    => EmptyColumnFactory::create( $label = 'third_party_add_a2'),
            'third_party_add_a3'                    => EmptyColumnFactory::create( $label = 'third_party_add_a3'),
            'third_party_add_a4'                    => EmptyColumnFactory::create( $label = 'third_party_add_a4'),
            'third_party_add_a5'                    => EmptyColumnFactory::create( $label = 'third_party_add_a5'),
            'third_party_zipcode_a'                 => EmptyColumnFactory::create( $label = 'third_party_zipcode_a'),
	        'third_party_country_name_a'            => EmptyColumnFactory::create( $label = 'third_party_country_name_a'),
            'delivery_mode'                         => PresetStringColumnFactory::create('O', $label = 'delivery_mode')
        ];

        $line -> setColumns($columns);
        return $line;
    }

    /**
     * @param BeneficiaryAdapterInterface
     * @param String The key to read the config from
     * @return Line a line
     */
    public static function createAdvisingRecordLine(BeneficiaryAdapterInterface $beneficiary, $config_key){
        $line = new Line($config_key);

        $columns = [
            'record_type'                           => PresetStringColumnFactory::create('ADV', $label = 'record_type'),
            'advice_recepient_id'                   => EmptyColumnFactory::create( $label = 'advice_recepient_id'),
            'action_flag'                           => EmptyColumnFactory::create( $label = 'action_flag'),
            'recipient_template_desc'               => EmptyColumnFactory::create( $label = 'recipient_template_desc'),
            'user_id'                               => EmptyColumnFactory::create( $label = 'user_id'),
            'user_first_name'                       => EmptyColumnFactory::create( $label = 'user_first_name'),
            'user_last_name'                        => EmptyColumnFactory::create( $label = 'user_last_name'),
            'number_of_recipient'                   => PresetStringColumnFactory::create('1', $label = 'number_of_recipient'),
            'recipient_item_no'                     => PresetStringColumnFactory::create('1', $label = 'recipient_item_no'),
            'recipient_name'                        => VariableLengthStringColumnFactory::create( $beneficiary -> getFullname(), $max_length = 600 , $label = 'recipient_name'),
            'recipient_title'                       => VariableLengthStringColumnFactory::create( $beneficiary -> getRecipientTitleFlag(), 1, $label = 'recipient_title'),
            'recipient_title_desc'                  => EmptyColumnFactory::create( $beneficiary -> getRecipientTitleDescription(), $label = 'recipient_title_desc'),
            'action_code'                           => EmptyColumnFactory::create( $label = 'action_code'),
            'template_id'                           => EmptyColumnFactory::create( $label = 'template_id'),
            'template_status'                       => EmptyColumnFactory::create( $label = 'template_status'),
            'template_timetamp'                     => EmptyColumnFactory::create( $label = 'template_timetamp'),
            'advice_format'                         => PresetStringColumnFactory::create('F', $label = 'advice_format'),
            'email_channel_select_flag'             => PresetStringColumnFactory::create('Y', $label = 'email_channel_select_flag'),
            'email_format'                          => PresetStringColumnFactory::create('1', $label = 'email_format'),
            'email_address'                         => VariableLengthStringColumnFactory::create( $beneficiary -> getEmail(), $max_length = 70 , $label = 'email_address'),
            'alternate_email_address'               => EmptyColumnFactory::create( $label = 'alternate_email_address'),
            'domicile_of_email_recipient'           => ConfigurableStringColumnFactory::create( $config = $line -> config, 'domicile_of_email_recipient', $label = 'domicile_of_email_recipient'),
        ];
        $line -> setColumns($columns);
        return $line;
    }

    /**
     * The Payment Details Table Row Content record
     * @param BeneficiaryAdapterInterface
     * @param String The key to read the config from
     * @return Line a line
     */
    public static function createPaymentDetailsTableRowContentRecordLine(BeneficiaryAdapterInterface $beneficiary, $config_key){
        $line = new Line($config_key);

        $columns = [
            'record_type'                           => PresetStringColumnFactory::create('COS-TBL', $label = 'record_type'),
            'instruction_indicator'                 => PresetStringColumnFactory::create('I', $label = 'instruction_indicator'),
            'table_name_id'                         => ConfigurableStringColumnFactory::create( $config = $line -> config, 'table_name_id', $label = 'table_name_id'),
            'table_col_1'                           => VariableLengthStringColumnFactory::create( $beneficiary -> getUserId(), $max_length = 90, $label = 'table_col_1'),
            'table_col_2'                           => VariableLengthStringColumnFactory::create( $beneficiary -> getPaymentId(), $max_length = 90 , $label = 'table_col_2'),
            'table_col_3'                           => VariableLengthStringColumnFactory::create( $beneficiary -> getPaymentDateTimeFormatted(), $max_length = 90 , $label = 'table_col_3'),
            'table_col_4'                           => VariableLengthStringColumnFactory::create( $beneficiary -> getEmail(), $max_length = 90 , $label = 'table_col_4'),
            //legacy - used to be for exclusivity
            'table_col_5'                           => VariableLengthStringColumnFactory::create( "1", $max_length = 90 , $label = 'table_col_5'),
            'table_col_6'                           => VariableLengthStringColumnFactory::create( $beneficiary -> getFullname(), $max_length = 90 , $label = 'table_col_6')
        ];
        $line -> setColumns($columns);
        return $line;
    }


}
