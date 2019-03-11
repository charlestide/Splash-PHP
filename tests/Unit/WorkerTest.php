<?php
/**
 * Created by PhpStorm.
 * User: tangkeyu
 * Date: 2019-03-05
 * Time: 23:22
 */

use SplashPhp\Worker;
use PHPUnit\Framework\TestCase;

class WorkerTest extends TestCase
{

    /**
     * @dataProvider seedProvide
     * @param array $seed
     * @throws ReflectionException
     */
    public function testStart(array $seed)
    {
//        $this->expectOutputString('Beanbun worker  download http://www.950d.com/ success.');

        $worker = $this->getMockForAbstractClass(Worker::class);
        $worker->method('getSeed')
            ->willReturn($seed);
        $worker->method('downloadedPage');

        $worker->start();
        $this->assertEquals($seed,$worker->getSeed());

        $this->assertTrue(is_callable($worker->getBean()->beforeDownloadPage));
        $this->assertTrue(is_callable($worker->getBean()->afterDownloadPage));

    }

    /**
     * @dataProvider seedProvide
     * @param array $seed
     * @throws ReflectionException
     */
    public function test__construct(array $seed)
    {
        $worker = $this->getMockForAbstractClass(Worker::class);
        $worker->method('getSeed')
            ->willReturn($seed);
        $this->assertInstanceOf(\Beanbun\Beanbun::class,$worker->getBean());
        $this->assertInstanceOf(\SplashPhp\Libraries\Output::class,$worker->getOutput());
    }

    /**
     * @dataProvider seedProvide
     * @param array $seed
     * @throws ReflectionException
     */
    public function testListen(array $seed) {
        $worker = $this->getMockForAbstractClass(Worker::class);
        $worker->method('getSeed')
            ->willReturn($seed);

        $this->assertEmpty($worker->getBean()->beforeDownloadPage);
        $this->assertEmpty($worker->getBean()->afterDownloadPage);
        $this->assertEmpty($worker->getBean()->downloadPage);

        $worker->listen();

        $this->assertTrue(is_callable($worker->getBean()->beforeDownloadPage));
        $this->assertTrue(is_callable($worker->getBean()->afterDownloadPage));

        $worker->setUseSplash(true);
        $worker->listen();
        $this->assertTrue(is_callable($worker->getBean()->downloadPage),'设置splash之后，download回调应有值');
    }

    /**
     * @return array
     */
    public function seedProvide(): array {
        return [
            [
                ['http://www.950d.com/']
            ]
        ];
    }
}
