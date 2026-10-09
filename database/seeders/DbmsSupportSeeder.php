<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\DbmsSupport;

class DbmsSupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $dbms_supports = [
            [
              "name"=> "Microsoft SQL Server",
              "description"=> "Microsoft SQL Server"
            ],
            [
              "name"=> "Mysql",
              "description"=> "Mysql"
            ],
            [
              "name"=> "Postgresql",
              "description"=> "Postgresql"
            ],
            [
              "name"=> "Oracle",
              "description"=> "Oracle"
            ],
            [
              "name"=> "SQLite",
              "description"=> "SQLite"
            ],
            [
              "name"=> "MongoDB",
              "description"=> "MongoDB"
            ],
            [
              "name"=> "MariaDB",
              "description"=> "MariaDB"
            ],
            [
              "name"=> "IBM",
              "description"=> "IBM"
            ],
            [
              "name"=> "AmazonRDS",
              "description"=> "AmazonRDS"
            ],
            [
              "name"=> "Redis",
              "description"=> "Redis"
            ],
            [
              "name"=> "DB2",
              "description"=> "DB2"
            ],
            [
              "name"=> "CouchDB",
              "description"=> "CouchDB"
            ],
            [
              "name"=> "Firebase",
              "description"=> "Firebase"
            ],
            [
              "name"=> "No database used",
              "description"=> "No database used"
            ]
        ];

        DbmsSupport::insert($dbms_supports);
    }
}
