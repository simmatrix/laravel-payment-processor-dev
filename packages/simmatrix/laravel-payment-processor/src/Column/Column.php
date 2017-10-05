<?php
namespace Simmatrix\PaymentProcessor\Column;

use Simmatrix\PaymentProcessor\Stringable;
use Simmatrix\PaymentProcessor\Exceptions\PaymentProcessorColumnException;

class Column implements Stringable
{
    const PADDING_NONE = 'padding_none';
    //pads with zeros from the left. E.g. the value "2" with a length of 3 will result in "002"
    const PADDING_ZEROFILL_LEFT = 'padding_zerofill_left';
    //pads with spaces to the right. E.g. the value "2" with a length of 3 will result in "2  "
    const PADDING_RIGHT = 'padding_spaces_right';

    /**
     *
     */
    protected $contentType;

    /**
     * @var mixed The default value for this column.
     */
    protected $defaultValue;

    /**
     * @var int The fixed length of the value
     */
    protected $fixedLength = null;

    /**
     * @var String An optional label that is used for error messages.
     */
    protected $label = null;

    /**
     * @var int The maximum length of the value
     */
    protected $maxLength = null;

    /**
     * @var String
     */
    protected $paddingType = self::PADDING_NONE;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @return mixed
     */
    public function getPaddedValue($value){
        if( $this -> fixedLength == null && $this -> paddingType !== self::PADDING_NONE ){
            throw new PaymentProcessorColumnException(sprintf("Padding %s was set for the column %s, but no fixedLength was set.", $this -> paddingType, __CLASS__));
        }
        switch($this -> paddingType){
            case self::PADDING_ZEROFILL_LEFT:
                return str_pad($value, $this -> fixedLength, "0", STR_PAD_LEFT);
            case self::PADDING_RIGHT:
                return str_pad($value, $this -> fixedLength);
            default:
                return $value;
        }
    }

    /**
     * @return mixed
     */
    public function getString(){
        $value = null;
        if( $this -> value === null ){
            if( $this -> defaultValue !== null ){
                $value = $this -> defaultValue;
            }
        } else{
            $value = $this -> value;
        }
        return $this -> getPaddedValue($value);
    }

    /**
     * @var mixed
     */
    public function setDefaultValue($default_value){
        $this -> defaultValue = $default_value;
    }
    /**
     * @param int
     */
    public function setFixedLength($length = 0)
    {
        $this -> fixedLength = $length;
    }

    /**
     * @return String
     */
    public function getLabel(){
        return $this -> label;
    }
    /**
     * @param String
     */
    public function setLabel($label){
        $this -> label = $label;
    }

    /**
     * @param int
     */
    public function setMaxLength($length = 0)
    {
        $this -> maxLength = $length;
    }

    /**
     * Sets the padding behaviour
     */
    public function setPaddingType($padding_type){
        $padding_types = [self::PADDING_NONE, self::PADDING_ZEROFILL_LEFT, self::PADDING_RIGHT];
        if( !in_array($padding_type, $padding_types)){
            if( $this -> label )
                throw new PaymentProcessorColumnException(sprintf('Invalid padding type for the column %s - choose from %s', $this -> label, implode(',', $padding_types)));
            else throw new PaymentProcessorColumnException(sprintf('Invalid padding type - choose from %s', implode(',', $padding_types)));
        }
        $this -> paddingType = $padding_type;
    }

    /**
     * @param mixed
     */
    public function setValue($value){
        //set the max length to either maxLength or fixedLength
        $max_length = ($this -> maxLength) ? $this -> maxLength : ($this -> fixedLength ? $this -> fixedLength : null );
        if( $max_length !== null && strlen((string)$value) > $max_length ){
            if( $this -> label )
                throw new PaymentProcessorColumnException(sprintf("Invalid length for the column %s (%s) - the max length for %s was %d", $this -> label, (string)$value, __CLASS__, $max_length));
            else throw new PaymentProcessorColumnException(sprintf("Invalid length for %s - the max length for %s was %d", (string)$value, __CLASS__, $max_length));
        }
        $this -> value = $value;
    }
}
