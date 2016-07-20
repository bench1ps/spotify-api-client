<?php

namespace Bench1ps\Spotify;

class AuthorizationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private static $configuration = [
        'client_id' => 'foobar',
        'client_secret' => 'barbaz',
        'redirect_uri' => 'http://foobar/callback'
    ];

    /**
     * @var Authorization
     */
    private $authorization;

    /**
     * @var \Bench1ps\Spotify\Session\SessionHandler
     */
    private $sessionHandler;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->sessionHandler = $this->prophesize('\Bench1ps\Spotify\Session\SessionHandler');
        $this->authorization = new Authorization(self::$configuration, $this->sessionHandler->reveal());
    }

    /**
     * @param array        $scopes
     * @param bool         $force
     * @param string|null  $state
     *
     * @test
     *
     * @dataProvider authorizationQuery_provider
     */
    public function authorization_flow_url_is_correctly_returned(array $scopes = [], $force = false, $state = null)
    {
        $url = $this->authorization->getAuthorizationQuery($scopes, $force, $state);
        parse_str(parse_url($url)['query'], $params);

        if (!empty($scopes)) {
            $this->assertNotEmpty($params['scopes']);
            $parts = explode(',', $params['scopes']);
            foreach ($scopes as $scope) {
                $this->assertContains($scope, $parts);
            }
        }

        if ($force) {
            $this->assertNotEmpty($params['show_dialog']);
            $this->assertEquals($force, $params['show_dialog']);
        }

        if (null !== $state) {
            $this->assertNotEmpty($params['state']);
            $this->assertEquals($state, $params['state']);
        }
    }

    /**
     * @return array
     */
    public function authorizationQuery_provider()
    {
        return [
            [],
            [['foo', 'bar']],
            [[], true],
            [[], false, 'foobar'],
            [['foo', 'bar'], true, 'foobar'],
        ];
    }
}