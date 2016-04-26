<?php
namespace arydeoblo\yii2bigbluebutton\migrations;

use yii\db\Migration;

class m151024_074167_bbb_meeting extends Migration
{

    public function up()
    {
        $this->createTable('bbb_meeting', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
            'meetingID' => $this->string(50),
            'attendePW' => $this->string(15),
            'moderatorPW' => $this->string(15),
            'recordedMeeting' => $this->boolean()->defaultValue(0),
        ]);
    }

    public function down()
    {
        $this->dropTable('bbb_meeting');
    }
}