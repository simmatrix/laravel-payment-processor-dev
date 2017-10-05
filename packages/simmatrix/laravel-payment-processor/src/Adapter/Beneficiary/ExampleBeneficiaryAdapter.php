<?php
namespace Simmatrix\PaymentProcessor\Adapter\Beneficiary;

use Simmatrix\PaymentProcessor\Stringable;
use Simmatrix\PaymentProcessor\Exceptions\PaymentProcessorColumnException;

class ExampleBeneficiaryAdapter extends BeneficiaryAdapterAbstract implements BeneficiaryAdapterInterface
{
    /**
     * @param Model
     */
    public function __construct($model){
        $this -> model = $model;

        $this -> email = $model -> testUser -> email;
        $this -> fullname = strtoupper($model -> testUser -> fullname);

        //Map the user's full name to name1, name2, name3
        $name_parts = static::getStringParts($model -> testUser -> fullname);
        for( $i = 1; $i <= count($name_parts); $i++ ){
            if( !isset($name_parts[$i])) continue;
            $var = "name".$i;
            $this -> $var = $name_parts[$i-1];
        }

        //Map the user's address to address1, address2, address3
        $address_parts = static::getStringParts($model -> testUser -> address);
        for( $i = 1; $i <= count($address_parts); $i++ ){
            if( !isset($address_parts[$i])) continue;
            $var = "address".$i;
            $this -> $var = $address_parts[$i-1];
        }

        $this -> paymentAmount = $model -> amount;
        $this -> paymentDateTime = new \DateTime($model -> payment_date);
        $this -> paymentId = $model -> id;
        $this -> postcode = $model -> testUser -> postcode;
        $this -> title = $model -> testUser -> title;
        $this -> userId = $model -> testUser -> id;
    }

    /**
     * @return String
     * For HSBC.
     * "M" - Mr
     * "R" - Mrs
     * "S" - Ms
     * "O" - Other
     */
    public function getRecipientTitleFlag(){
        switch( strtoupper($this -> model -> title)){
            case "mr":
                return "M";
            case "mrs":
                return "R";
            case "ms":
                return "S";
            default:
                return "O";
        }
    }

    /**
     * @return String
     * A description for title flag, if the value was O.
     */
    public function getRecipientTitleDescription(){
        switch( strtoupper($this -> model -> title)){
            case "dr":
                return "Dr";
            default:
                return "";
        }
    }

    /**
     * @param String
     * @param Array
     */
    public static function getStringParts($string, $max_parts = 3){
        $max_length = 35;

        $string = strtoupper(str_replace(["\n", "\r\n", "\r"], "", $string));
        $wordwrapped = wordwrap($string, $max_length, '{}@', true);
        $string_parts = explode('{}@', $wordwrapped);

        if( count( $string_parts ) > $max_parts){
            throw new PaymentProcessorColumnException(sprintf("The string %s was too long", $string));
        }
        return $string_parts;
    }

}
