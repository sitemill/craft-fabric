<?php
/**
 * @link      https://sitemill.co
 * @copyright Copyright (c) 2020 SiteMill
 */

namespace sitemill\library\migrations;

use craft\db\Table;

use Craft;
use craft\config\DbConfig;
use craft\db\Migration;

/**
 * @author    SiteMill
 * @package   Library
 * @since     1.0.0
 */
class Install extends Migration
{
    // Public Properties
    // =========================================================================

    /**
     * @var string The database driver to use
     */
    public $driver;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        if ($this->createTables()) {
            $this->addForeignKeys();
            // Refresh the db schema caches
            Craft::$app->db->schema->refresh();
            $this->insertDefaultData();
        }

        return true;
    }

   /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        $this->removeTables();

        return true;
    }

    // Protected Methods
    // =========================================================================

    /**
     * @return bool
     */
    protected function createTables()
    {
        $tablesCreated = false;

        $tableSchema = Craft::$app->db->schema->getTableSchema('{{%library_shares}}');
        if ($tableSchema === null) {
            $tablesCreated = true;
            $this->createTable(
                '{{%library_shares}}',
                [
                    'id' => $this->primaryKey(),
                    'dateCreated' => $this->dateTime()->notNull(),
                    'dateUpdated' => $this->dateTime()->notNull(),
                    'expiryDate' => $this->dateTime()->null(),
                    'count' => $this->integer()->defaultValue(0)->notNull(),
                    'uid' => $this->uid(),
                    'sharerId' => $this->integer(),
                    'elementId' => $this->integer()->notNull(),
                ]
            );
        }

        return $tablesCreated;
    }

    /**
     * @return void
     */
    protected function createIndexes()
    {
        $this->createIndex(null, '{{%library_shares}}', 'elementId', true);
        // Additional commands depending on the db driver
        switch ($this->driver) {
            case DbConfig::DRIVER_MYSQL:
                break;
            case DbConfig::DRIVER_PGSQL:
                break;
        }
    }

    /**
     * @return void
     */
    protected function addForeignKeys()
    {
        $this->addForeignKey(null, '{{%library_shares}}', 'elementId', Table::ELEMENTS, 'id', 'CASCADE');
        $this->addForeignKey(null, '{{%library_shares}}', 'sharerId', Table::USERS, 'id', 'CASCADE');
    }

    /**
     * @return void
     */
    protected function insertDefaultData()
    {
    }

    /**
     * @return void
     */
    protected function removeTables()
    {
        $this->dropTableIfExists('{{%library_shares}}');
    }
}
