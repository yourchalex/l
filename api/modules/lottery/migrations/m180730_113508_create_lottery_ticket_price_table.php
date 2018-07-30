<?php

namespace api\modules\lottery\migrations;

/**
 * Class m180730_113508_create_lottery_ticket_price_table migration
 */
class m180730_113508_create_lottery_ticket_price_table extends \yii\db\Migration
{
    /**
     * migration table name
     */
    public $tableName = '{{%lottery_ticket_price}}';

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
                'id' => $this->string(64)->notNull()->comment('Id'),
                'lottery_id' => $this->string(64)->notNull()->comment('Идентификатор лотерей'),
                'currency' => $this->string(3)->notNull()->comment('К какой валюте относится цена билета'),
                'coefficient' => $this->integer()->notNull()
                    ->comment('Цена билета – сумма депозитов для одного билета'),
            ],
            $this->tableOptions
        );

        $this->execute('ALTER TABLE ' . $this->tableName
            . ' ADD PRIMARY KEY USING HASH (id),'
            . ' ADD KEY USING HASH (lottery_id)'
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
