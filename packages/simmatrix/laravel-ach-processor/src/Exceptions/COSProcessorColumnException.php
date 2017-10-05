<?php namespace Simmatrix\PaymentProcessor\Exceptions;

class PaymentProcessorColumnException extends \Exception
{
	public function __construct($message = null, $code = 0, Exception $previous = null)
	{
		parent::__construct( $message, $code, $previous );

	}
}
?>
