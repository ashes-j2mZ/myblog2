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
            'user_id' => '',
            'entry_id' => '',
            'entry_title' => '',
            'entry_content' => '',
            'update_flag' => 0,
            'del_flag' => 0
        );

        function __construct($args = self::DEFAULT, $pub = null)
        {
            $pub = array( 'entry_id', 'entry_title', 'entry_content', 'update_flag', 'del_flag' );
            parent::__construct($args, $pub);
        }
    }

?>
