<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveSlugAndShortDescriptionOnPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function ($table) {
            if (Schema::hasTable('pages','slug')) {
                $table->dropUnique(['slug']);
                $table->dropColumn('slug');
            }
            if (Schema::hasTable('pages','description')) {
                $table->dropColumn('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
