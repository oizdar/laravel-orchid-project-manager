<?php

use App\Enums\TaskStatusesEnum;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->text('description');
            $table->date('start_date');
            $table->date('end_date')
                ->nullable()
            ;
            $table->enum('status', array_column(TaskStatusesEnum::cases(), 'value'));
            $table->foreignIdFor(User::class)
                ->nullable();
            $table->foreignIdFor(Project::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
