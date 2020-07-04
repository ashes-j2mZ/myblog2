<?php
// last edited 2020年7月4日 土曜日 17:41

    namespace classes\dao;

    use classes\common\Database;
    use classes\models\ObjModel;

    /**
     * base DAO class used for interaction between application and database
     * @since 06/30/2020
     */
    class Dao
    {

        protected const PRIMARY_KEY = 'id';

        /**
         * select all records from given table using given clauses
         * @param string $table_name
         * @param array $param
         * @param array $order
         * @param int $limit
         * @return array
         */
        public static function find($table_name, $param = null, $order = null, $limit = null)
        {
            // initialize variables
            $sql = "";
            $arr = array();

            // construct SQL query to retrieve information
            $sql .= "SELECT * FROM " . $table_name;
            if ( !is_null($param) ) {
                    $sql .= " WHERE " . $param['type'] . " = ?";
                    $arr[] = $param["value"];
            }
            if ( !is_null($order) ) {
                    $sql .= " ORDER BY " . $order["parameter"] . "  " . $order["direction"];
            }
            if ( !is_null($limit) ) {
                    $sql .= " LIMIT " . $limit;
            }

            // search database and retrieve results if any
            return Database::select($sql, $arr);
        }

        /**
         * returns value for given key for record in given table
         * @param string $key_name
         * @param string $table_name
         * @param array param
         * @return int
         */
        protected static function getKey($key_name, $table_name, $param)
        {
            // initialize variables
            $sql = "";
            $arr = array();

            // construct SQL query to retrieve information
            $sql = "SELECT " . $key_name . " FROM " . $table_name;
            $sql .= " WHERE " . $param['type'] . " = ?";
            $arr[] = $param['value'];
            $result = Database::select($sql, $arr);
            return isset($result[0]) ? reset($result) : null;
        }

        /**
         * insert new record with given values into given table
         * @param string $table_name
         * @param string $params
         * @return int $lastInsertId
         */
        public static function create($table_name, $params)
        {
            // initialize variables
            $sql = "";
            $arr = array();

            // construct SQL query to insert object(s)
            $sql .= "INSERT INTO " . $table_name . " (";
            foreach ($params as $key => $value) {
                if ( $key == array_key_last($params) ) {
                    $sql .= $key . ") ";
                } else {
                    $sql .= $key . ", ";
                }
                $arr[] = $value;
            }
            $sql .= " VALUES (" . implode( ', ', array_fill(0, count($params), '?') ) . ")";

            // insert data into table
            return Database::insert($sql, $arr);
        }

        /**
        * update given table by setting given values for fields
        * can take additional clause defining which records are to be updated
        * @param string $table_name
        * @param array $params
        * @param array $limit
        * @return bool
        */
        public static function update($table_name, $params, $limit = null)
        {
            // initialize variables
            $sql = "";
            $arr = array();

            // construct SQL query to update table
            $sql .= "UPDATE " . $table_name . " SET ";
            foreach ($params as $key => $value) {
                if ( $key == array_key_last($params) ) {
                    $sql .= $key . " = ? ";
                } else {
                    $sql .= $key . " = ?, ";
                }
                $arr[] = $value;
            }
            if ( !is_null($limit) ) {
                $key = key($limit);
                $sql .= "WHERE " . $key . " = ?";
                $arr[] = $limit[$key];
            }

            // update table
            return Database::update($sql, $arr);
        }

        /**
        * delete specified record from given table
        * @param string $table_name
        * @param array $params
        * @return int $lastInsertId
        */
        public static function delete($table_name)
        {
            // initialize variables
            $sql = "";

            // construct SQL query to insert object(s)
            $sql .= "DELETE FROM " . $table_name . " WHERE del_flag = 1";

            // delete
            return Database::delete($sql);
        }

    }

?>
