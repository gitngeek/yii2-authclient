<?php ///[yongtiger/yii2-authclient]
/**
 * Yii2 user
 *
 * @link        http://www.brainbook.cc
 * @see         https://github.com/yongtiger/yii2-user
 * @author      Tiger Yong <tigeryang.brainbook@outlook.com>
 * @copyright   Copyright (c) 2016 BrainBook.CC
 * @license     http://opensource.org/licenses/MIT
 */

namespace yongtiger\authclient\clients;

/**
 * Trait ClientTrait
 *
 * Used of client classes which implement the interface IAuth.
 *
 * @package yongtiger\authclient\clients
 */
trait ClientTrait
{
    /**
     * Extra user info.
     */
    private $userInfo = null;

    /**
     * Gets all User Infos at once.
     *
     * @return array
     */
    public function getUserInfos()
    {
        return [
            'provider' => $this->provider,
            'openid' => $this->openid,
            'email' => $this->email,
            'fullname' => $this->fullname,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'gender' => $this->gender,
            'language' => $this->language,
            'avatar' => $this->avatar,
            'link' => $this->link,
        ];
    }

    /**
     * Gets specified extra user info.
     * 
     * If `$attribute` is not exist in the basic user attrabutes, call `initUserInfoAttributes()` and merge the results into the basic user attrabutes.
     *
     * @param string $attribute
     * @return array|[]|null
     */
    protected function getUserInfo($attribute)
    {
        if ($this->userInfo === null) {

            ///Get extra user info code here ...
            $this->userInfo = $this->initUserInfoAttributes();

            ///If `$this->userInfo` is empty, Set as an empty array. Later will no longer call `$this->initUserInfoAttributes()` for better efficiency.
            if (empty($this->userInfo)) {
                $this->userInfo = [];
            } else {
                $this->setNormalizeUserAttributeMap($this->userInfoNormalizeUserAttributeMap());
                $this->setUserAttributes(array_merge($this->getUserAttributes(), $this->userInfo));
            }

        }
        return isset($this->getUserAttributes()[$attribute]) ? $this->getUserAttributes()[$attribute] : null;
    }

    /**
     * Gets extra user info.
     *
     * If needed, it can be overridden by trait-classes, e.g.:
     *
     * ```php
     * protected function initUserInfoAttributes()
     * {
     *    return $this->api("user/get_user_info", 'GET', ['oauth_consumer_key'=>$this->getUserAttributes()['client_id'], 'openid'=>$this->getUserAttributes()['openid']]);
     * }
     * ```
     *
     * @return null
     */
    protected function initUserInfoAttributes()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getProvider()
    {
        return isset($this->getUserAttributes()['provider']) ? $this->getUserAttributes()['provider'] : $this->getUserInfo('provider');
    }

    /**
     * @inheritdoc
     */
    public function getOpenid()
    {
        return isset($this->getUserAttributes()['openid']) ? $this->getUserAttributes()['openid'] : $this->getUserInfo('openid');
    }

    /**
     * @inheritdoc
     */
    public function getEmail()
    {
        return isset($this->getUserAttributes()['email']) ? $this->getUserAttributes()['email'] : $this->getUserInfo('email');
    }

    /**
     * @inheritdoc
     */
    public function getFullname()
    {
        return isset($this->getUserAttributes()['fullname']) ? $this->getUserAttributes()['fullname'] : $this->getUserInfo('fullname');
    }

    /**
     * @inheritdoc
     */
    public function getFirstname()
    {
        return isset($this->getUserAttributes()['firstname']) ? $this->getUserAttributes()['firstname'] : $this->getUserInfo('firstname');
    }

    /**
     * @inheritdoc
     */
    public function getLastname()
    {
        return isset($this->getUserAttributes()['lastname']) ? $this->getUserAttributes()['lastname'] : $this->getUserInfo('lastname');
    }

    /**
     * @inheritdoc
     */
    public function getGender()
    {
        return isset($this->getUserAttributes()['gender']) ? $this->getUserAttributes()['gender'] : $this->getUserInfo('gender');
    }

    /**
     * @inheritdoc
     */
    public function getLanguage()
    {
        return isset($this->getUserAttributes()['language']) ? $this->getUserAttributes()['language'] : $this->getUserInfo('language');
    }

    /**
     * @inheritdoc
     */
    public function getAvatar()
    {
        return isset($this->getUserAttributes()['avatar']) ? $this->getUserAttributes()['avatar'] : $this->getUserInfo('avatar');
    }

    /**
     * @inheritdoc
     */
    public function getLink()
    {
        return isset($this->getUserAttributes()['link']) ? $this->getUserAttributes()['link'] : $this->getUserInfo('link');
    }
}