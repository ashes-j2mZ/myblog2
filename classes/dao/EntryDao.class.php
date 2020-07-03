<?php
    // last edited 2020年7月3日 金曜日 13:34

    namespace classes\dao;

    use classes\models\Entry;

    /**
     * Blog entry DAO class
     * @since 2020/06/26
     */
    final class EntryDao extends Dao
    {

        private const TABLE_NAME = 'entry';

        /**
         * get array containing entry information from entry ID
         * @param string $entry_id
         * @return Entry
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
         * @param array $edit_data
         * @return bool
         */
        public static function editEntry(Entry $entry, array $edit_data)
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
