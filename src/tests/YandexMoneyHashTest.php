<?php

use Zzzaaa\LaravelYandexMoneyHttpNotify\Middleware\YandexMoneyHash;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class YandexMoneyHashTest extends TestCase
{
    public function testHash()
    {
        $secret = '01234567890ABCDEF01234567890';

        $inst = new YandexMoneyHash();

        $params = [
            'notification_type' => 'p2p-incoming',
            'operation_id' => '1234567',
            'amount' => '300.00',
            'currency' => '643',
            'datetime' => '2011-07-01T09:00:00.000+04:00',
            'sender' => '41001XXXXXXXX',
            'codepro' => 'false',
            'label' => 'YM.label.12345',
        ];

        $request = new Request();
        $request->request = new ParameterBag($params);

        $this->assertEquals( 'a2ee4a9195f4a90e893cff4f62eeba0b662321f9', $inst->hash($request, $secret));
    }

    public function test403()
    {
        $inst = new YandexMoneyHash();

        $this->expectException(HttpException::class);
        $inst->handle(new Request(), function (){});
        $this->expectExceptionCode(403);
    }
}
