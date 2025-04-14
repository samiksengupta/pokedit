<?php

namespace App\Services;

use DB;
// use \App\Models\Type;
use App\Models\Setting;
// use \App\Models\Move;
// use \App\Models\Form;
// use \App\Models\Shape;
// use \App\Models\Color;
use App\Models\Version;
use App\Models\Language;
// use \App\Models\Ability;
// use \App\Models\Habitat;
// use \App\Models\Species;
use App\Models\MoveFlag;
// use \App\Models\EggGroup;
use App\Models\Generation;
// use \App\Models\MoveTarget;
// use \App\Models\GrowthRate;
use App\Models\GenderRatio;
// use \App\Models\MoveFunction;
// use \App\Models\DamageCategory;
// use \App\Models\MoveLearnMethod;
// use \App\Models\ContestCondition;

class PokeApiImporter {

    public static function import(string $resourceType, string $resourceId, array $payload): bool
    {
        return match ($resourceType) {
            'language' => static::importLanguage($resourceId, $payload),
            'generation' => static::importGeneration($resourceId, $payload),
            'ability' => static::importAbility($resourceId, $payload),
            'type' => static::importType($resourceId, $payload),
            'move-damage-class' => static::importDamageCategory($resourceId, $payload),
            'contest-type' => static::importContestCondition($resourceId, $payload),
            'move-target' => static::importTarget($resourceId, $payload),
            'move' => static::importMove($resourceId, $payload),
            'move-learn-method' => static::importMoveLearnMethod($resourceId, $payload),
            'egg-group' => static::importEggGroup($resourceId, $payload),
            'growth-rate' => static::importGrowthRate($resourceId, $payload),
            'pokemon-habitat' => static::importHabitat($resourceId, $payload),
            'pokemon-shape' => static::importShape($resourceId, $payload),
            'pokemon-color' => static::importColor($resourceId, $payload),
            'pokemon-species' => static::importSpecies($resourceId, $payload),
            'generation' => static::importGeneration($resourceId, $payload),
            'ability' => static::importAbility($resourceId, $payload),
            'type' => static::importType($resourceId, $payload),
            'move-damage-class' => static::importDamageCategory($resourceId, $payload),
            'contest-type' => static::importContestCondition($resourceId, $payload),
            'move-target' => static::importTarget($resourceId, $payload),
            'move' => static::importMove($resourceId, $payload),
            'move-learn-method' => static::importMoveLearnMethod($resourceId, $payload),
            'egg-group' => static::importEggGroup($resourceId, $payload),
            'growth-rate' => static::importGrowthRate($resourceId, $payload),
            'pokemon-habitat' => static::importHabitat($resourceId, $payload),
            'pokemon-shape' => static::importShape($resourceId, $payload),
            'pokemon-color' => static::importColor($resourceId, $payload),
            'generation' => static::importGeneration($resourceId, $payload),
            'ability' => static::importAbility($resourceId, $payload),
            'type' => static::importType($resourceId, $payload),
            'move-damage-class' => static::importDamageCategory($resourceId, $payload),
            'contest-type' => static::importContestCondition($resourceId, $payload),
            'move-target' => static::importTarget($resourceId, $payload),
            'move' => static::importMove($resourceId, $payload),
            'move-learn-method' => static::importMoveLearnMethod($resourceId, $payload),
            'egg-group' => static::importEggGroup($resourceI, $payload),
            'growth-rate' => static::importGrowthRate($resourceId, $payload),
            'pokemon-habitat' => static::importHabitat($resourceId, $payload),
            'pokemon-shape' => static::importShape($resourceId, $payload),
            'pokemon-color' => static::importColor($resourceId, $payload),
            'pokemon-species' => static::importSpecies($resourceId, $payload),
            // 'version' => static::importVersion($resourceId, $payload),
            // 'version-group' => static::importVersionGroup($resourceId, $payload),
            default => false,
        };
        return false;
    }

    public static function truncate(string $resourceType)
    {
        set_time_limit(3000);
        DB::statement('PRAGMA foreign_keys = OFF');
        switch($resourceType) {
            case 'language': Language::all()->each(fn($model) => $model->delete()); Language::truncate(); break;
            case 'generation': Generation::all()->each(fn($model) => $model->delete()); Generation::truncate(); break;
            case 'ability': Ability::all()->each(fn($model) => $model->delete()); Ability::truncate(); break;
            case 'type': Type::all()->each(fn($model) => $model->delete()); Type::truncate(); break;
            case 'move-damage-class': DamageCategory::all()->each(fn($model) => $model->delete()); DamageCategory::truncate(); break;
            case 'contest-type': ContestCondition::all()->each(fn($model) => $model->delete()); ContestCondition::truncate(); break;
            case 'move-target': MoveTarget::all()->each(fn($model) => $model->delete()); MoveTarget::truncate(); break;
            case 'move': Move::all()->each(fn($model) => $model->delete()); Move::truncate(); break;
            case 'move-learn-method': MoveLearnMethod::all()->each(fn($model) => $model->delete()); MoveLearnMethod::truncate(); break;
            case 'egg-group': EggGroup::all()->each(fn($model) => $model->delete()); EggGroup::truncate(); break;
            case 'growth-rate': GrowthRate::all()->each(fn($model) => $model->delete()); GrowthRate::truncate(); break;
            case 'pokemon-habitat': Habitat::all()->each(fn($model) => $model->delete()); Habitat::truncate(); break;
            case 'pokemon-shape': Shape::all()->each(fn($model) => $model->delete()); Shape::truncate(); break;
            case 'pokemon-color': Color::all()->each(fn($model) => $model->delete()); Color::truncate(); break;
            case 'pokemon-species': Species::all()->each(fn($model) => $model->delete()); Species::truncate(); Form::truncate(); break;
        }
        DB::statement('PRAGMA foreign_keys = ON');
        return true;
    }

    public static function importLanguage(string $name, array $payload): bool
    {
        Language::upsert(
            [
                'slug' => $payload['name'],
                'created_at' => now(),
                'updated_at' => now()
            ],
            ['slug'],
            ['updated_at']
        );
        return true;
    }

    public static function importGeneration(string $name, array $payload): bool
    {
        $version = Version::where('slug', Setting::find('app.version')->value ?? null)->firstOrFail();
        Generation::upsert(
            [
                'slug' => $name,
                'version_id' => $version->id,
                'created_at' => now(), 
                'updated_at' => now()
            ],
            ['slug'],
            ['updated_at']
        );
        return true;
    }

    // public static function importAbility($name)
    // {
    //     $blacklist = explode(',', Setting::find('importer.blacklist.ability')->value ?? '');
    //     if(\in_array($name, $blacklist)) return true;

    //     $api = new PokeApi;
    //     $data = json_decode($api->ability($name));
    //     if(!$data->is_main_series) return true;

    //     $version = Version::where('slug', Setting::find('app.version')->value ?? null)->firstOrFail();
    //     $generation = Generation::where('slug', $data->generation->name ?? null)->first();

    //     $ability = Ability::firstOrNew([
    //         'slug' => $name,
    //         'version_id' => $version->id
    //     ], []);

    //     $ability->version()->associate($version);
    //     $ability->generation()->associate($generation);

    //     $ability->names = static::getNamesCollection($data);
    //     $ability->effectTexts = static::getEffectTextsCollection($data);
    //     $ability->flavorTexts = static::getFlavorTextsCollection($data, 'sword-shield');
    //     // $ability->flavorTexts = static::getEffectTextsCollection($data,  $version->pokeapi_version_group);
        
    //     $ability->save();
    //     return true;
    // }
    
    // public static function importType($name)
    // {
    //     $blacklist = explode(',', Setting::find('importer.blacklist.type')->value ?? '');
    //     if(\in_array($name, $blacklist)) return true;

    //     $api = new PokeApi;
    //     $data = json_decode($api->pokemonType($name));

    //     $version = Version::where('slug', Setting::find('app.version')->value ?? null)->firstOrFail();

    //     $type = Type::firstOrNew(['slug' => $name], []);

    //     $type->version()->associate($version);

    //     $type->names = static::getNamesCollection($data);
        
    //     $type->save();
    //     return true;
    // }

    // public static function importDamageCategory($name)
    // {
    //     $api = new PokeApi;
    //     $data = json_decode($api->moveDamageClass($name));
    //     DamageCategory::upsert(['slug' => $name], []);
    //     return true;
    // }

    // public static function importContestCondition($name)
    // {
    //     $api = new PokeApi;
    //     $data = json_decode($api->contestType($name));
    //     ContestCondition::upsert(['slug' => $name], []);
    //     return true;
    // }

    // public static function importTarget($name)
    // {
    //     $api = new PokeApi;
    //     $data = json_decode($api->moveTarget($name));
    //     MoveTarget::upsert(['slug' => MoveTarget::getLocalName($name)], []);
    //     return true;
    // }

    // public static function importMove($name)
    // {
    //     $blacklist = explode(',', Setting::find('importer.blacklist.move')->value ?? '');
    //     if(\in_array($name, $blacklist)) return true;

    //     $api = new PokeApi;
    //     $data = json_decode($api->move($name));

    //     $version = Version::where('slug', Setting::find('app.version')->value ?? null)->firstOrFail();
    //     $generation = Generation::where('slug', $data->generation->name ?? null)->first();
    //     $type = Type::where('slug', $data->type->name ?? null)->first();
    //     $damageCategory = DamageCategory::where('slug', $data->damage_class->name ?? null)->first();
    //     $contestCondition = ContestCondition::where('slug', $data->contest_type->name ?? null)->first();
    //     $moveTarget = MoveTarget::where('slug', MoveTarget::getLocalName($data->target->name ?? null))->first();

    //     $move = Move::firstOrNew([
    //         'slug' => $name,
    //         'version_id' => $version->id
    //     ], [
    //         'pp' => $data->pp ?? 0,
    //         'power' => $data->power ?? 0,
    //         'accuracy' => $data->accuracy ?? 0,
    //         'priority' => $data->priority ?? 0,
    //         'effect_chance' => $data->effect_chance ?? 0,
    //     ]);

    //     $move->type()->associate($type);
    //     $move->damageCategory()->associate($damageCategory);
    //     $move->contestCondition()->associate($contestCondition);
    //     $move->moveTarget()->associate($moveTarget);
    //     $move->version()->associate($version);
    //     $move->generation()->associate($generation);

    //     $move->names = static::getNamesCollection($data);
    //     $move->effectTexts = static::getEffectTextsCollection($data);
    //     $move->flavorTexts = static::getFlavorTextsCollection($data, 'ultra-sun-ultra-moon');
        
    //     $move->save();
    //     return true;
    // }

    // public static function importMoveLearnMethod($name)
    // {
    //     $blacklist = explode(',', Setting::find('importer.blacklist.move-learn-method')->value ?? '');
    //     if(\in_array($name, $blacklist)) return true;

    //     $api = new PokeApi;
    //     $data = json_decode($api->moveLearnMethod($name));
    //     MoveLearnMethod::upsert(['slug' => $name], []);
    //     return true;
    // }

    // public static function importEggGroup($name)
    // {
    //     $api = new PokeApi;
    //     $data = json_decode($api->eggGroup($name));
    //     EggGroup::upsert(['slug' => $name], []);
    //     return true;
    // }

    // public static function importGrowthRate($name)
    // {
    //     $api = new PokeApi;
    //     $data = json_decode($api->growthRate($name));
    //     GrowthRate::upsert(['slug' => $name], []);
    //     return true;
    // }

    // public static function importHabitat($name)
    // {
    //     $api = new PokeApi;
    //     $data = json_decode($api->pokemonHabitat($name));
    //     Habitat::upsert(['slug' => $name], []);
    //     return true;
    // }

    // public static function importShape($name)
    // {
    //     $api = new PokeApi;
    //     $data = json_decode($api->pokemonShape($name));
    //     Shape::upsert(['slug' => $name], []);
    //     return true;
    // }

    // public static function importColor($name)
    // {
    //     $api = new PokeApi;
    //     $data = json_decode($api->pokemonColor($name));
    //     Color::upsert(['slug' => $name], []);
    //     return true;
    // }

    // public static function importSpecies($name)
    // {
    //     $blacklist = explode(',', Setting::find('importer.blacklist.species')->value ?? '');
    //     if(\in_array($name, $blacklist)) return true;

    //     $api = new PokeApi;
    //     $data = json_decode($api->pokemonSpecies($name));

    //     $maxSpeciesId = intval(Setting::find('importer.maxspeciesid')->value ?? '493');
    //     if($data->id > $maxSpeciesId) return true;

    //     $genderRatio = GenderRatio::where('slug', GenderRatio::getLocalName($data->gender_rate))->first();
    //     $eggGroup1 = EggGroup::where('slug', $data->egg_groups[0]->name ?? null)->first();
    //     $eggGroup2 = EggGroup::where('slug', $data->egg_groups[1]->name ?? null)->first() ?? $eggGroup1;
    //     $growthRate = GrowthRate::where('slug', $data->growth_rate->name ?? null)->first();
    //     $habitat = Habitat::where('slug', $data->habitat->name ?? null)->first();
    //     $shape = Shape::where('slug', $data->shape->name ?? null)->first();
    //     $color = Color::where('slug', $data->color->name ?? null)->first();
    //     $generation = Generation::where('slug', $data->generation->name ?? null)->first();
    //     $version = Version::where('slug', Setting::find('app.version')->value ?? null)->firstOrFail();

    //     $species = Species::firstOrNew([
    //         'slug' => $name,
    //         'version_id' => $version->id
    //     ], [
    //         'base_happiness' => $data->base_happiness ?? 0,
    //         'catch_rate' => $data->capture_rate ?? 0,
    //         'hatch_counter' => $data->hatch_counter ?? 0,
    //     ]);

    //     $species->genderRatio()->associate($genderRatio);
    //     $species->eggGroup1()->associate($eggGroup1);
    //     $species->eggGroup2()->associate($eggGroup2);
    //     $species->growthRate()->associate($growthRate);
    //     $species->habitat()->associate($habitat);
    //     $species->shape()->associate($shape);
    //     $species->color()->associate($color);
    //     $species->generation()->associate($generation);
    //     $species->version()->associate($version);

    //     $species->names = static::getNamesCollection($data);
    //     $species->genera = static::getGeneraCollection($data);
    //     $species->flavorTexts = static::getCompiledFlavorTextsCollection($data, ['platinum', 'heartgold', 'soulsilver']);
    //     $species->forms = static::getFormsCollection($data, 'platinum');
        
    //     $species->save();
    //     return true;
    // }

    // public static function importVersion($name)
    // {
    //     $api = new PokeApi;
    //     $data = json_decode($api->version($name));
    //     dd(json_decode($data));
    //     return true;
    // }

    // public static function importVersionGroup($name)
    // {
    //     $api = new PokeApi;
    //     $data = json_decode($api->versionGroup($name));
    //     dd(json_decode($data));
    //     return true;
    // }

    // private static function getNamesCollection($data) 
    // {
    //     return Language::select(['id', 'slug'])->orderBy('id')->get()->map(function($language) use($data) {
    //         $nameEntry = collect($data->names)->first(function($name) use($language){
    //             return $name->language->name === $language->slug;
    //         });
    //         return (object) [
    //             'language' => $language->slug,
    //             'name' => $nameEntry->name ?? ""
    //         ];
    //     })->keyBy('language');
    // }

    // private static function getEffectTextsCollection($data) 
    // {
    //     return Language::select(['id', 'slug'])->orderBy('id')->get()->map(function($language) use($data) {
    //         $effectEntry = collect($data->effect_entries)->first(function($effectEntry) use($language){
    //             return $effectEntry->language->name === $language->slug;
    //         });
    //         return (object) [
    //             'language' => $language->slug,
    //             'effect_text' => $effectEntry->effect ?? "",
    //             'short_effect_text' => $effectEntry->short_effect ?? ""
    //         ];
    //     })->keyBy('language');
    // }

    // private static function getFlavorTextsCollection($data, $versionGroup) 
    // {

    //     $data = collect($data->flavor_text_entries)->filter(function($value) use($versionGroup) {
    //         if(property_exists($value, 'version_group')) return $value->version_group->name === $versionGroup;
    //         else if(property_exists($value, 'version')) return $value->version->name === $versionGroup;
    //         else return false;
    //     });

    //     return Language::select(['id', 'slug'])->orderBy('id')->get()->map(function($language) use($data) {
    //         $flavorTextEntry = $data->first(function($flavorText) use($language){
    //             return $flavorText->language->name === $language->slug;
    //         });
    //         return (object) [
    //             'language' => $language->slug,
    //             'flavor_text' => $flavorTextEntry->flavor_text ?? ""
    //         ];
    //     })->keyBy('language');
    // }

    // private static function getCompiledFlavorTextsCollection($data, $versionGroups) 
    // {

    //     $data = collect($data->flavor_text_entries)->filter(function($value) use($versionGroups) {
    //         if(property_exists($value, 'version')) return \in_array($value->version->name, $versionGroups);
    //     });

    //     return Language::select(['id', 'slug'])->orderBy('id')->get()->map(function($language) use($data) {
    //         $flavorTextEntries = $data->filter(function($flavorText) use($language){
    //             return $flavorText->language->name === $language->slug;
    //         })->values();
    //         return (object) [
    //             'language' => $language->slug,
    //             'flavor_text' => \implode(' ', $flavorTextEntries->map(fn($flavorText) => $flavorText->flavor_text)->toArray())
    //         ];
    //     })->keyBy('language');
    // }

    // private static function getGeneraCollection($data) 
    // {
    //     return Language::select(['id', 'slug'])->orderBy('id')->get()->map(function($language) use($data) {
    //         $genusEntry = collect($data->genera)->first(function($genus) use($language){
    //             return $genus->language->name === $language->slug;
    //         });
    //         return (object) [
    //             'language' => $language->slug,
    //             'genus' => $genusEntry->genus ?? ""
    //         ];
    //     })->keyBy('language');
    // }

    // private static function getFormsCollection($data, $version)
    // {
    //     $forms = [];
    //     $api = new PokeApi;
    //     collect($data->varieties)->each(function($variety) use($api, $data, $version, &$forms) {
    //         $varietyData = json_decode($api->pokemon($variety->pokemon->name));
    //         $varietyForms = collect($varietyData->forms)->filter(function($varietyForm) use($api) {
    //             $varietyFormData = json_decode($api->pokemonForm($varietyForm->name));
    //             return (\in_array($varietyFormData->version_group->name, ['red-blue', 'gold-silver', 'ruby-sapphire', 'firered-leafgreen', 'emerald', 'diamond-pearl', 'platinum']) || \in_array($varietyFormData->name, ['arceus-fairy']));
    //         })->map(fn($varietyForm) => json_decode($api->pokemonForm($varietyForm->name)))->sort(fn($a, $b) => $a->form_order - $b->form_order);
    //         if($varietyForms->isNotEmpty()) {
    //             // dump($varietyForms, $varietyData);
    //             $varietyForms->each(function($varietyForm) use($varietyData, $data, $version, &$forms) {
    //                 $hp = collect($varietyData->stats)->first(fn($stat) => $stat->stat->name === 'hp');
    //                 $attack = collect($varietyData->stats)->first(fn($stat) => $stat->stat->name === 'attack');
    //                 $defense = collect($varietyData->stats)->first(fn($stat) => $stat->stat->name === 'defense');
    //                 $speed = collect($varietyData->stats)->first(fn($stat) => $stat->stat->name === 'speed');
    //                 $specialAttack = collect($varietyData->stats)->first(fn($stat) => $stat->stat->name === 'special-attack');
    //                 $specialDefense = collect($varietyData->stats)->first(fn($stat) => $stat->stat->name === 'special-defense');
    //                 $type1 = collect($varietyForm->types)->first(fn($type) => $type->slot === 1);
    //                 $type2 = collect($varietyForm->types)->first(fn($type) => $type->slot === 2) ?? $type1;
    //                 // $item1 = collect($varietyData->held_items)->first(fn($item) => $item->version_details->first(fn($versionDetails) => $versionDetails->version->name === $version)->rarity >= 50);
    //                 // $item2 = collect($varietyData->held_items)->first(fn($item) => $item->version_details->first(fn($versionDetails) => $versionDetails->version->name === $version)->rarity = 5);
    //                 $ability1 = collect($varietyData->abilities)->first(fn($ability) => $ability->slot === 1);
    //                 $ability2 = collect($varietyData->abilities)->first(fn($ability) => $ability->slot === 2) ?? $ability1;
    //                 $ability3 = collect($varietyData->abilities)->first(fn($ability) => $ability->slot === 3) ?? $ability1;
    //                 $forms[] = (object) [
    //                     'slug' => $varietyForm->form_name ? "{$data->name}-{$varietyForm->form_name}" : $data->name,
    //                     'base_hp' => $hp->base_stat,
    //                     'base_atk' => $attack->base_stat,
    //                     'base_def' => $defense->base_stat,
    //                     'base_spe' => $speed->base_stat,
    //                     'base_spa' => $specialAttack->base_stat,
    //                     'base_spd' => $specialDefense->base_stat,
    //                     'yield_hp' => $hp->effort,
    //                     'yield_atk' => $attack->effort,
    //                     'yield_def' => $defense->effort,
    //                     'yield_spe' => $speed->effort,
    //                     'yield_spa' => $specialAttack->effort,
    //                     'yield_spd' => $specialDefense->effort,
    //                     'base_experience' => $varietyData->base_experience,
    //                     'height' => $varietyData->height,
    //                     'weight' => $varietyData->weight,
    //                     'type_1' => Type::where('slug', $type1->type->name ?? null)->first(),
    //                     'type_2' => Type::where('slug', $type2->type->name ?? null)->first(),
    //                     'item_1' => null,
    //                     'item_2' => null,
    //                     'ability_1' => Ability::where('slug', $ability1->ability->name ?? null)->first(),
    //                     'ability_2' => Ability::where('slug', $ability2->ability->name ?? null)->first(),
    //                     'ability_3' => Ability::where('slug', $ability3->ability->name ?? null)->first(),
    //                     'names' => static::getFormNamesCollection($varietyForm, $data),
    //                     'moves' => static::getFormMovesCollection($varietyData, 'ultra-sun-ultra-moon')
    //                 ];
    //             });
    //         }
    //     });

    //     // $forms = collect($forms);

    //     /* if($forms->filter(fn($form) => $form->slug === $forms->first()->slug)->count() > 1) $forms = $forms->map(function($form, $key) {
    //         $index = $key + 1;
    //         $form->slug = "{$form->slug}-forme-{$index}";
    //         return $form;
    //     }); */

    //     return $forms;
    // }

    // private static function getFormNamesCollection($data, $fallback) 
    // {
    //     $names = collect($data->form_names);
    //     if($names->isEmpty()) return static::getNamesCollection($fallback);
    //     return Language::select(['id', 'slug'])->orderBy('id')->get()->map(function($language) use($names) {
    //         $nameEntry = $names->first(function($name) use($language){
    //             return $name->language->name === $language->slug;
    //         });
    //         return (object) [
    //             'language' => $language->slug,
    //             'name' => $nameEntry->name ?? ""
    //         ];
    //     })->keyBy('language');
    // }

    // private static function getFormMovesCollection($data, $versionGroupName)
    // {
    //     $moves = collect($data->moves)->reject(fn($move) => null === collect($move->version_group_details)->first(fn($version) => $version->version_group->name === $versionGroupName))->map(function($move) use($versionGroupName) {
    //         $versionGroupDetails = collect($move->version_group_details)->first(fn($version) => $version->version_group->name === $versionGroupName);
    //         return (object) [
    //             'move_id' => Move::where('slug', $move->move->name)->first()->id ?? null,
    //             'move_name' => $move->move->name,
    //             'move_learn_method_id' => MoveLearnMethod::where('slug', $versionGroupDetails->move_learn_method->name)->first()->id ?? MoveLearnMethod::where('slug', 'egg')->first()->id,
    //             'level' => $versionGroupDetails->move_learn_method->name === 'level-up' ? $versionGroupDetails->level_learned_at : null,
    //         ];
    //     })->reject(fn($move) => !$move->move_id || !$move->move_learn_method_id)->sortBy([
    //         ['move_learn_method_id', 'asc'],
    //         ['level', 'asc']
    //     ])->values();
    //     // dd($data->moves, $moves);
    //     return $moves;
    // }
}