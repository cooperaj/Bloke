<?php namespace NetworkPie\Bloke\Tests;

use \NetworkPie\Bloke\RouteParser;

class RouteParserTest extends \Codeception\TestCase\Test
{
    /**
     * @dataProvider parseProvider
     */
    public function testParse($routeToTest, $expected)
    {
        $parser = new RouteParser();

        $route = $parser->parse($routeToTest);

        $this->unitTester->assertEquals($expected, $route);
    }

    public function parseProvider()
    {
        return [
            ['/user/{name}', '#^/user/(?P<name>\w+)$#i'],
            ['/user/{name}/{operation}', '#^/user/(?P<name>\w+)/(?P<operation>\w+)$#i'],
            ['/user/{name}/edit', '#^/user/(?P<name>\w+)/edit$#i'],
            ['/user/adam/edit', '#^/user/adam/edit$#i'],
            ['/{name}', '#^/(?P<name>\w+)$#i'],
            ['/', '#^/$#i']
        ];
    }

}
