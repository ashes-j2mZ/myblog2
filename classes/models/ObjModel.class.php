<?php
// last edited 2020年7月7日 火曜日 14:55

    namespace classes\models;
    /**
     * base class representing objects (users, entries, comments) in My Blog
     * @since 2020/06/30
     */
    class ObjModel
    {

        // array containing object properties
        private $properties = array();

        /**
         * initializes object with parameters given in argument
         * @param array $args
         * @param array $pub
         */
        public function __construct($args = array(), $pub = array())
        {
            foreach ($args as $key => $value) {
                if (array_key_exists($key, $pub)) {
                    // cast values as appropriate types
                    if ( preg_match('/^\d{4}-\d{2}-\d{2}/', $value) === 1 ) { // check if value is datetime
                        $this->properties[$key] = \DateTime::createFromFormat('Y-m-d H:i:s', $value);
                    } elseif ( preg_match('/^\d+$/', $value) === 1 ) { // check if value is integer
                        $this->properties[$key] = (int)$value;
                    } else {
                        $this->properties[$key] = $value;
                    }
                }

            }
        }

        /**
         * returns string representation of object
         * @return string $string
         */
        public function __toString()
        {
            $string = '';
            foreach ($this->properties as $key => $value) {
                $string .= $key . ": " . $value . "\r\n";
            }
            return $string;
        }

        /**
         * enables access to instance properties from outside class
         * throws notice if property does not exist
         * @param mixed $key
         * @return mixed
         */
        public function __get($key)
        {
            if ( array_key_exists($key, $this->properties) ) {
                return $this->properties[$key];
            }
            // error notice for undefined parameters
            $trace = debug_backtrace();
            trigger_error(
                "Attempted to retrieve undefined property '" . $key . "' from object of type " . basename( get_class($this) ) . " via __get() in " . $trace[0]['file'] . " on line " . $trace[0]['line'],
                E_USER_NOTICE
            );
            return null;
        }

        /**
         * enables instance properties to be set from outside class
         * throws notice if property does not exist
         * @param mixed $key, $value
         * @return void
         */
        public function __set($key, $value)
        {
            if ( array_key_exists($key, $this->properties) ) {
                $this->properties[$key] = $value;
            } else {
                // error notice for undefined parameters
                $trace = debug_backtrace();
                trigger_error(
                    "Attempted to set undefined property '" . $key . "' for object of type " . basename( get_class($this) ) . " via __set() in " . $trace[0]['file'] . " on line " . $trace[0]['line'],
                    E_USER_NOTICE
                );
            }
        }

    }

?>
