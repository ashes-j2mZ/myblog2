<?php
    // last edited 2020年7月1日 水曜日 12:51

    namespace classes\models;

    use classes\common\Database;
    use classes\common\Search;
    use classes\dao\EntryDao;

    /**
     * blog entry model class
     * @since 2020/06/26
     */
    final class Entry extends ObjModel
    {

        // private $user_id = null;
        private $entry_id = null;
        private $entry_title = null;
        private $entry_content = null;
        private $del_flag = null;

        private const DEFAULT = array(
            'user_id' => '',
            'entry_id' => '',
            'entry_title' => '',
            'entry_content' => '',
            'del_flag' => 0
        );

        public function __construct($args = self::DEFAULT, $pub = null)
        {
            $pub = array( 'entry_id', 'entry_title', 'entry_content', 'del_flag' );
            parent::__construct($args, $pub);
        }

        /**
        * retrieve name of this entry's author
        * @return string
        */
        public function showAuthor()
        {
            // set search parameters
            $param = array(
                'type' => 'user_id',
                'value' => $this->user_id
            );
            // retrieve user information associated with this entry
            $user = Search::find('user', $param);
            // set user's display name as this instance's property
            return isset($user[0]) ? reset($user)['display_name'] : 'Could not find author associated with this entry.';
        }

        /**
        * set instance properties
        * @param array $arrDao
        * @return classes\models\Entry
        */
        protected function setProperty(array $arrDao)
        {
            $this->setUserId($arrDao['user_id'])
            ->setEntryId($arrDao['entry_id'])
            ->setEntryTitle($arrDao['entry_title'])
            ->setEntryContent($arrDao['entry_content'])
            ->setDelFlag($arrDao['del_flag']);
            return $this;
        }

        /**
        * find entry by ID
        * @param string $id
        * @return classes\models\Entry
        */
        public function findEntry($id)
        {
            $dao = EntryDao::getDao($id);
            return ( isset($dao[0]) ) ? $this->setProperty( reset($dao) ) : null;
        }

        /**
        * save changes
        * @return bool
        */
        public function save()
        {
            return EntryDao::save($this);
        }

        /**
        * create entry
        * @return bool
        */
        public function create()
        {
            return EntryDao::insert($this);
        }


        // setter functions
        public function setUserId($user_id)
        {
            $this->user_id = $user_id;
            return $this;
        }
        public function setEntryId($entry_id)
        {
            $this->entry_id = $entry_id;
            return $this;
        }
        public function setEntryTitle($entry_title)
        {
            $this->entry_title = $entry_title;
            return $this;
        }
        public function setEntryContent($entry_content)
        {
            $this->entry_content = $entry_content;
            return $this;
        }
        public function setDelFlag($del_flag)
        {
            $this->del_flag = $del_flag;
            return $this;
        }

        // getter functions
        public function getUserId()
        {
            return $this->user_id;
        }
        public function getEntryId()
        {
            return $this->entry_id;
        }
        public function getEntryTitle()
        {
            return $this->entry_title;
        }
        public function getEntryContent()
        {
            return $this->entry_content;
        }
        public function getDelFlag()
        {
            return $this->del_flag;
        }

    }

 ?>
