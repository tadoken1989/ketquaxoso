<?php
namespace Core\Setting\Contracts;
interface SettingStorage
{
    /**
     * Set a setting by key and value
     *
     * @param string  $key
     * @param string  $value
     *
     * @return boolean
     */
    public function set($key, $value);

    /**
     * Get a setting by key, optionally set a default or fallback to config lookup
     *
     * @param string  $key
     * @param string  $default
     *
     * @return string|array|boolean
     */
    public function get($key, $default = null);

    /**
     * Forget a setting by key
     *
     * @param string $key
     *
     * @return boolean
     */
    public function forget($key);

    /**
     * Check a setting exists by key
     *
     * @param string $key
     *
     * @return boolean
     */
    public function has($key);

    /**
     * Get all stored settings
     *
     * @return array
     */
    public function all();
}
