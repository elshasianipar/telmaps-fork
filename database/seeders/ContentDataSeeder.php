<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\FaqItem;
use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class ContentDataSeeder extends Seeder
{
    /**
     * Konten awal untuk halaman publik About, Teams, dan FAQ.
     * Mengisi tabel CMS dengan teks yang sudah ada pada halaman
     * statis sebelumnya agar situs tetap terisi setelah migrasi.
     */
    public function run(): void
    {
        $this->seedAbout();
        $this->seedTeams();
        $this->seedFaq();
    }

    private function seedAbout(): void
    {
        if (About::exists()) {
            return;
        }

        About::create([
            'is_active' => true,
            'hero_eyebrow' => 'About TELF',
            'hero_title' => 'Memantau hilangnya hutan, satu piksel pada satu waktu.',
            'hero_subtitle' => 'TELF adalah platform pemantauan kehilangan hutan yang memadukan data satelit Landsat (GLAD Alert) dengan batas administrasi Indonesia — dari provinsi hingga desa — untuk menyoroti titik panas deforestasi di Sumatera secara real-time.',
            'hero_image' => 'https://images.unsplash.com/photo-1730061753977-126196ac19ee?w=1600&h=1000&fit=crop&auto=format',
            'story_eyebrow' => 'Kisah kami',
            'story_title' => 'Dari laboratorium data geospasial menuju alat bantu publik.',
            'story_body' => 'TELF lahir dari kebutuhan untuk membuat data kehilangan hutan dapat diakses dan dipahami. Kami menggabungkan keahlian geospasial, pemrosesan shapefile, dan pemetaan interaktif agar setiap pemangku kepentingan — pemerintah, akademisi, dan masyarakat — dapat melihat di saja deforestasi terjadi dan seberapa yakin peringatannya.',
            'story_image' => 'https://images.unsplash.com/photo-1759538575044-77c261e0183e?w=800&h=700&fit=crop&auto=format',
            'mission' => 'Menyediakan pemantauan kehilangan hutan yang transparan, berbasis data satelit terbuka, dan dapat ditelusuri hingga tingkat desa untuk mendukung pengambilan keputusan yang berpihak pada kelestarian hutan.',
            'vision' => 'Setiap hektar hutan Sumatera — dan nusantara — terpantau, terdokumentasi, dan terlindungi melalui data yang dapat dipercaya dan diakses oleh semua pihak.',
        ]);
    }

    private function seedTeams(): void
    {
        if (TeamMember::exists()) {
            return;
        }

        $members = [
            // [name, role, bio, photo]
            ['Sarah Mitchell', 'Founder & Lead Designer', 'Mendirikan TELF dengan semangat untuk membuat data geospasial dapat diakses publik dan mendukung keputusan berbasis bukti.', 'https://images.unsplash.com/photo-1556157382-97eda2d62296?w=600&h=750&fit=crop&auto=format'],
            ['David Chen', 'Head Geospatial Engineer', 'Mengelola pemrosesan shapefile, pipeline data GLAD Alert, dan integrasi batas administrasi Indonesia hingga tingkat desa.', 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=600&h=750&fit=crop&auto=format'],
            ['Amelia Rodriguez', 'Spatial Analyst', 'Menganalisis pola kehilangan hutan dan menyoroti titik panas deforestasi di Sumatera menggunakan data Landsat.', 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=600&h=750&fit=crop&auto=format'],
            ['James Okafor', 'Project Manager', 'Menjaga pengembangan platform tetap pada jadwal dengan tonggak yang jelas dan komunikasi yang terbuka.', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&h=750&fit=crop&auto=format'],
            ['Priya Sharma', 'Sustainability Specialist', 'Menghubungkan temuan data dengan konteks kebijakan lingkungan dan keberlanjutan hutan tropis.', 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=600&h=750&fit=crop&auto=format'],
            ['Elena Petrova', 'Community & Outreach Lead', 'Menjembatani data TELF dengan masyarakat sipil dan akademisi agar dampaknya lebih luas.', 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=600&h=750&fit=crop&auto=format'],
        ];

        foreach ($members as $i => $m) {
            TeamMember::create([
                'name' => $m[0],
                'role' => $m[1],
                'bio' => $m[2],
                'photo' => $m[3],
                'sort_order' => $i,
                'is_active' => true,
            ]);
        }
    }

    private function seedFaq(): void
    {
        if (FaqItem::exists()) {
            return;
        }

        $items = [
            // [question, answer, category]
            ['Apa itu TELF?', 'TELF adalah platform pemantauan kehilangan hutan yang menggunakan data GLAD Alert (Landsat) dan batas administrasi Indonesia untuk menampilkan titik panas deforestasi di Sumatera secara interaktif.', 'Umum'],
            ['Dari mana data TELF berasal?', 'Data alert berasal dari GLAD Alert University of Maryland berbasis citra Landsat. Batas wilayah menggunakan data administrasi Kemendagri (provinsi, kabupaten, kecamatan, desa).', 'Data'],
            ['Bagaimana cara membaca peta?', 'Sel alert berwarna menunjukkan tingkat keyakinan (DN): merah = tinggi, kuning oranye = sedang, kuning = rendah. Klik batas wilayah untuk menelusuri provinsi → kabupaten → kecamatan → desa.', 'Peta'],
            ['Apakah data tersedia untuk wilayah lain?', 'Saat ini fokus TELF adalah Pulau Sumatera. Cakupan wilayah lain dapat ditambahkan sesuai kebutuhan dan ketersediaan data.', 'Data'],
            ['Seberapa sering data diperbarui?', 'GLAD Alert diproses dari citra Landsat yang relatif sering. TELF menampilkan sampel alert tahun 2026 yang sudah diklasifikasi per tingkat keyakinan.', 'Data'],
            ['Bagaimana saya dapat menggunakan TELF?', 'Buka halaman Platform, jelajahi peta, klik batas wilayah untuk menelusuri, dan gunakan filter tingkat keyakinan untuk memfokuskan tampilan pada alert tertentu.', 'Umum'],
        ];

        foreach ($items as $i => $item) {
            FaqItem::create([
                'question' => $item[0],
                'answer' => $item[1],
                'category' => $item[2],
                'sort_order' => $i,
                'is_active' => true,
            ]);
        }
    }
}
