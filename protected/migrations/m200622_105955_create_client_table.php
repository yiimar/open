<?php

class m200622_105955_create_client_table extends app\components\DMigration
{
    protected $table = 'client';
    protected $sidKey = 'idx_client_sid';

	public function up()
	{
        $this->createTable(
            $this->table,
            [
                'id' => 'pk',
                'sid' => 'int not null',
                'fio' => 'string not null',
            ],
            $this->options
        );
        $this->createIndex($this->sidKey, $this->table, 'sid');
	}

	public function down()
	{
	    $this->dropIndex($this->sidKey, $this->table);
	    $this->dropTable($this->table);
		echo "m200622_105955_create_client_table migration down.\n";
		return false;
	}
}