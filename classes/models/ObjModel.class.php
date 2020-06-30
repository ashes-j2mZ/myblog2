<?php
// last edited 2020年6月30日 火曜日 11:02

    namespace classes\models;
    /**
     * base class representing objects (users, entries, comments) in My Blog
     * @since 2020/06/30
     */
    class ObjModel
    {

        // array containing object parameters
        private $params = array();

        /**
         * initializes object with parameters given in argument
         * @param array $args
         */
        public function __construct($args)
        {
            foreach ($args as $key => $value) {
                $this->params[$key] = $value;
            }
        }

    }

?>
