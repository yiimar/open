<?php

class DMigration extends CDbMigration
{
    /**
     * get options for schema
     *
     * @return string options
     */
    public function getOptions()
    {
        return db()->schema instanceof CMysqlSchema
            ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8'
            : '';
    }
}