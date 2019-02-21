<?php

use yii\db\Migration;

/**
 * Class m190221_180136_add_admin_user
 */
class m190221_180136_add_admin_user extends Migration
{
    public function safeUp()
    {
        $security = Yii::$app->getSecurity();
        $this->batchInsert(
            '{{%users}}',
            ['username', 'password', 'auth_key', 'access_token', 'created_at'],
            [
                [
                    'dkotenko',
                    $security->generatePasswordHash('123'),
                    $security->generateRandomString(),
                    $security->generateRandomString(),
                    time()
                ],
                [
                    'test',
                    $security->generatePasswordHash('test'),
                    $security->generateRandomString(),
                    $security->generateRandomString(),
                    time()
                ]
            ]
        );
    }

    public function safeDown()
    {
        $this->delete('{{%users}}', ['username' => ['dkotenko', 'test']]);
    }
}
