<?php

    namespace System\Exception {
        class WriteOnlyPropertyException extends \Exception {
            public function __construct( $propertyName, $code=0, \Exception $previous=null ) {
                parent::__construct("Attempted to read from a write-only property: '{$propertyName}'",$code);
            }
        }
    }