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
         * get draft from associated draft ID
         * @param string $entry_id
         * @return Draft
         */
        public static function findDraft($draft_id)
        {
            $search = array(
                'type' => 'draft_id',
                'value' => $draft_id
            );

            $result = parent::find(self::TABLE_NAME, $search);
            return isset($result[0]) ? new Draft( reset($result) ) : null;
        }

        /**
         * update draft in database and return updated draft model
         * @param Draft $draft
         * @return Draft
         */
        public static function updateDraft(Draft $draft, $edit_data)
        {
            $limit = array('draft_id' => $draft->draft_id);

            parent::update(self::TABLE_NAME, $edit_data, $limit);
            return self::findDraft($draft->draft_id);
        }

        /**
         * create new draft in database and return created draft model
         * @param array $draft_data
         * @return Draft
         */
        public static function createDraft(array $draft_data)
        {
            parent::create(self::TABLE_NAME, $draft_data);
            return self::findDraft($draft_data['draft_id']);
        }

        /**
        * remove flagged draft from database
        * @return bool
        */
        public static function deleteDraft()
        {
            return parent::delete(self::TABLE_NAME);
        }

        /**
         * find primary key associated with given draft
         * @param Draft $draft
         * @return int
         */
        public static function getPrimaryKey(Draft $draft)
        {
            $search = array(
                'type' => 'draft_id',
                'value' => $entry->draft_id
            );
            $result = parent::getKey(parent::PRIMARY_KEY, self::TABLE_NAME, $search);
            return (int)reset($result);
        }

    }

?>
