<?php

class m200623_061945_create_account_table extends DMigration
{
    protected $table = 'account';
    protected $fkKey = 'fk_accont_sid_client_sid';

    public function up()
    {
        $this->createTable(
            $this->table,
            [
                'id' => 'pk',
                'client_sid' => 'int not null',
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
		echo "m200623_061945_create_account_table does not support migration down.\n";
		return false;
	}
}