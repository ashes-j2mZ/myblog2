<?php
    // last edited 2020年6月29日 月曜日 10:42

    namespace classes\models;

    use classes\dao\EntryDao;

    /**
     * blog entry model class
     * @since 2020/06/26
     */
    final class Entry extends ObjModel
    {

        private $user_id = null;
        private $entry_id = null;
        private $entry_title = null;
        private $entry_content = null;
        private $del_flag = null;

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
