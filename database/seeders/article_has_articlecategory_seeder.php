<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;



class article_has_articlecategory_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ab_article_has_articlecategory = [];

        if (($handle = fopen("storage/app/data/article_has_articlecategory.csv", "r")) !== FALSE) {
            try {
                // Begin a database transaction
                DB::beginTransaction();

                // Skip the first line
                fgetcsv($handle);

                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    array_push($ab_article_has_articlecategory, array(
                        "ab_articlecategory_id" => $data[0],
                        "ab_article_id" => $data[1],
                    ));
                }

                DB::table('ab_article_has_articlecategory')->insert($ab_article_has_articlecategory);
                // Commit the database transaction
                DB::commit();
            } catch (\Exception $e) {
                // An error occurred, rollback the database transaction
                DB::rollBack();

                // Handle the error, log it, or throw an exception
            } finally {
                fclose($handle);
            }
        }
    }
}
