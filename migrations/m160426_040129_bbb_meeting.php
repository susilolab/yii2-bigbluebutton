<?php

use yii\db\Migration;

class m160426_040129_bbb_meeting extends Migration
{
    public function up()
    {
        $this->createTable('bbb_meeting', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
            'meetingID' => $this->string(50),
            'attendeePW' => $this->string(15),
            'moderatorPW' => $this->string(15),
            'recordID' => $this->string(15),
            'recordedMeeting' => $this->boolean()->defaultValue(0),
        ]);
    }

    public function down()
    {
        $this->dropTable('bbb_meeting');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
