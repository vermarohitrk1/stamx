<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('certifies')) { 
        Schema::create('certifies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->integer('domain_id')->default(0);
            $table->string('name',255)->nullable();
            $table->integer('boardcertified')->nullable()->default(0);
            $table->string('certification',255)->nullable();
            $table->string('degree',255)->nullable();
             $table->bigInteger('cecredit')->nullable()->default(0);
              $table->string('prerequisites',255)->nullable();
              $table->string('specialization',255)->nullable();
               $table->float('price',11,2)->nullable()->default(0);
               $table->float('sale_price',11,2)->nullable()->default(0);
              $table->string('image',255)->nullable();
              $table->string('logos',255)->nullable();
              $table->string('product',255)->nullable();
               $table->integer('duration')->nullable()->default(0);
              $table->string('period',255)->nullable();
              $table->text('description')->nullable();
               $table->integer('pennfoster')->nullable()->default(0)->comment("0=not active,1=active");
               $table->integer('authoritylabel')->nullable()->default(0);
               $table->bigInteger('commision')->nullable()->default(0);
               $table->enum('status',['Published','Unpublished'])->default('Published');
               $table->integer('category')->nullable()->default(0);
                $table->string('instructor',255)->nullable();
              $table->string('video',255)->nullable();
              $table->string('youtubelink',255)->nullable();
              $table->string('viewtype',255)->nullable();
              $table->string('videotype',255)->nullable();
               $table->enum('type',['Regular','Masterclass'])->default('Regular');
               $table->enum('syndicate',['Enabled','Disabled'])->default('Enabled');
               $table->enum('syndicate_approval',['APPROVE','PENDING'])->default('PENDING');
               $table->integer('bls_industry')->nullable()->default(0);
              $table->string('course_file',255)->nullable();
               $table->integer('email_auto_reply')->nullable()->default(0);
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certifies');
    }
}
