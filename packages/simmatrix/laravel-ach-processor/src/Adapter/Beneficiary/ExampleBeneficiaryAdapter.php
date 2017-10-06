<?php
namespace Simmatrix\PaymentProcessor\Adapter\Beneficiary;

use Simmatrix\PaymentProcessor\Stringable;
use Simmatrix\PaymentProcessor\Exceptions\PaymentProcessorColumnException;

class ExampleBeneficiaryAdapter extends BeneficiaryAdapterAbstract implements BeneficiaryAdapterInterface
{
    /**
     * @param Model The Laravel model for the beneficiary record
     */
    public function __construct($model)
    {
        $this -> model = $model;

        $this -> userId = $model -> testUser -> id;
        $this -> paymentAmount = $model -> amount;
        $this -> accountNumber = $model -> testUser -> accountNumber;
        $this -> payeeName = strtoupper( $model -> testUser -> fullname );
        $this -> secondPartyReference = $model -> testUser -> icNumber;
    }
}
