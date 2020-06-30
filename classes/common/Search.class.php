<?php
// last edited

    namespace classes\common;

    use classes\models\ObjModel;

    /**
     * class used to find and retrieve object models
     * @since 06/30/2020
     */
    class Search
    {

        public static function find($table_name, $param = null, $order = null, $limit = null)
        {
            // initialize variables
            $sql = "";
            $arr = array();

            // construct SQL query to retrieve object(s)
            $sql = "SELECT * FROM " . $table_name . " ";
            if ( !is_null($param) ) {
                    $sql .= "WHERE " . $param['type'] . " = ? ";
                    $arr[] = $param["value"];
            }
            if ( !is_null($order) ) {
                    $sql .= "ORDER BY " . $order["parameter"] . " ? ";
                    $arr[] = $order["direction"];
            }
            if ( !is_null($limit) ) {
                    $sql .= "LIMIT ? ";
                    $arr[] = $limit;
            }

            // search database and retrieve results if any
            $search = Database::select($sql, $arr);

            // return result as array containing objects that match search
            $results = array();
            if ( isset($search) ) {
                foreach ($search as $key => $value) {
                    $results[$key] = new ObjModel($value);
                }
            }
            return $results;
        }

    }

?>