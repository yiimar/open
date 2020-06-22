<?php

class m200622_110151_create_client_payment_table extends app\components\DMigration
{
    protected $table = 'client_payment';
    protected $fkKey = 'fk_sid_client_sid';

	public function up()
	{
        $this->createTable(
            $this->table,
            [
                'id' => 'pk',
                'client_sid' => 'int not null',
                'debkred' => 'boolean',
                'summa' => 'bigint not null',
            ],
            $this->options
        );
        $this->addForeignKey(
            $this->fkKey,
            $this->table,
            'client_sid',
            'client',
            'sid',
            $delete = 'CASCADE',
            $update = 'CASCADE'
        );
	}

	public function down()
	{
		echo "m200622_110151_create_client_payment_table does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}