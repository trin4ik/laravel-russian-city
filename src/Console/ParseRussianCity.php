<?php

namespace Trin4ik\RussianCity\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

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
            //preg_match_all('/<tr[^>]*>\s*<td[^>]*>[0-9]+<\/td>\s*<td[^>]*>\s*<a[^>]*>\s*<img alt="[^"]*" src="([^"]+)"[^>]*>\s*<\/a>\s*<\/td>\s*<td[^>]*>\s*<a href="([^"]+)"[^>]*>([^<]+)<\/a>/', $response->body(), $list_old);
            preg_match_all('/<tr[^>]*>\s*<td[^>]*>[0-9]+<\/td>\s*<td[^>]*>\s*<a[^>]*>\s*<img alt="[^"]*" src="([^"]+)"[^>]*>\s*<\/a>\s*<\/td>\s*<td[^>]*>\s*<a href="([^"]+)"[^>]*>([^<]+)<\/a>\s*(<sup[^>]*>\s*<a[^>]*>[^<]*<\/a>\s*<\/sup>\s*)?<\/td>\s*<td[^>]*>\s*(<a[^>]*>)?([^<]+)?(<\/a>\s*)?<\/td>\s*<td[^>]*>\s*(<a[^>]*>)?([^<]+)?(<\/a>\s*)?<\/td>/', $response->body(), $list);
            //var_dump(array_diff($list_old[1], $list[1]));
            //$this->error(count($list_old[1]));
            $this->error(count($list[1]));
        } else {
            $this->error('fial to parse wiki');
        }

        $this->info('Publishing configuration...');

        $this->info('Installed BlogPackage');
    }
}
