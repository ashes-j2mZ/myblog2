<?php
    // last edited 2020年7月3日 金曜日 13:13

    namespace classes\dao;

    use classes\models\Draft;

    /**
     * Entry draft DAO class
     * @since 2020/07/03
     */
    final class DraftDao extends Dao
    {

        private const TABLE_NAME = 'draft';

        /**
         * get draft from associated entry ID
         * @param string $entry_id
         * @return Draft
         */
        public static function findDraft($entry_id)
        {
            $search = array(
                'type' => 'entry_id',
                'value' => $entry_id
            );

            $result = parent::find(self::TABLE_NAME, $search);
            return isset($result[0]) ? new Draft( reset($result) ) : null;
        }

        /**
         * update draft
         * @param Draft $draft
         * @return bool
         */
        public static function editDraft(Draft $draft, $edit_data)
        {
            $limit = array('entry_id' => $draft->entry_id);

            return parent::update(self::TABLE_NAME, $edit_data, $limit);
        }

        /**
         * create new draft
         * @param array $draft_data
         * @return int
         */
        public static function createDraft(array $draft_data)
        {
            return parent::create(self::TABLE_NAME, $draft_data);
        }


    }

?>
