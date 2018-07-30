<?php

namespace api\modules\lottery\migrations;

/**
 * Class m180730_113543_create_lottery_profile_table migration
 */
class m180730_113543_create_lottery_profile_table extends \yii\db\Migration
{
    /**
     * migration table name
     */
    public $tableName = '{{%lottery_profile}}';

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
                'player_uuid' => $this->string(64)->notNull()->comment('Идентификатор пользователя'),
                'username' => $this->string(255)->notNull()->comment('Имя пользователя - никнейм'),
                'currency' => $this->string(3)->notNull()
                    ->comment('Валюта пользователя (у пользователя только 1 валюта и все депозиты в этой валюте'),
            ],
            $this->tableOptions
        );

        $this->execute('ALTER TABLE ' . $this->tableName . ' ADD PRIMARY KEY USING HASH (player_uuid)');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
