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
     */
    public function testStart(array $seed)
    {
        $worker = new Worker($seed);
        ob_start();
        $worker->start();
        $output = ob_get_clean();
        $this->assertContains('Beanbun worker  download http://www.950d.com/ success.',$output);
    }

    /**
     * @dataProvider seedProvide
     * @param array $seed
     */
    public function test__construct(array $seed)
    {
        $worker = new Worker($seed);

        $this->assertInstanceOf(Worker::class,$worker);
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
