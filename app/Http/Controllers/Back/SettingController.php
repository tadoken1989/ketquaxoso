<?php

namespace App\Http\Controllers\Back;

use App\{
    Http\Controllers\Controller, Http\Requests\SitesSettingsRequest
};
use Core\Setting\Entities\GroupSetting;
use Core\Setting\Entities\Setting;

class SettingController extends Controller
{

    /**
     * Show the settings page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function settingsEdit()
    {
        $groups = GroupSetting::with('settings')->get();
        return view('back.sites.settings', compact('groups'));

    }

    /**
     * Update settings
     *
     * @param \App\Http\Requests\SitesSettingsRequest $request
     */
    public function settingsUpdate(SitesSettingsRequest $sitesSettingsRequest)
    {
        if ($sitesSettingsRequest->isMethod('put')) {
            foreach (Setting::all() as $setting) {
                if ($sitesSettingsRequest->get($this->getSafeName($setting->name))) {
                    $setting->value = $sitesSettingsRequest->get($this->getSafeName($setting->name));
                    $setting->save();
                }
            }
            $cache = $this->checkCache() ? ' ' . __('Config cache has been updated.') : '';
            $sitesSettingsRequest->session()->flash('ok', __('Settings have been successfully saved. ') . $cache);
        }
        return redirect()->route('sites.edit', ['page' => $sitesSettingsRequest->page]);
    }

    /**
     * Check and refresh cache if exists
     *
     * @return bool
     */
    protected function checkCache()
    {
        if (file_exists(app()->getCachedConfigPath())) {
            \Artisan::call('config:clear');
            \Artisan::call('config:cache');
            return true;
        }
        return false;
    }

    protected function getSafeName($name)
    {
        return str_replace('.', '_', $name);
    }
}
