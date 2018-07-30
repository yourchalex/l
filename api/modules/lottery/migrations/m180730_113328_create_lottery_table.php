<?php

namespace api\modules\lottery\migrations;

/**
 * Class m180730_113328_create_lottery_table migration
 */
class m180730_113328_create_lottery_table extends \yii\db\Migration
{
    /**
     * migration table name
     */
    public $tableName = '{{%lottery}}';

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
                'entry_price' => $this->integer()->notNull()
                    ->comment('Минимальное количество билетов для участия в лотерее'),
                'start_date' => $this->dateTime()->notNull()->comment('Дата старта лотерей'),
                'end_date' => $this->dateTime()->notNull()->comment('Дата окончания лотерей'),
            ],
            $this->tableOptions
        );

        $this->execute('ALTER TABLE ' . $this->tableName . ' ADD PRIMARY KEY USING HASH (id)');


    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
