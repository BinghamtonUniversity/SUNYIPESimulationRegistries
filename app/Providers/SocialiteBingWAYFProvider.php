<?php
namespace App\Providers;

use Laravel\Socialite\Two\User;
use GuzzleHttp\Exception\GuzzleException;
use Laravel\Socialite\Two\AbstractProvider;
 
class SocialiteBingWAYFProvider extends AbstractProvider
{
    /**
     * @var string[]
     */
    protected $scopes = [
        'openid',
        'profile',
        'email',
    ];
 
    /**
     * @var string
     */
    protected $scopeSeparator = ' ';
 
    /**
     * @return string
     */
    public function getBingWayfUrl()
    {
        return config('services.bingwayf.base_uri') . '/oauth';
    }
 
    /**
     * @param string $state
     *
     * @return string
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase($this->getBingWayfUrl() . '/authorize', $state);
    }
 
    /**
     * @return string
     */
    protected function getTokenUrl()
    {
        return $this->getBingWayfUrl() . '/token';
    }
 
    /**
     * @param string $token
     *
     * @throws GuzzleException
     *
     * @return array|mixed
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->post($this->getBingWayfUrl() . '/profile', [
            'headers' => [
                'cache-control' => 'no-cache',
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]); 
        return json_decode($response->getBody()->getContents(), true);
    }
 
    /**
     * @return User
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'email' => $user['email'],
            'unique_id' => $user['preferred_username'],
            'last_name' => $user['family_name'],
            'first_name' => $user['given_name'],
        ]);
    }
}
