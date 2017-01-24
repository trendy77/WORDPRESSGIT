<?php

use Illuminate\Database\Seeder;

class MemesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('memes')->insert([
            'meme_name'             =>  'Bad Luck Brian',
            'upl_name'              =>  'memes/bad_luck_brian.jpg',
            'ext'                   =>  'jpg',
            'created_at'            =>  \Carbon\Carbon::now(),
            'updated_at'            =>  \Carbon\Carbon::now()
        ]);
        DB::table('memes')->insert([
            'meme_name'             =>  'Annoyed Picard',
            'upl_name'              =>  'memes/annoyed_picard.jpg',
            'ext'                   =>  'jpg',
            'created_at'            =>  \Carbon\Carbon::now(),
            'updated_at'            =>  \Carbon\Carbon::now()
        ]);
        DB::table('memes')->insert([
            'meme_name'             =>  'Toy Story',
            'upl_name'              =>  'memes/toy_story.jpg',
            'ext'                   =>  'jpg',
            'created_at'            =>  \Carbon\Carbon::now(),
            'updated_at'            =>  \Carbon\Carbon::now()
        ]);
        DB::table('memes')->insert([
            'meme_name'             =>  'Confession Bear',
            'upl_name'              =>  'memes/confession_bear.jpg',
            'ext'                   =>  'jpg',
            'created_at'            =>  \Carbon\Carbon::now(),
            'updated_at'            =>  \Carbon\Carbon::now()
        ]);
        DB::table('memes')->insert([
            'meme_name'             =>  'Dancing Kids',
            'upl_name'              =>  'memes/dancing_kids.jpg',
            'ext'                   =>  'jpg',
            'created_at'            =>  \Carbon\Carbon::now(),
            'updated_at'            =>  \Carbon\Carbon::now()
        ]);
        DB::table('memes')->insert([
            'meme_name'             =>  'Dr Evil',
            'upl_name'              =>  'memes/dr_evil.jpg',
            'ext'                   =>  'jpg',
            'created_at'            =>  \Carbon\Carbon::now(),
            'updated_at'            =>  \Carbon\Carbon::now()
        ]);
        DB::table('memes')->insert([
            'meme_name'             =>  'First World Problems',
            'upl_name'              =>  'memes/first_world_problems.jpg',
            'ext'                   =>  'jpg',
            'created_at'            =>  \Carbon\Carbon::now(),
            'updated_at'            =>  \Carbon\Carbon::now()
        ]);
        DB::table('memes')->insert([
            'meme_name'             =>  'Futurama - Not Sure',
            'upl_name'              =>  'memes/futurama_fry.jpg',
            'ext'                   =>  'jpg',
            'created_at'            =>  \Carbon\Carbon::now(),
            'updated_at'            =>  \Carbon\Carbon::now()
        ]);
        DB::table('memes')->insert([
            'meme_name'             =>  'Maury Povich Lie Detector',
            'upl_name'              =>  'memes/maury.jpg',
            'ext'                   =>  'jpg',
            'created_at'            =>  \Carbon\Carbon::now(),
            'updated_at'            =>  \Carbon\Carbon::now()
        ]);
        DB::table('memes')->insert([
            'meme_name'             =>  'One Does Not Simply',
            'upl_name'              =>  'memes/one_does_not_simply.jpg',
            'ext'                   =>  'jpg',
            'created_at'            =>  \Carbon\Carbon::now(),
            'updated_at'            =>  \Carbon\Carbon::now()
        ]);
        DB::table('memes')->insert([
            'meme_name'             =>  'Overly Manly Man',
            'upl_name'              =>  'memes/overly_manly_man.jpg',
            'ext'                   =>  'jpg',
            'created_at'            =>  \Carbon\Carbon::now(),
            'updated_at'            =>  \Carbon\Carbon::now()
        ]);
        DB::table('memes')->insert([
            'meme_name'             =>  'Squeamish Seal',
            'upl_name'              =>  'memes/squeamish_seal.jpg',
            'ext'                   =>  'jpg',
            'created_at'            =>  \Carbon\Carbon::now(),
            'updated_at'            =>  \Carbon\Carbon::now()
        ]);
        DB::table('memes')->insert([
            'meme_name'             =>  'That would be great!',
            'upl_name'              =>  'memes/that_would_be_great.jpg',
            'ext'                   =>  'jpg',
            'created_at'            =>  \Carbon\Carbon::now(),
            'updated_at'            =>  \Carbon\Carbon::now()
        ]);
        DB::table('memes')->insert([
            'meme_name'             =>  'The Most Interesting Man in the World',
            'upl_name'              =>  'memes/interesting_man.jpg',
            'ext'                   =>  'jpg',
            'created_at'            =>  \Carbon\Carbon::now(),
            'updated_at'            =>  \Carbon\Carbon::now()
        ]);
    }
}
