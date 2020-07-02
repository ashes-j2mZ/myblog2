<?php
    // last edited 2020年6月29日 月曜日 13:47

    namespace classes\dao;

    use classes\models\Entry;

    /**
     * Blog entry DAO class
     * @since 2020/06/26
     */
    class EntryDao extends Dao
    {

        private const TABLE_NAME = 'entry';

        /**
         * get array containing entry information from entry ID
         * @param string $entryId
         * @param int $intDelFlag = null
         * @return array
         */
        public static function findEntry($entry_id)
        {
            $search = array(
                'type' => 'entry_id',
                'value' => $entry_id
            );

            $result = parent::find(self::TABLE_NAME, $search);
            return isset($result[0]) ? new Entry( reset($result) ) : null;
        }

        /**
         * update blog entry
         * @param Entry $entry
         * @return bool
         */
        public static function editEntry(Entry $entry, $edit_data)
        {
            $limit = array('entry_id' => $entry->entry_id);

            return parent::update(self::TABLE_NAME, $edit_data, $limit);
        }

        /**
        * create new blog entry
         * @param Entry $entry
        * @return int
        */
        public static function createEntry(array $entry_data)
        {
            return parent::create(self::TABLE_NAME, $entry_data);
        }

    }

 ?>
