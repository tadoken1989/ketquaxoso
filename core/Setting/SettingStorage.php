<?php
namespace Core\Setting;

use Core\Setting\Contracts\SettingStorage as SettingStorageContract;
use Illuminate\Contracts\Cache\Repository as Cache;
use Core\Setting\Entities\Setting;

class SettingStorage implements SettingStorageContract
{
    const CACHE_ID = 'settings';

    protected $expiredMinutes = 60;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * Construct Setter
     *
     * @param Cache $cache
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    protected function refresh()
    {
        $this->cache();
    }

    protected function cache()
    {
        $this->cache->put('settings', $this->fetch(), $this->expiredMinutes);
    }

    protected function fetch()
    {
        $settings = [];
        foreach (Setting::all() as $setting) {
            $settings[$setting->name] = $setting->value;
        }

        return $settings;
    }

    /**
     * Set a setting by key and value
     *
     * @param string $key
     * @param string $value
     *
     * @return boolean
     */
    public function set($key, $value)
    {
        if (!$this->has($key)) {
            return false;
        }

        Setting::where('name', $key)->update(['value' => $value]);
        $this->refresh();

        return true;
    }

    /**
     * Get a setting by key, optionally set a default or fallback to config lookup
     *
     * @param string $key
     * @param string $default
     *
     * @return string|array|boolean
     */
    public function get($key, $default = null)
    {
        $settings = $this->all();
        if (array_key_exists($key, $settings)) {
            if ($key == "grab.link") {
                $value = preg_replace("/(\r\n)+/", "\r\n", trim($settings[$key]));
                return explode("\r\n", $value);
            }
            return $settings[$key];
        }

        return $default;
    }

    /**
     * Forget a setting by key
     *
     * @param string $key
     *
     * @return boolean
     */
    public function forget($key)
    {
        return $this->set($key, null);
    }

    /**
     * Check a setting exists by key
     *
     * @param string $key
     *
     * @return boolean
     */
    public function has($key)
    {
        $settings = $this->all();
        return array_key_exists($key, $settings);
    }

    /**
     * Get all stored settings
     *
     * @return array
     */
    public function all()
    {
        if (!$this->cache->has(self::CACHE_ID)) {
            $this->cache();
        }

        return $this->cache->get(self::CACHE_ID);
    }
}
