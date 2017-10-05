<?php
return [
    //copy the _example keys below and fill them in.

    'hsbc_example' => [
        'beneficiary_adapter' => Adapter\MyBeneficiaryAdapter::class,

        //File Header
        'file_format'                           => 'IFILE',
        'file_type'                             => 'CSV',
        'hexagon_abc_customer_id'               => '1234',
        'hsbcnet_id'                            => '1234',
        'file_version'                          => '1.0',

        //Batch Header
        'first_party_account'                   => '1234',
        'first_party_account_country_code'      => 'MY',
        'first_party_account_institution_code'  => 'HBMB',
        'first_party_account_currency'          => 'MYR',

        //COS (Txnal)
        //COS Details Record (ICD)
        'debit_acc_country'                     => 'MY',
        'debit_acc_institution'                 => 'HBMB',
        'debit_acc_number'                      => '1234',
        'debit_currency'                        => 'MYR',
        'instruction_currency'                  => 'MYR',
        'clearing_bank_country'                 => 'MY',
        'layout_template_id'                    => '1234',
        'drawing_location'                      => 'Penang',

        //beneficiary - record line
        'bene_country'                          => 'MY',

        //beneficiary - advising record line
        'domicile_of_email_recipient'           => 'MY'
    ],

    'uob_example' => [
        'beneficiary_adapter' => Adapter\MyBeneficiaryAdapter::class,

        //file header
        'company_id'                            => '123456789012',

        //beneficiary
        'payment_currency'                      => 'SGD',
        'beneficiary_countrycode'               => 'SG',
        'payment_currency'                      => 'SGD',
        'settlement_ac_no'                      => '0123456789',
        'account_number'                        => '1234'

    ]
];
?>
