<?php

namespace Trin4ik\RussianCity\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Trin4ik\RussianCity\Models\City;
use Trin4ik\RussianCity\Models\CityOkrug;
use Trin4ik\RussianCity\Models\CityRegion;
use Illuminate\Support\Arr;

class ParseRussianCity extends Command
{
    protected $signature = 'russiancity:parse';

    protected $description = 'Parse russian city';

    public function handle()
    {
        $this->info('http to wiki...');

        $response = Http::get('https://ru.wikipedia.org/wiki/%D0%A1%D0%BF%D0%B8%D1%81%D0%BE%D0%BA_%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D0%BE%D0%B2_%D0%A0%D0%BE%D1%81%D1%81%D0%B8%D0%B8');

        if ($response->successful()) {
            $this->info('parse response...');
            //preg_match_all('/<tr[^>]*>\s*<td[^>]*>[0-9]+<\/td>\s*<td[^>]*>\s*<a[^>]*>\s*<img alt="[^"]*" src="([^"]+)"[^>]*>\s*<\/a>\s*<\/td>\s*<td[^>]*>\s*<a href="([^"]+)"[^>]*>([^<]+)<\/a>\s*(<sup[^>]*>\s*<a[^>]*>[^<]*<\/a>\s*<\/sup>\s*)?<\/td>\s*<td[^>]*>\s*(<a[^>]*>)?([^<]+)?(<\/a>\s*)?<\/td>\s*<td[^>]*>\s*(<a[^>]*>)?([^<]+)?(<\/a>\s*)?<\/td>\s*<td data-sort-value="([^"])+"[^>]*>[^<]*(<sup[^>]*>\s*<a[^>]*>[^<]*<\/a>\s*<\/sup>\s*)?<\/td>/', $response->body(), $list_old);
            preg_match_all('/<tr[^>]*>\s*<td[^>]*>[0-9]+<\/td>\s*<td[^>]*>\s*<a[^>]*>\s*<img alt="[^"]*" src="(?P<image>[^"]+)"[^>]*>\s*<\/a>\s*<\/td>\s*<td[^>]*>\s*<a href="(?P<link>[^"]+)"[^>]*>(?P<name>[^<]+)<\/a>\s*(?:<sup[^>]*>\s*<a[^>]*>[^<]*<\/a>\s*<\/sup>\s*)?<\/td>\s*<td[^>]*>\s*(?:<a[^>]*>)?(?P<region>[^<]+)(?:<\/a>\s*)?<\/td>\s*<td[^>]*>\s*(?:<a[^>]*>)?(?P<okrug>[^<]+)(?:<\/a>\s*)?<\/td>\s*<td data-sort-value="(?P<population>[^"]+)"[^>]*>[^<]*(?:<sup[^>]*>\s*<a[^>]*>[^<]*<\/a>\s*<\/sup>\s*)?<\/td>\s*<td[^>]*>\s*(?:<span[^>]*>(?P<started2>[^<]*)<\/span>[^<]*)?(?:<a[^>]*>)?(?P<started>[^<]+)(?:<\/a>\s*)?(?:[^<]*<a[^>]*>[^<]*<\/a>\s*)?<\/td>\s*<td[^>]*>\s*(<span[^>]*>[^<]*<\/span>[^<]*)?(<a[^>]*>)?([^<]+)(<\/a>\s*)?([^<]*<a[^>]*>[^<]*<\/a>\s*)?<\/td>/', $response->body(), $list);
            //var_dump(array_diff($list_old[3], $list[3]));
            //print_r($list['started2']);
            //$this->error(count($list_old[1]));
            $this->info('find city: ' . count($list[1]));
            foreach ($list['name'] as $k => $v) {
                $city = [
                    'link' => $list['link'][$k],
                    'name' => $list['name'][$k],
                    'region' => $list['region'][$k],
                    'okrug' => $list['okrug'][$k],
                    'population' => (int)$list['population'][$k],
                    'started_at' => (int)$list['started2'][$k] ?: (int)$list['started'][$k],
                ];

                $okrug = CityOkrug::firstOrCreate(['name' => $city['okrug']]);
                $region = CityRegion::firstOrCreate(['name' => $city['region']]);

                $find = City::firstWhere([
                    'name' => $city['name'],
                    'region_id' => $region->id,
                    'okrug_id' => $okrug->id
                ]);

                if ($find) {
                    $find->fill(Arr::only($city, ['population', 'started_at']));
                    if ($find->wasChanged()) {
                        $this->comment($city['name'] . ': updated');
                    }
                } else {
                    City::create(array_merge($city, ['region_id' => $region->id, 'okrug_id' => $okrug->id]));
                    $this->comment($city['name'] . ': added');
                }
            }
        } else {
            $this->error('fail to parse wiki');
        }
        $this->info('done');
    }
}
