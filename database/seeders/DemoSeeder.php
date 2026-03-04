<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Folder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // ── USUARIO ───────────────────────────────────────────────────────
        $user = User::firstOrCreate(
            ['email' => 'demo@demo.com'],
            [
                'name'     => 'Demo User',
                'password' => Hash::make('password'),
            ]
        );

        // ── HELPER ────────────────────────────────────────────────────────
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

        // ══════════════════════════════════════════════════════════════════
        // RAÍZ 1 — Magazine Project
        // ══════════════════════════════════════════════════════════════════
        $magazine = Folder::create(['name' => 'Magazine Project', 'user_id' => $user->id, 'parent_id' => null]);

        // → Fonts
        $magFonts = Folder::create(['name' => 'Fonts', 'user_id' => $user->id, 'parent_id' => $magazine->id]);

        $make([
            'title'       => 'Playfair Display',
            'type'        => 'font',
            'description' => 'High-contrast transitional serif. Classic choice for editorial headings and pull quotes.',
            'url'         => 'https://fonts.google.com/specimen/Playfair+Display',
            'folder_id'   => $magFonts->id,
            'tags'        => 'serif, editorial, display, elegant',
        ]);

        $make([
            'title'       => 'Cormorant Garamond',
            'type'        => 'font',
            'description' => 'Literary and refined serif inspired by Garamond. Perfect for bylines and body copy.',
            'url'         => 'https://fonts.google.com/specimen/Cormorant+Garamond',
            'folder_id'   => $magFonts->id,
            'tags'        => 'serif, classic, literary, body-text',
        ]);

        $make([
            'title'       => 'Libre Baskerville',
            'type'        => 'font',
            'description' => 'Optimized for readability at small sizes. Solid workhorse for long-form magazine text.',
            'url'         => 'https://fonts.google.com/specimen/Libre+Baskerville',
            'folder_id'   => $magFonts->id,
            'tags'        => 'serif, readable, body-text, print',
        ]);

        // → Inspiration
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

        $make([
            'title'       => 'It\'s Nice That',
            'type'        => 'web',
            'description' => 'Creative publication covering graphic design, illustration and art direction.',
            'url'         => 'https://www.itsnicethat.com',
            'folder_id'   => $magInspo->id,
            'tags'        => 'editorial, art-direction, illustration, inspiration',
        ]);

        // → Imagenes (vacía)
        Folder::create(['name' => 'Imagenes', 'user_id' => $user->id, 'parent_id' => $magazine->id]);


        // ══════════════════════════════════════════════════════════════════
        // RAÍZ 2 — Fanzine
        // ══════════════════════════════════════════════════════════════════
        $fanzine = Folder::create(['name' => 'Fanzine', 'user_id' => $user->id, 'parent_id' => null]);

        // → Colors
        $fanColors = Folder::create(['name' => 'Colors', 'user_id' => $user->id, 'parent_id' => $fanzine->id]);

        $make([
            'title'       => 'Risograph Punk',
            'type'        => 'color_palette',
            'description' => 'Raw, high-contrast palette inspired by risograph printing. Two-color offset feel.',
            'url'         => 'https://coolors.co/palette/ff006e-ffbe0b-fb5607-8338ec-3a86ff',
            'folder_id'   => $fanColors->id,
            'color_data'  => ['ff006e', 'ffbe0b', 'fb5607', '8338ec', '3a86ff'],
            'tags'        => 'riso, punk, vivid, print',
        ]);

        $make([
            'title'       => 'Xerox Noir',
            'type'        => 'color_palette',
            'description' => 'Black, dirty white and a single acid accent. Classic DIY zine aesthetic.',
            'url'         => 'https://coolors.co/palette/0d0d0d-f0ebe3-e63946-1d1d1d-ffffff',
            'folder_id'   => $fanColors->id,
            'color_data'  => ['0d0d0d', 'f0ebe3', 'e63946', '1d1d1d', 'ffffff'],
            'tags'        => 'dark, minimal, diy, zine',
        ]);

        $make([
            'title'       => 'Acid Summer',
            'type'        => 'color_palette',
            'description' => 'Neon yellows and greens with dark base. Lo-fi underground poster energy.',
            'url'         => 'https://coolors.co/palette/0d0d0d-ccff00-39ff14-1a1a2e-f5f5f5',
            'folder_id'   => $fanColors->id,
            'color_data'  => ['0d0d0d', 'ccff00', '39ff14', '1a1a2e', 'f5f5f5'],
            'tags'        => 'neon, acid, lo-fi, underground',
        ]);

        $make([
            'title'       => 'Mimeograph Pastels',
            'type'        => 'color_palette',
            'description' => 'Faded, slightly off tones that mimic old mimeograph or photocopied zines.',
            'url'         => 'https://coolors.co/palette/f7b2bd-fce694-b5ead7-c7ceea-ffdac1',
            'folder_id'   => $fanColors->id,
            'color_data'  => ['f7b2bd', 'fce694', 'b5ead7', 'c7ceea', 'ffdac1'],
            'tags'        => 'pastel, retro, faded, print',
        ]);

        // → Fuentes
        $fanFonts = Folder::create(['name' => 'Fuentes', 'user_id' => $user->id, 'parent_id' => $fanzine->id]);

        $make([
            'title'       => 'Special Elite',
            'type'        => 'font',
            'description' => 'Typewriter-style font with worn edges. Instantly gives that cut-and-paste zine feel.',
            'url'         => 'https://fonts.google.com/specimen/Special+Elite',
            'folder_id'   => $fanFonts->id,
            'tags'        => 'typewriter, diy, zine, display',
        ]);

        $make([
            'title'       => 'Bebas Neue',
            'type'        => 'font',
            'description' => 'Bold condensed all-caps sans. Great for aggressive headlines and poster-style layouts.',
            'url'         => 'https://fonts.google.com/specimen/Bebas+Neue',
            'folder_id'   => $fanFonts->id,
            'tags'        => 'bold, condensed, headline, display',
        ]);


        // ══════════════════════════════════════════════════════════════════
        // RAÍZ 3 — Web Develop
        // ══════════════════════════════════════════════════════════════════
        $webdev = Folder::create(['name' => 'Web Develop', 'user_id' => $user->id, 'parent_id' => null]);

        // → Iconos
        $devIcons = Folder::create(['name' => 'Iconos', 'user_id' => $user->id, 'parent_id' => $webdev->id]);

        $make([
            'title'       => 'Code Alt',
            'type'        => 'icon',
            'description' => 'Code bracket icon. Useful for developer tools and IDE-themed UIs.',
            'url'         => 'https://api.iconify.design/bxs:code-alt.svg',
            'folder_id'   => $devIcons->id,
            'tags'        => 'code, dev, ui, bxs',
        ]);

        $make([
            'title'       => 'Terminal',
            'type'        => 'icon',
            'description' => 'Terminal/console icon for developer dashboards and CLI references.',
            'url'         => 'https://api.iconify.design/bxs:terminal.svg',
            'folder_id'   => $devIcons->id,
            'tags'        => 'terminal, cli, dev, bxs',
        ]);

        $make([
            'title'       => 'Git Branch',
            'type'        => 'icon',
            'description' => 'Git branch icon. Perfect for version control and project workflow UIs.',
            'url'         => 'https://api.iconify.design/bxs:git-branch.svg',
            'folder_id'   => $devIcons->id,
            'tags'        => 'git, version-control, dev, bxs',
        ]);

        $make([
            'title'       => 'Cloud Upload',
            'type'        => 'icon',
            'description' => 'Cloud upload icon for deploy, storage and CI/CD pipeline interfaces.',
            'url'         => 'https://api.iconify.design/bxs:cloud-upload.svg',
            'folder_id'   => $devIcons->id,
            'tags'        => 'cloud, deploy, upload, bxs',
        ]);

        // → Colors
        $devColors = Folder::create(['name' => 'Colors', 'user_id' => $user->id, 'parent_id' => $webdev->id]);

        $make([
            'title'       => 'Dark UI System',
            'type'        => 'color_palette',
            'description' => 'Deep dark grays with a cyan accent. Designed for developer dashboards and code editors.',
            'url'         => 'https://coolors.co/palette/0d1117-161b22-21262d-30363d-58a6ff',
            'folder_id'   => $devColors->id,
            'color_data'  => ['0d1117', '161b22', '21262d', '30363d', '58a6ff'],
            'tags'        => 'dark, ui, developer, github-inspired',
        ]);

        $make([
            'title'       => 'Terminal Green',
            'type'        => 'color_palette',
            'description' => 'Classic terminal palette. Black background with phosphor green and soft grays.',
            'url'         => 'https://coolors.co/palette/0a0a0a-1a1a1a-00ff41-008f11-f5f5f5',
            'folder_id'   => $devColors->id,
            'color_data'  => ['0a0a0a', '1a1a1a', '00ff41', '008f11', 'f5f5f5'],
            'tags'        => 'terminal, green, dark, retro',
        ]);

        // → Imagenes (vacía)
        Folder::create(['name' => 'Imagenes', 'user_id' => $user->id, 'parent_id' => $webdev->id]);


        // ══════════════════════════════════════════════════════════════════
        // RAÍZ 4 — Webs (recursos directos en la carpeta raíz)
        // ══════════════════════════════════════════════════════════════════
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