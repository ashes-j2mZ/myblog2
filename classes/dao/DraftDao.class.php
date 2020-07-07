<?php
    // last edited 2020年7月7日 火曜日 14:55

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
         * @param string $draft_id
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
         * get all drafts matching given user ID (primary key)
         * @param int $user_id
         * @return mixed
         */
        public static function findUserDrafts( $user_id, $order = array('parameter' => 'last_updated', 'direction' => 'DESC') )
        {
            $search = array(
                'type' => 'user_id',
                'value' => $user_id
            );

            $results = parent::find(self::TABLE_NAME, $search, $order);
            // return array of draft objects, or FALSE if no drafts exist
            if ( empty($results) ) {
                return false;
            } else {
                $user_drafts = array();
                foreach ($results as $value) {
                    $user_drafts[] = new Draft($value);
                }
                return $user_drafts;
            }
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
                'value' => $draft->draft_id
            );
            $result = parent::getKey(parent::PRIMARY_KEY, self::TABLE_NAME, $search);
            return (int)reset($result);
        }

    }

?>
