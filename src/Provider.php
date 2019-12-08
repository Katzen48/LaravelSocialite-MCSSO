<?php

namespace SocialiteProviders\MCSSO;

use Carbon\Carbon;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;

class Provider extends AbstractProvider
{
    /**
     * Unique Provider Identifier.
     */
    const IDENTIFIER = 'MCSSO';

    /**
     * {@inheritdoc}
     */
    protected $scopes = ['user:read:email', 'user:read:minecraft:verifydate','user:read:twitch'];

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://mc-sso.de/oauth/authorize', $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://mc-sso.de/oauth/access_token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://mc-sso.de/user', [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        $data = $user['data'];

        return (new User())->setRaw($user['data'])->map([
            // General User Info
            'id'            => $data['id'],
            'nickname'      => $data['name'],
            'name'          => $data['name'],
            'email'         => $data['email'],

            // Minecraft
            'uuid'          => $data['minecraft']['uuid'],
            'verified'      => $data['minecraft']['verified'],
            'verified_at'   => new Carbon($data['minecraft']['verified_at']),

            // Twitch
            'twitchId'      => $data['twitch']['id'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code'
        ]);
    }
}
