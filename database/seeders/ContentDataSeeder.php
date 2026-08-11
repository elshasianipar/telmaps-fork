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
            'hero_eyebrow_en' => 'About TELF',
            'hero_title' => 'Memantau hilangnya hutan, satu piksel pada satu waktu.',
            'hero_title_en' => 'Monitoring forest loss, one pixel at a time.',
            'hero_subtitle' => 'TELF adalah platform pemantauan kehilangan hutan yang memadukan data satelit Landsat (GLAD Alert) dengan batas administrasi Indonesia — dari provinsi hingga desa — untuk menyoroti titik panas deforestasi di Sumatera secara real-time.',
            'hero_subtitle_en' => 'TELF is a forest-loss monitoring platform that combines Landsat satellite data (GLAD Alert) with Indonesian administrative boundaries — from province to village — to highlight deforestation hotspots across Sumatra in near real-time.',
            'hero_image' => 'https://images.unsplash.com/photo-1730061753977-126196ac19ee?w=1600&h=1000&fit=crop&auto=format',
            'story_eyebrow' => 'Kisah kami',
            'story_eyebrow_en' => 'Our story',
            'story_title' => 'Dari laboratorium data geospasial menuju alat bantu publik.',
            'story_title_en' => 'From a geospatial data lab to a public tool.',
            'story_body' => 'TELF lahir dari kebutuhan untuk membuat data kehilangan hutan dapat diakses dan dipahami. Kami menggabungkan keahlian geospasial, pemrosesan shapefile, dan pemetaan interaktif agar setiap pemangku kepentingan — pemerintah, akademisi, dan masyarakat — dapat melihat di saja deforestasi terjadi dan seberapa yakin peringatannya.',
            'story_body_en' => 'TELF was born from the need to make forest-loss data accessible and understandable. We combine geospatial expertise, shapefile processing, and interactive mapping so that every stakeholder — government, academia, and the public — can see where deforestation happens and how confident the alerts are.',
            'story_image' => 'https://images.unsplash.com/photo-1759538575044-77c261e0183e?w=800&h=700&fit=crop&auto=format',
            'mission' => 'Menyediakan pemantauan kehilangan hutan yang transparan, berbasis data satelit terbuka, dan dapat ditelusuri hingga tingkat desa untuk mendukung pengambilan keputusan yang berpihak pada kelestarian hutan.',
            'mission_en' => 'To provide transparent, open-satellite-data-based forest-loss monitoring that can be traced down to the village level, supporting decisions that favor forest conservation.',
            'vision' => 'Setiap hektar hutan Sumatera — dan nusantara — terpantau, terdokumentasi, dan terlindungi melalui data yang dapat dipercaya dan diakses oleh semua pihak.',
            'vision_en' => 'Every hectare of Sumatran forest — and the archipelago — monitored, documented, and protected through data that is trustworthy and accessible to everyone.',
        ]);
    }

    private function seedTeams(): void
    {
        if (TeamMember::exists()) {
            return;
        }

        $members = [
            // [name, role, bio, photo, role_en, bio_en]
            ['Sarah Mitchell', 'Founder & Lead Designer', 'Mendirikan TELF dengan semangat untuk membuat data geospasial dapat diakses publik dan mendukung keputusan berbasis bukti.', 'https://images.unsplash.com/photo-1556157382-97eda2d62296?w=600&h=750&fit=crop&auto=format', 'Founder & Lead Designer', 'Founded TELF with the drive to make geospatial data publicly accessible and support evidence-based decisions.'],
            ['David Chen', 'Head Geospatial Engineer', 'Mengelola pemrosesan shapefile, pipeline data GLAD Alert, dan integrasi batas administrasi Indonesia hingga tingkat desa.', 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=600&h=750&fit=crop&auto=format', 'Head Geospatial Engineer', 'Oversees shapefile processing, the GLAD Alert data pipeline, and integration of Indonesian administrative boundaries down to village level.'],
            ['Amelia Rodriguez', 'Spatial Analyst', 'Menganalisis pola kehilangan hutan dan menyoroti titik panas deforestasi di Sumatera menggunakan data Landsat.', 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=600&h=750&fit=crop&auto=format', 'Spatial Analyst', 'Analyzes forest-loss patterns and highlights deforestation hotspots across Sumatra using Landsat data.'],
            ['James Okafor', 'Project Manager', 'Menjaga pengembangan platform tetap pada jadwal dengan tonggak yang jelas dan komunikasi yang terbuka.', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&h=750&fit=crop&auto=format', 'Project Manager', 'Keeps platform development on schedule with clear milestones and open communication.'],
            ['Priya Sharma', 'Sustainability Specialist', 'Menghubungkan temuan data dengan konteks kebijakan lingkungan dan keberlanjutan hutan tropis.', 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=600&h=750&fit=crop&auto=format', 'Sustainability Specialist', 'Connects data findings with environmental policy context and tropical forest sustainability.'],
            ['Elena Petrova', 'Community & Outreach Lead', 'Menjembatani data TELF dengan masyarakat sipil dan akademisi agar dampaknya lebih luas.', 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=600&h=750&fit=crop&auto=format', 'Community & Outreach Lead', 'Bridges TELF data with civil society and academia to broaden its impact.'],
        ];

        foreach ($members as $i => $m) {
            TeamMember::create([
                'name' => $m[0],
                'role' => $m[1],
                'bio' => $m[2],
                'photo' => $m[3],
                'role_en' => $m[4],
                'bio_en' => $m[5],
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
            // [question, answer, category, question_en, answer_en]
            ['Apa itu TELF?', 'TELF adalah platform pemantauan kehilangan hutan yang menggunakan data GLAD Alert (Landsat) dan batas administrasi Indonesia untuk menampilkan titik panas deforestasi di Sumatera secara interaktif.', 'Umum', 'What is TELF?', 'TELF is a forest-loss monitoring platform that uses GLAD Alert (Landsat) data and Indonesian administrative boundaries to display deforestation hotspots across Sumatra interactively.'],
            ['Dari mana data TELF berasal?', 'Data alert berasal dari GLAD Alert University of Maryland berbasis citra Landsat. Batas wilayah menggunakan data administrasi Kemendagri (provinsi, kabupaten, kecamatan, desa).', 'Data', 'Where does TELF\'s data come from?', 'Alert data comes from GLAD Alert, University of Maryland, based on Landsat imagery. Boundaries use Ministry of Home Affairs administrative data (province, regency, subdistrict, village).'],
            ['Bagaimana cara membaca peta?', 'Sel alert berwarna menunjukkan tingkat keyakinan (DN): merah = tinggi, kuning oranye = sedang, kuning = rendah. Klik batas wilayah untuk menelusuri provinsi → kabupaten → kecamatan → desa.', 'Peta', 'How do I read the map?', 'Colored alert cells show confidence levels (DN): red = high, orange = moderate, yellow = low. Click a boundary to drill from province → regency → subdistrict → village.'],
            ['Apakah data tersedia untuk wilayah lain?', 'Saat ini fokus TELF adalah Pulau Sumatera. Cakupan wilayah lain dapat ditambahkan sesuai kebutuhan dan ketersediaan data.', 'Data', 'Is data available for other regions?', 'TELF currently focuses on the island of Sumatra. Coverage of other regions can be added as needed and as data becomes available.'],
            ['Seberapa sering data diperbarui?', 'GLAD Alert diproses dari citra Landsat yang relatif sering. TELF menampilkan sampel alert tahun 2026 yang sudah diklasifikasi per tingkat keyakinan.', 'Data', 'How often is the data updated?', 'GLAD Alert is processed from Landsat imagery on a relatively frequent basis. TELF shows a sample of 2026 alerts already classified by confidence level.'],
            ['Bagaimana saya dapat menggunakan TELF?', 'Buka halaman Platform, jelajahi peta, klik batas wilayah untuk menelusuri, dan gunakan filter tingkat keyakinan untuk memfokuskan tampilan pada alert tertentu.', 'Umum', 'How can I use TELF?', 'Open the Platform page, explore the map, click boundaries to drill down, and use the confidence filters to focus on specific alerts.'],
            ['Apa manfaat platform TELF?', 'Platform TELF membantu pengguna melihat lokasi titik panas kebakaran hutan dan lahan, memahami tingkat keyakinan alert, dan menelusuri data dari tingkat provinsi hingga desa agar dapat dipakai untuk pemantauan dan pengambilan keputusan.', 'Platform', 'What is the benefit of the TELF platform?', 'The TELF platform helps users see fire and forest-land hot spots, understand alert confidence, and drill down from province to village level for monitoring and decision support.'],
            ['Bagaimana saya bisa melihat laporan dan detail wilayah?', 'Buka halaman Platform, pilih wilayah pada peta, lalu baca ringkasan alert dan detail administrasi yang tersedia. Data bisa dipakai sebagai dasar untuk analisis lanjutan atau koordinasi lebih lanjut.', 'Platform', 'How can I view reports and area details?', 'Open the Platform page, choose an area on the map, and review the available alert summary and administrative detail. The data can support additional analysis or coordination.'],
        ];

        foreach ($items as $i => $item) {
            FaqItem::create([
                'question' => $item[0],
                'answer' => $item[1],
                'category' => $item[2],
                'question_en' => $item[3],
                'answer_en' => $item[4],
                'sort_order' => $i,
                'is_active' => true,
            ]);
        }
    }
}
