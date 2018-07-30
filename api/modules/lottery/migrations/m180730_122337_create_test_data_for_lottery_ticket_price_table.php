<?php

namespace api\modules\lottery\migrations;

/**
 * Handles the creation of table `lottery_ticket_price`.
 */
class m180730_122337_create_test_data_for_lottery_ticket_price_table extends \yii\db\Migration
{
    /**
     * migration table name
     */
    public $tableName = '{{%lottery_ticket_price}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert($this->tableName, ['id', 'lottery_id', 'currency', 'coefficient'], [
            [
                1,
                1,
                'USD',
                300,
            ],
            [
                2,
                1,
                'USD',
                300,
            ],
            [
                3,
                1,
                'USD',
                500,
            ],
            [
                4,
                2,
                'UAH',
                400,
            ],
            [
                5,
                2,
                600,
                'UAH',
            ],
            [
                6,
                3,
                50,
                'EUR',
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
