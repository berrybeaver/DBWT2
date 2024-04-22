<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DevelopmentData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //user data
        $file = storage_path('app/data/user.csv');
        if(($handle = fopen($file, 'r'))!== FALSE){
            fgetcsv($handle, 1000, ';');        //header lesen
            while (($row = fgetcsv($handle, 1000, ';')) !== FALSE){
                if (isset($row[0], $row[1], $row[2], $row[3])) {
                    DB::table('ab_users')->insert([
                        'id' => $row[0],
                        'ab_name' => $row[1],
                        'ab_password' => Hash::make($row[2]), // Passwörter sollten gehasht gespeichert werden
                        'ab_mail' => $row[3]
                    ]);
                }
            }
            fclose($handle);
        }

        //articles data
        $file = storage_path('app/data/articles.csv');
        if(($handle = fopen($file, 'r'))!== FALSE){
            $headers = fgetcsv($handle, 1000 , ';');
            while (($row = fgetcsv($handle, 1000, ';')) !== FALSE) {
                if (isset($row[0], $row[1], $row[2], $row[3], $row[4], $row[5])) {
                    $price = str_replace('.', '', $row[2]);
                    DB::table('ab_article')->insert([
                        'id' => $row[0],
                        'ab_name' => $row[1],
                        'ab_price' => $price * 100,
                        'ab_description' => $row[3],
                        'ab_creator_id' => $row[4],
                        'ab_createdate' => $row[5]
                    ]);
                }
            }
            fclose($handle);
        }

        //articles category data laden
        $file = storage_path('app/data/articlecategory.csv');
        if(($handle = fopen($file, 'r')) !== FALSE){
            fgetcsv($handle, 1000, ';');
            while($row = fgetcsv($handle, 1000, ';')){
                if(isset($row[0], $row[1], $row[2])){
                    if ($row[2] == 'NULL') {
                        $row[2] = NULL;
                    }
                    DB::table('ab_articlecategory')->insert([
                        'id' => $row[0],
                        'ab_name' => $row[1],
                        'ab_parent' => $row[2]
                    ]);
                }
            }
            fclose($handle);
        }
    }
}
