<?php

return [

    'hsbc' => [

        'company_a' => [

            'beneficiary_adapter' => \Simmatrix\ACHProcessor\Adapter\ExampleBeneficiaryAdapter::class,

            // Batch Header Record
            'country_code' => 'MY',                     // maximum length: 2
            'first_party_account_branch' => 123,        // maximum length: 3
            'first_party_account_serial' => 123456,     // maximum length: 6
            'first_party_account_suffix' => 001,        // maximum length: 3
            'payment_description' => 'SALARY NOV2017',  // maximum length: 24

            // Data Record
            'autopay_currency' => 'MYR',                // maximum length: 3
            'payment_currency' => 'MYR',                // maximum length: 3

        ],

        // If you have a subsidiary company, you can copy the structure of the key above
        'company_b' => [

            'beneficiary_adapter' => \Simmatrix\ACHProcessor\Adapter\ExampleBeneficiaryAdapter::class,

            // Batch Header Record
            'country_code' => 'MY',                     // maximum length: 2
            'first_party_account_branch' => 123,        // maximum length: 3
            'first_party_account_serial' => 123456,     // maximum length: 6
            'first_party_account_suffix' => 001,        // maximum length: 3

            // Data Record
            'autopay_currency' => 'MYR',                // maximum length: 3
            'payment_currency' => 'MYR',                // maximum length: 3

        ],

    ],

    'uob' => [

        'company_a' => [

            'beneficiary_adapter' => \Simmatrix\ACHProcessor\Adapter\ExampleBeneficiaryAdapter::class,

        ],

        'company_b' => [

            'beneficiary_adapter' => \Simmatrix\ACHProcessor\Adapter\ExampleBeneficiaryAdapter::class,

        ],

    ]

];

?>
