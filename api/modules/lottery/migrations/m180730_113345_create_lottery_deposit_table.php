<?php

namespace api\modules\lottery\migrations;

/**
 * Class m180730_113345_create_lottery_deposit_table migration
 */
class m180730_113345_create_lottery_deposit_table extends \yii\db\Migration
{
    /**
     * migration table name
     */
    public $tableName = '{{%lottery_deposit}}';

    /**
     * @var string
     */
    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=Memory';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(
            $this->tableName,
            [
                'payment_uuid' => $this->string(64)->notNull()->comment('Идентификатор депозита'),
                'player_uuid' => $this->string(64)->notNull()->comment('Идентификатор пользователя'),
                'processed_at' => $this->dateTime()->notNull()->comment('Дата обработки депозита'),
                'amount' => $this->decimal(18, 2)->notNull()->comment('Сумма депозита'),
                'currency' => $this->string(3)->notNull()->comment('Валюта депозита'),
            ],
            $this->tableOptions
        );

        $this->execute('ALTER TABLE ' . $this->tableName
            . ' ADD PRIMARY KEY USING HASH (payment_uuid),'
            . ' ADD KEY USING HASH (player_uuid)'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
