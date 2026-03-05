<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Folder;

class DemoSeeder extends Seeder
{
    public function run(): void {
       
        $user = User::firstOrCreate(
            ['email' => 'demo@demo.com'],
            [
                'name'     => 'Demo User',
                'password' => Hash::make('password'),
            ]
        );

        $make = function (array $data) use ($user): void {
            $resource = $user->resources()->create([
                'title'       => $data['title'],
                'type'        => $data['type'],
                'description' => $data['description'] ?? null,
                'url'         => $data['url']         ?? null,
                'folder_id'   => $data['folder_id']   ?? null,
                'image_path'  => null,
                'color_data'  => $data['color_data']  ?? null,
            ]);
            if (!empty($data['tags'])) {
                $resource->syncTagsFromString($data['tags']);
            }
        };


        // Magazine Project
        $magazine = Folder::create(['name' => 'Magazine Project', 'user_id' => $user->id, 'parent_id' => null]);

        // Fonts
        $magFonts = Folder::create(['name' => 'Fonts', 'user_id' => $user->id, 'parent_id' => $magazine->id]);

        $make([
            'title'       => 'Holtwood One SC',
            'type'        => 'font',
            'description' => 'High-contrast font',
            'url'         => 'https://fonts.google.com/share?selection.family=Holtwood+One+SC',
            'folder_id'   => $magFonts->id,
            'tags'        => 'serif, editorial, bold',
        ]);

        $make([
            'title'       => 'Cormorant Garamond',
            'type'        => 'font',
            'description' => 'Literary and refined serif inspired by Garamond. Perfect for bylines and body copy.',
            'url'         => 'https://fonts.google.com/share?selection.family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700',
            'folder_id'   => $magFonts->id,
            'tags'        => 'serif, classic, literary, body-text',
        ]);

        $make([
            'title'       => 'Permanent Marker',
            'type'        => 'font',
            'description' => 'To apply on titles, perfect for natural posts.',
            'url'         => 'https://fonts.google.com/share?selection.family=Permanent+Marker',
            'folder_id'   => $magFonts->id,
            'tags'        => 'marker, bold, handmade',
        ]);

        // Inspiration
        $magInspo = Folder::create(['name' => 'Inspiration', 'user_id' => $user->id, 'parent_id' => $magazine->id]);

        $make([
            'title'       => 'Dribbble',
            'type'        => 'web',
            'description' => 'Designer community sharing editorial layouts, cover designs and typography work.',
            'url'         => 'https://dribbble.com',
            'folder_id'   => $magInspo->id,
            'tags'        => 'inspiration, community, editorial, ui',
        ]);

        $make([
            'title'       => 'Fonts In Use',
            'type'        => 'web',
            'description' => 'Archive of real-world typography in editorial, print and branding design.',
            'url'         => 'https://fontsinuse.com',
            'folder_id'   => $magInspo->id,
            'tags'        => 'typography, editorial, print, reference',
        ]);

        // Images
        Folder::create(['name' => 'Images', 'user_id' => $user->id, 'parent_id' => $magazine->id]);



        // Fanzine
        $fanzine = Folder::create(['name' => 'Fanzine', 'user_id' => $user->id, 'parent_id' => null]);

        // Colors
        $fanColors = Folder::create(['name' => 'Colors', 'user_id' => $user->id, 'parent_id' => $fanzine->id]);

        $make([
            'title'       => 'Earthy Forest',
            'type'        => 'color_palette',
            'description' => 'Earthy tones, natural look',
            'url'         => 'https://coolors.co/palette/dad7cd-a3b18a-588157-3a5a40-344e41',
            'folder_id'   => $fanColors->id,
            'color_data'  => ['dad7cd', 'a3b18a', '588157', '3a5a40', '344e41'],
        ]);

        $make([
            'title'       => 'Rustic Earthy Tones',
            'type'        => 'color_palette',
            'description' => 'Natural palette with brown tones',
            'url'         => 'https://coolors.co/palette/7f5539-a68a64-ede0d4-656d4a-414833',
            'folder_id'   => $fanColors->id,
            'color_data'  => ['7f5539', 'a68a64', 'ede0d4', '656d4a', '414833'],
            'tags'        => 'brown, earthy, greens',
        ]);

        $make([
            'title'       => 'Nature Harmony',
            'type'        => 'color_palette',
            'description' => 'Earthy tones for a complete concept.',
            'url'         => 'https://coolors.co/palette/eff1ed-373d20-717744-bcbd8b-766153',
            'folder_id'   => $fanColors->id,
            'color_data'  => ['eff1ed', '373d20', '717744', 'bcbd8b', '766153'],
            'tags'        => 'brown, titles, concept',
        ]);

        $make([
            'title'       => 'Fruit Punch',
            'type'        => 'color_palette',
            'description' => 'Natural vivid colors.',
            'url'         => 'https://coolors.co/palette/a41623-f85e00-ffb563-ffd29d-918450',
            'folder_id'   => $fanColors->id,
            'color_data'  => ['a41623', 'f85e00', 'ffb563', 'ffd29d', '918450'],
            'tags'        => 'colorful, nature, fruits',
        ]);

        // Fonts
        $fanFonts = Folder::create(['name' => 'Fonts', 'user_id' => $user->id, 'parent_id' => $fanzine->id]);

        $make([
            'title'       => 'Shadows Light',
            'type'        => 'font',
            'description' => 'Hand style, natural look.',
            'url'         => 'https://fonts.google.com/share?selection.family=Shadows+Into+Light',
            'folder_id'   => $fanFonts->id,
            'tags'        => 'natura, handmade',
        ]);

        $make([
            'title'       => 'Anton',
            'type'        => 'font',
            'description' => 'Bold condensed all-caps sans. Great for aggressive headlines and poster-style layouts.',
            'url'         => 'https://fonts.google.com/share?selection.family=Anton',
            'folder_id'   => $fanFonts->id,
        ]);



        //  Web Develop
        $webdev = Folder::create(['name' => 'Web Develop', 'user_id' => $user->id, 'parent_id' => null]);

        // Icons
        $devIcons = Folder::create(['name' => 'Icons', 'user_id' => $user->id, 'parent_id' => $webdev->id]);

        $make([
            'title'       => 'Cloud Arrow Down',
            'type'        => 'icon',
            'url'         => 'https://api.iconify.design/heroicons:cloud-arrow-down.svg',
            'folder_id'   => $devIcons->id,
            'tags'        => 'cloud, download, ui',
        ]);

        $make([
            'title'       => 'Spinner shuffle',
            'type'        => 'icon',
            'description' => 'Animated icon.',
            'url'         => 'https://api.iconify.design/svg-spinners:blocks-shuffle-3.svg',
            'folder_id'   => $devIcons->id,
            'tags'        => 'logo, front, presentation',
        ]);

        $make([
            'title'       => 'Personal layers',
            'type'        => 'icon',
            'description' => 'Perfect for represent organization.',
            'url'         => 'https://api.iconify.design/fluent-color:layer-diagonal-person-16.svg',
            'folder_id'   => $devIcons->id,
            'tags'        => 'ui, personal, order',
        ]);

        $make([
            'title'       => 'Layout',
            'type'        => 'icon',
            'description' => 'For represente the concept',
            'url'         => 'https://api.iconify.design/gridicons:layout.svg',
            'folder_id'   => $devIcons->id,
            'tags'        => 'grid, layout, order',
        ]);

        // Colors
        $devColors = Folder::create(['name' => 'Colors', 'user_id' => $user->id, 'parent_id' => $webdev->id]);

        $make([
            'title'       => 'Mystic Waters',
            'type'        => 'color_palette',
            'url'         => 'https://coolors.co/palette/031926-468189-77aca2-9dbebb-f4e9cd',
            'folder_id'   => $devColors->id,
            'color_data'  => ['031926', '468189', '77aca2', '9dbebb', 'f4e9cd'],
        ]);

        $make([
            'title'       => 'Whimsical Melody',
            'type'        => 'color_palette',
            'description' => 'Pastel for test',
            'url'         => 'https://coolors.co/palette/fe938c-edaf97-c49792-ad91a3-9d91a3',
            'folder_id'   => $devColors->id,
            'color_data'  => ['fe938c', 'edaf97', 'c49792', 'ad91a3', '9d91a3'],
            'tags'        => 'pastel, soft',
        ]);

        // Images
        Folder::create(['name' => 'Images', 'user_id' => $user->id, 'parent_id' => $webdev->id]);


        // Webs
        $webs = Folder::create(['name' => 'Webs', 'user_id' => $user->id, 'parent_id' => null]);

        $make([
            'title'       => 'Awwwards',
            'type'        => 'web',
            'description' => 'Awards for the best designed and developed websites. Top reference for web inspiration.',
            'url'         => 'https://www.awwwards.com',
            'folder_id'   => $webs->id,
            'tags'        => 'inspiration, award, web, design',
        ]);

        $make([
            'title'       => 'Godly',
            'type'        => 'web',
            'description' => 'Curated gallery of the most beautiful websites. Updated daily, great for UI trends.',
            'url'         => 'https://godly.website',
            'folder_id'   => $webs->id,
            'tags'        => 'inspiration, gallery, ui, curated',
        ]);

        $make([
            'title'       => 'Land-book',
            'type'        => 'web',
            'description' => 'Collection of landing pages for design inspiration and conversion patterns.',
            'url'         => 'https://land-book.com',
            'folder_id'   => $webs->id,
            'tags'        => 'landing-page, inspiration, ui, conversion',
        ]);

        $make([
            'title'       => 'Layers.to',
            'type'        => 'web',
            'description' => 'Portfolio and personal site showcase. Great reference for creative developer portfolios.',
            'url'         => 'https://layers.to',
            'folder_id'   => $webs->id,
            'tags'        => 'portfolio, inspiration, personal, creative',
        ]);
    }
}