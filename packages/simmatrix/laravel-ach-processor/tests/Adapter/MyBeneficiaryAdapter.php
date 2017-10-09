<?php
namespace Adapter;

use Simmatrix\PaymentProcessor\Stringable;
use Simmatrix\PaymentProcessor\Exceptions\ACHProcessorColumnException;
use Simmatrix\PaymentProcessor\Adapter\Beneficiary\BeneficiaryAdapterAbstract;
use Simmatrix\PaymentProcessor\Adapter\Beneficiary\BeneficiaryAdapterInterface;

class MyBeneficiaryAdapter extends BeneficiaryAdapterAbstract implements BeneficiaryAdapterInterface
{
    /**
     * @param Model
     */
    public function __construct($model)
    {
        $this -> model = $model;
        $this -> userId = $model -> testUser -> id;
        $this -> paymentAmount = $model -> amount;
        $this -> accountNumber = $model -> testUser -> accountNumber;
        $this -> payeeName = strtoupper($model -> testUser -> fullname);
        $this -> secondPartyReference = $model -> testUser -> icNumber;
    }
}
