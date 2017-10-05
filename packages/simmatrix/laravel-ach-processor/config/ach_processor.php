<?php
return [
    //copy the _example keys below and fill them in.

    'hsbc_example' => [
        'beneficiary_adapter' => \Chalcedonyt\COSPRocessor\Adapter\ExampleBeneficiaryAdapter::class,

        //File Header
        'file_format'                           => 'IFILE',
        'file_type'                             => 'CSV',
        'hexagon_abc_customer_id'               => '',
        'hsbcnet_id'                            => '',
        'file_version'                          => '1.0',

        //Batch Header
        'first_party_account'                   => '',
        'first_party_account_country_code'      => 'MY',
        'first_party_account_institution_code'  => 'HBMB',
        'first_party_account_currency'          => 'MYR',

        //COS (Txnal)
        //COS Details Record (ICD)
        'debit_acc_country'                     => 'MY',
        'debit_acc_institution'                 => 'HBMB',
        'debit_acc_number'                      => '',
        'debit_currency'                        => 'MYR',
        'instruction_currency'                  => 'MYR',
        'clearing_bank_country'                 => 'MY',
        'layout_template_id'                    => '',
        'drawing_location'                      => 'Penang',

        //beneficiary - record line
        'bene_country'                          => 'MY',

        //beneficiary - advising record line
        'domicile_of_email_recipient'           => 'MY'
    ],

    'uob_example' => [
        'beneficiary_adapter' => \Chalcedonyt\COSPRocessor\Adapter\ExampleBeneficiaryAdapter::class,

        //file header
        'company_id'                            => '',

        //beneficiary
        'payment_currency'                      => 'SGD',
        'beneficiary_countrycode'               => 'SG',
        'payment_currency'                      => 'SGD',
        'settlement_ac_no'                      => '',

        //for the generated file
        'filename_prefix'                       => 'UCPI'

    ]
];
?>
