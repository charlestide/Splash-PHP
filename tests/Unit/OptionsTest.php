<?php
/**
 * Created by PhpStorm.
 * User: tangkeyu
 * Date: 2019-03-11
 * Time: 14:05
 */

use SplashPhp\Libraries\Splash\Options;
use PHPUnit\Framework\TestCase;

class OptionsTest extends TestCase
{

    /**
     * @return array
     */
    public function getOptions() {

        $options = [];

        for ($i = 0; $i <= 3; $i++) {
            $option = [];
            for ($j = 0; $j <= 10; $j++) {
                $option["name{$j}"] = rand(1, 10);
            }
            $options[][0] = $option;
        }

        return $options;
    }

    /**
     * @dataProvider getOptions
     * @param array $option
     */
    public function testHas(array $option)
    {
        $options = new Options($option);
        $key = array_rand($option);
        $this->assertTrue($options->has($key));
    }

    /**
     * @dataProvider getOptions
     * @param array $option
     */
    public function test__construct(array $option)
    {
        $options = new Options($option);
        $this->assertEquals($option,$options->all());
    }

    /**
     * @dataProvider getOptions
     * @param array $option
     */
    public function testGet(array $option)
    {
        $options = new Options($option);
        $key = array_rand($option);
        $this->assertEquals($option[$key],$options->get($key));
    }

    /**
     * @dataProvider getOptions
     * @param array $option
     */
    public function testToQuery(array $option)
    {
        $options = new Options($option);
        $this->assertEquals(http_build_query($option),$options->toQuery());
    }

    public function testSetTimeout()
    {
        $options = new Options();
        $options->setTimeout(20);
        $this->assertEquals(20,$options->get('timeout'));
    }

    /**
     * @dataProvider getOptions
     * @param array $option
     */
    public function testSet(array $option)
    {
        $options = new Options($option);
        $key = 'not_have';
        $value = 'value';
        $this->assertFalse($options->has($key));
        $options->set($key,$value);
        $this->assertTrue($options->has($key));
        $this->assertEquals($value,$options->get($key));
    }
}
