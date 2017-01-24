<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'site_dir'                                  =>  '/rocketeerv4/public/',
            'site_domain'                               =>  'localhost',
            'slides'                                    =>  '[]',
            'widgets'                                   =>  '[]',
            'media_overrides'                           =>  json_encode([
                'poll_page_content'                     =>  2,
                'poll_style'                            =>  2,
                'poll_animation'                        =>  2,
                'quiz_page_content'                     =>  2,
                'quiz_animation'                        =>  2,
                'quiz_style'                            =>  2,
                'quiz_timed'                            =>  2,
                'quiz_timer'                            =>  2,
                'quiz_randomize_questions'              =>  2,
                'quiz_randomize_answers'                =>  2,
                'image_page_content'                    =>  2,
                'meme_page_content'                     =>  2,
                'video_page_content'                    =>  2,
                'list_page_content'                     =>  2,
                'list_style'                            =>  2,
                'list_animation'                        =>  2
            ]),
            'media_defaults'                            =>  json_encode([
                'poll_style'                            =>  1,
                'poll_animation'                        =>  '',
                'quiz_animation'                        =>  '',
                'quiz_style'                            =>  1,
                'quiz_timed'                            =>  1,
                'quiz_timer'                            =>  0,
                'quiz_randomize_questions'              =>  1,
                'quiz_randomize_answers'                =>  1,
                'list_style'                            =>  1,
                'list_animation'                        =>  1,
            ]),
            'languages'                                 =>  json_encode([
                [
                    'locale'                            =>  'en',
                    'readable_name'                     =>  'English'
                ]
            ]),
            'iframe_urls'                               =>  json_encode([
                "www.youtube.com/embed/", "player.vimeo.com/video/", "w.soundcloud.com/player/", "www.instagram.com"
            ]),
            'created_at'                                =>  \Carbon\Carbon::now(),
            'updated_at'                                =>  \Carbon\Carbon::now()
        ]);
    }
}
