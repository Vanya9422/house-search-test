<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \Doctrine\DBAL\Exception
     */
	public function run()
	{
		Model::unguard();

		Schema::disableForeignKeyConstraints();

		foreach($this->getTargetTableNames() as $table) DB::table($table)->truncate();

		Schema::enableForeignKeyConstraints();

		$this->call([
            HouseSeeder::class
		]);

		Model::reguard();
	}

    /**
     * Возврошает Все имена Таблиц
     *
     * @return mixed
     * @throws \Doctrine\DBAL\Exception
     */
	private function getTargetTableNames(): array
	{
		return array_diff($this->getAllTableNames(), ['migrations']);
	}

    /**
     * @return array
     * @throws \Doctrine\DBAL\Exception
     */
	private function getAllTableNames(): array
	{
		return DB::connection()->getDoctrineSchemaManager()->listTableNames();
	}
}
