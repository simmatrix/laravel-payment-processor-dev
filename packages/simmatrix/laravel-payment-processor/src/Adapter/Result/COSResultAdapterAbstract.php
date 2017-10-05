<?php
namespace Simmatrix\PaymentProcessor\Adapter\Result;

abstract class COSResultAdapterAbstract
{
    /**
     * @var COSResult
     */
    protected $cosResult;

    /**
     * @var String
     */
    protected $columnDelimiter = ',';

    /**
     * @var Array
     */
    protected $columns = [];

    /**
     * @var String
     */
    public function __construct($string){
        $this -> columns = explode( $this -> columnDelimiter, $string);
    }

    /**
     * @return COSResult
     */
    public function getCosResult(){
        return $this -> cosResult;
    }
}
