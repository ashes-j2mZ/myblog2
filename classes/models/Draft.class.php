<?php
    // last edited 2020年7月3日 金曜日 13:08

    namespace classes\models;

    /**
     * entry draft model class
     * @since 2020/07/03
     */
    final class Draft extends ObjModel
    {

        private const DEFAULT = array(
            'draft_id' => '',
            'entry_title' => '',
            'entry_content' => '',
        );

        function __construct($args = self::DEFAULT)
        {
            parent::__construct($args);
        }
    }

?>
