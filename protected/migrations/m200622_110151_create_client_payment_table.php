<?php

class m200622_110151_create_client_payment_table extends DMigration
{
    protected $table = 'client_payment';
    protected $fkKey = 'fk_pm_sid_client_sid';

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
	    $this->dropForeignKey($this->fkKey, $this->table);
	    $this->dropTable($this->table);
		echo "m200622_110151_create_client_payment_table does not support migration down.\n";
		return false;
	}
}