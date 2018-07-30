<?php

namespace api\modules\lottery\migrations;

/**
 * Handles the creation of table `lottery_profile`.
 */
class m180730_122351_create_test_data_for_lottery_profile_table extends \yii\db\Migration
{
    /**
     * migration table name
     */
    public $tableName = '{{%lottery_profile}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert($this->tableName, ['player_uuid', 'username', 'currency'], [
            [
                1,
                'Alex',
                'USD',
            ],
            [
                2,
                'Andrew',
                'UAH',
            ],
            [
                3,
                'Ray',
                'EUR',
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable($this->tableName);
    }
}
