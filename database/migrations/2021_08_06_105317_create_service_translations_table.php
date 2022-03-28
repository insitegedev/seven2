<?php
/**
 *  database/migrations/2021_08_06_105317_create_service_translations_table.php
 *
 * Date-Time: 06.08.21
 * Time: 15:12
 * @author Insite LLC <hello@insite.international>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('service_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title')->nullable();
            $table->longText('description')->nullable();

            $table->unique(['service_id','locale']);
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_translations');
    }
}
