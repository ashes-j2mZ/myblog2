<?php
    // last edited 2020年6月26日 金曜日 16:59

    namespace classes\models;

    use classes\dao\EntryDao;

    /**
     * blog entry model class
     */
    final class Entry
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
