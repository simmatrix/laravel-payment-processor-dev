<?php
namespace Simmatrix\PaymentProcessor\Adapter\Beneficiary;

use Simmatrix\PaymentProcessor\Stringable;

abstract class BeneficiaryAdapterAbstract implements BeneficiaryAdapterInterface
{
    protected $model;
    protected $address1;
    protected $address2;
    protected $address3;

    protected $email;
    protected $fullname;
    protected $name1;
    protected $name2;
    protected $name3;

    protected $paymentAmount;
    protected $paymentDateTime;
    protected $paymentId;
    protected $postcode;

    //e.g. Mr, Ms
    protected $title;
    protected $userId;

    /**
     * @param model
     */
    abstract public function __construct($model);

    /**
     * @return String
     */
    public function getAddress1(){
        return $this -> address1;
    }
    /**
     * @return String
     */
    public function getAddress2(){
        return $this -> address2;
    }
    /**
     * @return String
     */
    public function getAddress3(){
        return $this -> address3;
    }

    /**
     * @return String
     */
    public function getEmail(){
        return $this -> email;
    }
    //Used for HSBC
    /**
     * @return String
     */
    public function getFullname(){
        return $this -> fullname;
    }
    //Used for UOB
    /**
     * @return String
     */
    public function getName1(){
        return $this -> name1;
    }
    /**
     * @return String
     */
    public function getName2(){
        return $this -> name2;
    }
    /**
     * @return String
     */
    public function getName3(){
        return $this -> name3;
    }
    /**
     * @return String
     */
    public function getPaymentAmount(){
        return $this -> paymentAmount;
    }
    /**
     * @return String
     */
    public function getPaymentDateTimeFormatted(){
        return $this -> paymentDateTime -> format('Ymd');
    }

    /**
     * @return String
     */
    public function getPaymentId(){
        return $this -> paymentId;
    }

    /**
     * @return String
     */
    public function getPostcode(){
        return $this -> postcode;
    }

    public function getTitle(){
        return $this -> title;
    }
    /**
     * @return String
     */
    public function getUserId(){
        return $this -> userId;
    }

}
