<?php

namespace App\Console\Commands;

use App\Models\Word;
use Illuminate\Console\Command;

class RegisterWords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'register:words';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = base_path('words/words_dictionary.json');

        $dataArray = json_decode(file_get_contents($path), true);

        $keys = array_keys($dataArray);

        foreach ($keys as $key) {
            Word::query()->updateOrInsert([
                'word' => $key,
                'created_at' => now()
            ]);
        }

    }
}
