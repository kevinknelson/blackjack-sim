<?php

    namespace Model\Event {
        use Closure;

        class ShoeRefillEvent {
            private static $_instance;
            private $_listeners;

            public static function instance() {
                if( !isset(self::$_instance) ) {
                    self::$_instance = new self();
                }
                return self::$_instance;
            }
            public function trigger() {
                foreach( $this->_listeners AS $listener ) {
                    call_user_func($listener);
                }
            }
            private function __construct() {

            }

            public function registerListener( Closure $closure ) {
                $this->_listeners[] = $closure;
            }
        }
    }