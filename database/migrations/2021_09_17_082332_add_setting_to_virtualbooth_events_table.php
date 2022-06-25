<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSettingToVirtualboothEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('virtualbooth_events', function (Blueprint $table) {
              $table->string('photoType',255)->nullable();
              $table->integer('experiencePhoto')->default(0);
              $table->integer('experienceGif')->default(0);
              $table->integer('experienceBoomerang')->default(0);
              $table->integer('enableUserInput')->default(0);
              $table->string('userInputText',255)->nullable();
              $table->integer('flipImage')->default(0);
              $table->integer('allowLibrarySelect')->default(0);
              $table->integer('enableDisclaimer')->default(0);
              $table->string('disclaimerText',255)->nullable();
              $table->string('eventlogo',255)->nullable();
              $table->string('logoPosition',255)->nullable();
              $table->string('eventscreen',255)->nullable();
              $table->text('screentext')->nullable();
              $table->integer('frameStartText')->default(0);
              $table->string('textPosition',255)->nullable();
              $table->string('eventthankscreen',255)->nullable();
              $table->text('thankscreentext')->nullable();
              $table->integer('thankframeStartText')->default(0);
              $table->string('thanktextPosition',255)->nullable();
              $table->string('pagebackground',255)->nullable();
              $table->string('bgOverlayColor',255)->nullable();
              $table->string('bgColor-tmp',255)->nullable();
              $table->string('bgAnimation',255)->nullable();
              $table->string('buttonStyle',255)->nullable();
              $table->string('buttonColor',255)->nullable();
              $table->integer('showButtonIcon')->default(0);
              $table->string('buttonPosition',255)->nullable();
              $table->string('textColor',255)->nullable();
              $table->integer('hideStart')->default(0);
              $table->string('startButtonText',255)->nullable();
              $table->string('photoButtonText',255)->nullable();
              $table->string('cameraButtonText',255)->nullable();
              $table->string('libraryButtonText',255)->nullable();
              $table->string('doneButtonText',255)->nullable();
              $table->string('likeButtonText',255)->nullable();
              $table->string('retakeButtonText',255)->nullable();
              $table->string('nextButtonText',255)->nullable();
              $table->string('sendButtonText',255)->nullable();
              $table->string('instruction_frameText',255)->nullable();
              $table->string('instruction_bgText',255)->nullable();
              $table->string('instruction_stickerText',255)->nullable();
              $table->string('instruction_filterText',255)->nullable();
              $table->integer('sharingEmail')->default(0);
              $table->integer('sharingFacebook')->default(0);
              $table->integer('sharingTwitter')->default(0);
              $table->integer('sharingDownload')->default(0);
              $table->string('emailSubject',255)->nullable();
              $table->string('emailMessage',255)->nullable();
              $table->string('sharingMessage',255)->nullable();
             $table->integer('sharingGallery')->default(0);
              $table->integer('sharingDropbox')->default(0);
              $table->integer('sharingGoogle')->default(0);
              $table->integer('askToShare')->default(0);
              $table->string('askToShareText',255)->nullable();
              $table->integer('enableCTA')->default(0);
              $table->string('CTAButtonText',255)->nullable();
              $table->string('CTAButtonURL',255)->nullable();
              $table->integer('enableBuy')->default(0);
              $table->string('BuyButtonText',255)->nullable();
              $table->integer('requireEmail')->default(0);







        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('virtualbooth_events', function (Blueprint $table) {
            //
        });
    }
}
