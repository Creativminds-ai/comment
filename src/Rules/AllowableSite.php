<?php

namespace Creativminds\Comment\Rules;

use Illuminate\Contracts\Validation\Rule;

class AllowableSite implements Rule
{
    protected $site;

    public function passes($attribute, $value)
    {
        $allowableSites = config('comment.allowable_sites');

        if (count($allowableSites) < 1) return true;

        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $value, $match);

        foreach ($match[0] as $url) {
            $host = parse_url($url, PHP_URL_HOST);
            if (!in_array($host, $allowableSites)) {
                $this->site = $host;
                return false;
            }
        }

        return true;
    }


    public function message()
    {
        return __('comment::comment.validation.black_site', [
            'site' => $this->site
        ]);
    }
}
