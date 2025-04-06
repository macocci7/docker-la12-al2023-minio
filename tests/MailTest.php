<?php

namespace Tests\Feature\Environment;

require_once __DIR__ . '/../html/vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class MailTest extends TestCase
{
    public function test_mail_send_can_send_email(): void
    {
        $from = ['address' => 'test@example.com', 'name' => 'Test User'];
        $to = ['address' => 'hoge@example.com', 'name' => 'Mr. Hoge'];
        $key = \Carbon\Carbon::now()->format('Ymd-His-v');
        $subject = 'Test Mail' . $key;
        $body = 'Hello!';

        // Sends an email using artisan command
        $result = exec(__DIR__ . '/../bin/artisan mail:send --key=' . $key, $output, $retval);
        $this->assertTrue($result !== false);

        sleep(1);

        // Checks the email sent（via mailpit API）
        $base_url = 'http://localhost:8025/api/v1';
        $client = new \GuzzleHttp\Client();
        $response = $client->request(
            'GET',
            $base_url . '/message/latest',
            [
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ],
        );
        $json = $response->getBody()->getContents();
        $object = json_decode($json);
        $this->assertSame($from['name'], $object->From->Name);
        $this->assertSame($from['address'], $object->From->Address);
        $this->assertSame($to['name'], $object->To[0]->Name);
        $this->assertSame($to['address'], $object->To[0]->Address);
        $this->assertSame($subject, $object->Subject);
        $this->assertStringContainsString($body, $object->Text);
    }

    public function test_mail_queue_can_send_email(): void
    {
        $from = ['address' => 'test@example.com', 'name' => 'Test User'];
        $to = ['address' => 'hoge@example.com', 'name' => 'Mr. Hoge'];
        $key = \Carbon\Carbon::now()->format('Ymd-His-v');
        $subject = 'Test Mail Queue' . $key;
        $body = 'Hello!';

        // Queues a job to send an email using artisan command
        $result = exec(__DIR__ . '/../bin/artisan mail:queue --key=' . $key, $output, $retval);
        $this->assertTrue($result !== false);

        sleep(3);

        // Checks the email sent（via mailpit API）
        $base_url = 'http://localhost:8025/api/v1';
        $client = new \GuzzleHttp\Client();
        $response = $client->request(
            'GET',
            $base_url . '/message/latest',
            [
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ],
        );
        $json = $response->getBody()->getContents();
        $object = json_decode($json);
        $this->assertSame($from['name'], $object->From->Name);
        $this->assertSame($from['address'], $object->From->Address);
        $this->assertSame($to['name'], $object->To[0]->Name);
        $this->assertSame($to['address'], $object->To[0]->Address);
        $this->assertSame($subject, $object->Subject);
        $this->assertStringContainsString($body, $object->Text);
    }
}
