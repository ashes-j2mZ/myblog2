<?php
    // last edited 2020年6月29日 月曜日 13:47

    namespace classes\dao;

    use classes\common\Database;
    use classes\models\Entry;

    /**
     * Blog entry DAO class
     * @since 2020/06/26
     */
    class EntryDao
    {

        /**
         * get array containing entry information from entry ID
         * @param string $entryId
         * @param int $intDelFlag = null
         * @return array
         */
        public static function getDao($entryId, $intDelFlag = null)
        {
            $sql = "SELECT ";
            $sql .= "entry_id";
            $sql .= ", entry_title";
            $sql .= ", entry_content";
            $sql .= ", del_flag ";
            $sql .= "FROM entry ";
            $sql .= "WHERE entry_id = :entry_id ";

            $arr = array();
            $arr[':entry_id'] = $entryId;
            if (!is_null($intDelFlag) && in_array($intDelFlag, array(0, 1))) {
                $sql .= "AND del_flag = :delFlag ";
                $arr[':delFlag'] = $intDelFlag;
            }

            return Database::select($sql, $arr);
        }

        /**
         * update blog entry
         * @param Entry $entry
         * @return bool
         */
        public static function save(Entry $entry)
        {
            $sql = "UPDATE ";
            $sql .= "entry ";
            $sql .= "SET ";
            $sql .= "entry_title = :entry_title";
            $sql .= ", entry_content = :entry_content";
            $sql .= ", del_flag = :delFlag";
            $sql .= "WHERE entry_id = :entry_id";

            $arr = array();
            $arr[':entry_title'] = $entry->getEntryTitle();
            $arr[':entry_content'] = $entry->getEntryContent();
            $arr[':delFlag'] = $entry->getDelFlag();
            $arr[':entry_id'] = $entry->getEntryId();

            return Database::update($sql, $arr);
        }

        /**
        * create new blog entry
         * @param Entry $entry
        * @return int
        */
        public static function insert(Entry $entry)
        {
            $sql = "INSERT INTO ";
            $sql .= "entry ";
            $sql .= "(";
            $sql .= "user_id";
            $sql .= ", entry_id";
            $sql .= ", entry_title";
            $sql .= ", entry_content";
            $sql .= ") VALUES (";
            $sql .= ":user_id";
            $sql .= ", :entry_id";
            $sql .= ", :entry_title";
            $sql .= ", :entry_content";
            $sql .= ")";

            $arr = array();
            $arr[':user_id'] = $entry->getUserId();
            $arr[':entry_id'] = $entry->getEntryId();
            $arr[':entry_title'] = $entry->getEntryTitle();
            $arr[':entry_content'] = $entry->getEntryContent();

            return Database::insert($sql, $arr);
        }

    }

 ?>
