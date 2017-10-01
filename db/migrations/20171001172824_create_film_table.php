<?php

use Phinx\Migration\AbstractMigration;

class CreateFilmTable extends AbstractMigration
{

    public function up()
    {
        $users = $this->table('film');
        $users
            ->addColumn('position', 'integer')
            ->addColumn('rating', 'float')
            ->addColumn('name', 'string')
            ->addColumn('year', 'integer')
            ->addColumn('numberVoted', 'integer')
            ->addColumn('date', 'datetime')
            ->save();
    }

    public function down()
    {
        $this->table('film')->drop();
    }

}
