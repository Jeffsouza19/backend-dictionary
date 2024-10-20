<?php

namespace App\Repositories\Eloquents\Word;

use App\Models\WordLicense;
use App\Models\WordMeaning;
use App\Models\WordMeaningAntonym;
use App\Models\WordMeaningDefinition;
use App\Models\WordMeaningDefinitionAntonym;
use App\Models\WordMeaningDefinitionSynonym;
use App\Models\WordMeaningSynonym;
use App\Models\WordPhonetic;
use App\Models\WordPhoneticLicense;
use App\Models\WordSourceUrl;
use App\Repositories\Interfaces\Word\WordInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WordEloquent implements WordInterface
{
    private Model $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll($search, $limit): array
    {
        $paginate = $this
            ->model
            ->newQuery()
            ->when($search, function ($query, $search) {
                $query->where('word', 'like', $search . '%');
            })
            ->orderBy('word')
            ->cursorPaginate($limit);
        $count = $this->model->newQuery()->count();
        return compact('paginate', 'count');
    }

    public function createWord($word, $newWord)
    {
        return DB::transaction(function () use ($word, $newWord) {

            if (empty($word)) {
                $word = $this->model->newQuery()->create([
                    'word' => $newWord[0]->word,
                    'phonetic' => $newWord[0]->phonetic??null,
                ]);
            }else{
                $word->phonetic = $newWord[0]->phonetic??null;
                $word->save();
            }


            foreach ($newWord as $each_word){
                foreach ($each_word->phonetics as $each_phonetics){

                    $wordPhonetic = WordPhonetic::query()->create([
                        'word_id' => $word->id,
                        'text' => $each_phonetics->text??null,
                        'audio' => $each_phonetics->audio??null,
                        'sourceUrl' => $each_phonetics->sourceUrl??null,
                    ]);

                    if(!empty($each_phonetics->license)){
                        $wordPhoneticLicense = WordPhoneticLicense::query()->create([
                            'word_phonetic_id' => $wordPhonetic->id,
                            'name' => $each_phonetics->license->name,
                            'url' => $each_phonetics->license->url,
                        ]);
                    }
                }

                foreach ($each_word->meanings as $each_meaning){
                    $wordMeaning = WordMeaning::query()->create([
                        'word_id' => $word->id,
                        'partOfSpeech' => $each_meaning->partOfSpeech,
                    ]);

                    foreach ($each_meaning->definitions as $definition) {
                        $wordMeaningDefinitions = WordMeaningDefinition::query()->create([
                            'word_meaning_id' => $wordMeaning->id,
                            'definition' => $definition->definition??null,
                            'example' => $definition->example??null,
                        ]);

                        foreach ($definition->synonyms as $synonym){
                            $wordMeaningDefinitionsSynonyms = WordMeaningDefinitionSynonym::query()->create([
                                'word_meaning_definition_id' => $wordMeaningDefinitions->id,
                                'synonym' => $synonym
                            ]);
                        }

                        foreach ($definition->antonyms as $antonym){
                            $wordMeaningDefinitionsSynonyms = WordMeaningDefinitionAntonym::query()->create([
                                'word_meaning_definition_id' => $wordMeaningDefinitions->id,
                                'antonym' => $antonym
                            ]);
                        }

                    }

                    foreach ($each_meaning->synonyms as $synonym) {
                        WordMeaningSynonym::query()->create([
                            'word_meaning_id' => $wordMeaning->id,
                            'synonym' => $synonym
                        ]);
                    }

                    foreach ($each_meaning->antonyms as $antonym) {
                        WordMeaningAntonym::query()->create([
                            'word_meaning_id' => $wordMeaning->id,
                            'antonym' => $antonym
                        ]);
                    }
                }

                $wordLicense = WordLicense::query()->create([
                    'word_id' => $word->id,
                    'name' => $each_word->license->name,
                    'url' => $each_word->license->url,
                ]);

                foreach ($each_word->sourceUrls as $each_sourceUrl){
                    $wordSourceUrl = WordSourceUrl::query()->create([
                        'word_id' => $word->id,
                        'url' => $each_sourceUrl,
                    ]);
                }
            }
            return $word;
        });
    }

    public function getOne(string $word)
    {
        return $this->model->newQuery()->where(['word' => $word])->first();
    }

    public function update($id, array $data)
    {
        $result = $this->model->newQuery()->find($id);
        $result->update($data);

        return $result;
    }

    public function destroy($id)
    {
        return $this->model->newQuery()->delete();
    }

}
