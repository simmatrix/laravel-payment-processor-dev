<?php

namespace Simmatrix\PaymentProcessor\Line;

use Simmatrix\PaymentProcessor\Stringable;
use Simmatrix\PaymentProcessor\BeneficiaryLines;
use Simmatrix\PaymentProcessor\Adapter\Beneficiary\BeneficiaryAdapterInterface;

abstract class Header extends Line implements Stringable
{
    /**
     * @var Array of BeneficiaryAdapterInterface
     */
    protected $beneficiaries;

    protected $batchHeaderHeight = 1;

    /**
     * How many lines make up a beneficiary entry
     * @var int
     */
    protected $beneficiaryLineHeight = 1;

    protected $fileHeaderHeight = 1;

    /**
     * @param Array of BeneficiaryAdapterInterface
     * @param String The key to read the config from
     */
    public function __construct( array $beneficiaries, $config_key){
        $this -> beneficiaries = $beneficiaries;
        parent::__construct($config_key);
    }

    /**
     * @return int
     */
    public function getBeneficiaryCount(){
        return count($this -> beneficiaries);
    }

    /**
     * Get the number of lines that make up a BeneficiaryLines entry.
     * @return int
     */
    public function getBeneficiaryLineHeight(){
        return $this -> beneficiaryLineHeight;
    }

    /**
     * @return String
     */
    public function getString(){
        $line = $this -> getLine();
        return $line -> getString();
    }
    /**
     * @return int
     */
    public function getTotalLines(){
        //assumes
        return $this -> fileHeaderHeight
        + $this -> batchHeaderHeight
        + ($this -> getBeneficiaryCount() * $this -> getBeneficiaryLineHeight() );
    }

    /**
     * @return float
     */
    public function getTotalPaymentAmount(){
        return (float)collect($this -> beneficiaries) -> reduce( function($carry,  BeneficiaryAdapterInterface $beneficiary){

            return $carry += $beneficiary -> getPaymentAmount();
        }, 0);
    }
}
