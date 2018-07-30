<?php

namespace api\modules\lottery\migrations;

/**
 * Handles the creation of table `lottery`.
 */
class m180730_121837_create_test_data_for_lottery_table extends \yii\db\Migration
{
    /**
     * migration table name
     */
    public $tableName = '{{%lottery}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert($this->tableName, ['id', 'entry_price', 'start_date', 'end_date'], [
            [
                1,
                2,
                '2018-07-30 12:00:00',
                '2018-08-30 12:00:00',
            ],
            [
                2,
                4,
                '2018-08-30 12:00:00',
                '2018-09-30 12:00:00',
            ],
            [
                3,
                5,
                '2018-09-30 12:00:00',
                '2018-10-30 12:00:00',
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
