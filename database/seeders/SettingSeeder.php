<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createSettings($this->settingStructure());
    }
    
    private function createSettings($structure)
    {
        foreach ($structure as $key => $item) {
            Setting::create([
                'key' => $item['key'],
                'name' => $item['name'] ?? $item['key'],
                'value' => $item['value'],
                'default' => $item['default'] ?? $item['value'],
                'type' => $item['type'] ?? 'text',
                'options' => $item['options'] ?? null,
            ]);
        }
    }
    
    private function settingStructure()
    {
        return [
            [
                'key' => 'app.language',
                'name' => 'Default Language',
                'value' => 'en',
            ],
            [
                'key' => 'app.version',
                'name' => 'Default Version',
                'value' => 'bdsp-classic',
            ],
            [
                'key' => 'app.dateformat',
                'name' => 'Default Date Format',
                'value' => 'Y-m-d',
            ],
            [
                'key' => 'app.datetimeformat',
                'name' => 'Default DateTime Format',
                'value' => 'Y-m-d H:i:s',
            ],
            [
                'key' => 'app.timezone',
                'name' => 'Default TimeZone',
                'value' => 'UTC',
                'type' => 'select',
                'options' => implode(',', timezone_identifiers_list()),
            ],
            [
                'key' => 'app.decimal',
                'name' => 'Default Decimal Seperator',
                'value' => '.',
            ],
            [
                'key' => 'db.timezone',
                'name' => 'Database TimeZone',
                'value' => 'UTC',
                'type' => 'select',
                'options' => implode(',', timezone_identifiers_list()),
            ],
            [
                'key' => 'db.datetimeformat',
                'name' => 'Database DateTime Format',
                'value' => 'Y-m-d H:i:s',
            ],
            [
                'key' => 'importer.blacklist.ability',
                'name' => 'Ability Import Blacklist',
                'value' => 'defeatist,mummy,zen-mode,aura-break,cheek-pouch,dark-aura,fairy-aura,parental-bond,pixilate,stance-change,sweet-veil,symbiosis,battery,battle-bond,beast-boost,berserk,comatose,dancer,dazzling,disguise,emergency-exit,full-metal-body,innards-out,power-construct,power-of-alchemy,prism-armor,queenly-majesty,receiver,rks-system,schooling,shadow-shield,shields-down,soul-heart,stamina,steelworker,tangling-hair,water-bubble,water-compaction,wimp-out,as-one-glastrier,as-one-spectrier,ball-fetch,chilling-neigh,cotton-down,curious-medicine,dauntless-shield,dragons-maw,gorilla-tactics,grim-neigh,gulp-missile,hunger-switch,ice-face,ice-scales,intrepid-sword,libero,mirror-armor,pastel-veil,perish-body,power-spot,punk-rock,quick-draw,sand-spit,stalwart,steam-engine,steely-spirit,transistor,unseen-fist'
            ],
            [
                'key' => 'importer.blacklist.type',
                'name' => 'Type Import Blacklist',
                'value' => 'shadow'
            ],
            [
                'key' => 'importer.blacklist.move',
                'name' => 'Move Import Blacklist',
                'value' => 'gear-grind,shift-gear,head-charge,fire-lash,ice-burn,freeze-shock,relic-song,techno-blast,light-of-ruin,kings-shield,flying-press,fairy-lock,forests-curse,trick-or-treat,lands-wrath,thousand-arrows,thousand-waves,core-enforcer,diamond-storm,hyperspace-hole,hyperspace-fury,steam-eruption,beak-blast,revelation-dance,baneful-bunker,trop-kick,multi-attack,zing-zap,anchor-shot,clanging-scales,clangorous-soul,natures-madness,sunsteel-strike,moongeist-beam,prismatic-laser,photon-geyser,fleur-cannon,mind-blown,branch-poke,drum-beating,pyro-ball,snap-trap,grav-apple,apple-acid,overdrive,teatime,bolt-beak,fishious-rend,false-surrender,spirit-break,obstruct,meteor-assault,decorate,aura-wheel,dragon-darts,behemoth-blade,behemoth-bash,eternabeam,dynamax-cannon,wicked-blow,surging-strikes,jungle-healing,thunder-cage,dragon-energy,glacial-lance,astral-barrage,shell-side-arm,shadow-bone,strange-steam,freezing-glare,thunderous-kick,fiery-wrath,eerie-spell,breakneck-blitz--physical,breakneck-blitz--special,all-out-pummeling--physical,all-out-pummeling--special,supersonic-skystrike--physical,supersonic-skystrike--special,acid-downpour--physical,acid-downpour--special,tectonic-rage--physical,tectonic-rage--special,continental-crush--physical,continental-crush--special,savage-spin-out--physical,savage-spin-out--special,never-ending-nightmare--physical,never-ending-nightmare--special,corkscrew-crash--physical,corkscrew-crash--special,inferno-overdrive--physical,inferno-overdrive--special,hydro-vortex--physical,hydro-vortex--special,bloom-doom--physical,bloom-doom--special,gigavolt-havoc--physical,gigavolt-havoc--special,shattered-psyche--physical,shattered-psyche--special,subzero-slammer--physical,subzero-slammer--special,devastating-drake--physical,devastating-drake--special,black-hole-eclipse--physical,black-hole-eclipse--special,twinkle-tackle--physical,twinkle-tackle--special,catastropika,sinister-arrow-raid,malicious-moonsault,oceanic-operetta,guardian-of-alola,soul-stealing-7-star-strike,stoked-sparksurfer,pulverizing-pancake,extreme-evoboost,genesis-supernova,10-000-000-volt-thunderbolt,light-that-burns-the-sky,searing-sunraze-smash,menacing-moonraze-maelstrom,lets-snuggle-forever,splintered-stormshards,clangorous-soulblaze,zippy-zap,splishy-splash,floaty-fall,pika-papow,sparkly-swirl,veevee-volley,max-guard,dynamax-cannon,max-flare,max-flutterby,max-lightning,max-strike,max-knuckle,max-phantasm,max-hailstorm,max-ooze,max-geyser,max-airstream,max-starfall,max-wyrmwind,max-mindstorm,max-rockfall,max-quake,max-darkness,max-overgrowth,max-steelspike,shadow-rush,shadow-blast,shadow-blitz,shadow-bolt,shadow-break,shadow-chill,shadow-end,shadow-fire,shadow-rave,shadow-storm,shadow-wave,shadow-down,shadow-half,shadow-hold,shadow-mist,shadow-panic,shadow-shed,shadow-sky'
            ],
            [
                'key' => 'importer.blacklist.move-learn-method',
                'name' => 'Move Learn Method Import Blacklist',
                'value' => 'stadium-surfing-pikachu,light-ball-egg,colosseum-purification,xd-shadow,xd-purification,xd-purification,zygarde-cube'
            ],
        ];
    }
}
