<?php

namespace api\modules\lottery\migrations;

/**
 * Handles the creation of table `lottery_deposit`.
 */
class m180730_122320_create_test_data_for_lottery_deposit_table extends \yii\db\Migration
{
    /**
     * migration table name
     */
    public $tableName = '{{%lottery_deposit}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert($this->tableName, ['payment_uuid', 'player_uuid', 'processed_at', 'amount', 'currency'], [
            [
                1,
                1,
                '2018-06-30 12:00:00',
                800,
                'USD'
            ],
            [
                2,
                1,
                '2018-08-25 12:00:00',
                800,
                'USD'
            ],
            [
                3,
                2,
                '2018-10-01 12:00:00',
                800,
                'UAH'
            ],
            [
                4,
                2,
                '2018-10-01 12:00:00',
                800,
                'UAH'
            ],
            [
                5,
                2,
                '2018-09-28 12:00:00',
                2800,
                'UAH'
            ],
            [
                6,
                3,
                '2018-08-02 12:00:00',
                800,
                'EUR'
            ],
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
