<?php
    // last edited 2020年7月2日 木曜日 15:27
    namespace classes\common;

    /**
    * class for using database from application
    * @since 2020/06/24
    */
    class Database
    {

        /**
        * 接続文字列
        */
        const DSN = 'mysql:host=localhost;dbname=%s;charset=utf8mb4';

        /**
        * データベース名
        */
        const DBNAME = 'myblog';

        /**
        * ユーザー名
        */
        const USER_NAME = 'joi2o';

        /**
        * パスワード
        */
        const PASSWORD = '235811';

        /**
        * PDOインスタンス
        * @var \PDO
        */
        static private $instance = null;

        /**
        * コンストラクタ
        * @access private
        */
        private function __construct()
        {
            // code...
        }

        /**
        * インスタンスの取得
        * @return \PDO
        */
        private static function getInstance()
        {
            if ( is_null(self::$instance) ) {
                $options = array(
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_AUTOCOMMIT => true
                );
                self::$instance = new \PDO(
                    sprintf(self::DSN, self::DBNAME),
                    self::USER_NAME,
                    self::PASSWORD,
                    $options
                );
            }
            return self::$instance;
        }


        /**
        * クローン
        * @throws \Exception
        */
        final public function __clone()
        {
            $msg = sprintf('Clone is not allowed against %s', get_class($this));
            throw new \Exception($msg);
        }

        /**
        * トランザクション実行
        */
        public static function transaction()
        {
            self::getInstance()->beginTransaction();
        }

        /**
        * コミット
        */
        public static function commit()
        {
            self::getInstance()->commit();
        }

        /**
        * ロールバック
        */
        public static function rollback()
        {
            self::getInstance()->rollBack();
        }

        /**
        * SELECT実行
        * @param string $sql
        * @param array $arr
        * @return array
        */
        public static function select( $sql, array $arr = array() )
        {
            $stmt = self::getInstance()->prepare($sql);
            empty($arr) ? $stmt->execute() : $stmt->execute($arr);
            return $stmt->fetchAll();
        }

        /**
        * INSERT実行
        * @param string $sql
        * @param array $arr
        * @return int
        */
        public static function insert( $sql, array $arr = array() )
        {
            if( !self::getInstance()->inTransaction() ) {
                throw new \Exception("Not in transaction");
            }
            $stmt = self::getInstance()->prepare($sql);
            empty($arr) ? $stmt->execute() : $stmt->execute($arr);
            return self::getInstance()->lastInsertID();
        }

        /**
        * UPDATE実行
        * @param string $sql
        * @param array $arr
        * @return bool
        */
        public static function update( $sql, array $arr = array() )
        {
            if( !self::getInstance()->inTransaction() ) {
                throw new \Exception("Not in transaction");
            }
            $stmt = self::getInstance()->prepare($sql);
            return empty($arr) ? $stmt->execute() : $stmt->execute($arr);
        }

        /**
        * DELETE実行
        * @param string $sql
        * @param array $arr
        * @return bool
        */
        public static function delete( $sql, array $arr = array() )
        {
            if( !self::getInstance()->inTransaction() ) {
                throw new \Exception("Not in transaction");
            }
            $stmt = self::getInstance()->prepare($sql);
            return empty($arr) ? $stmt->execute() : $stmt->execute($arr);
        }

        public static function checkTransaction()
        {
            return self::getInstance()->inTransaction();
        }

    }

 ?>
