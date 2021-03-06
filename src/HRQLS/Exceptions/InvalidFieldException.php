<?php
/**
 * Defines a custom exception thrown by the HRQLS framework.
 *
 * @package HRQLS\Exceptions
 */
 
namespace HRQLS\Exceptions;
 
 /**
  * Defines the custom InvalidFieldException class.
  * This exception should be thrown when a user tries to access a field in an associative array that does not exist.
  */
class InvalidFieldException extends \Exception
{
    /**
     * Constructs a new InvalidFieldException object.
     *
     * @param string    $message  The message describinng why the exception occured.
     * @param integer   $code     The error code for this specific error. Defaults to 0.
     * @param Exception $previous The previous exception that caused this exception.
     */
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
     
    /**
     * Canonocalizes InvalidFieldException for easier human readable output.
     *
     * @return string The error code and error message concatenated into a string.
     */
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
