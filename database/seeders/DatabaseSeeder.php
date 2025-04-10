<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        // Crear usuario administrador
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@turismocdmx.com',
            'password' => Hash::make('password123'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
/*
        // Categorías de lugares turísticos
        $categories = [
            [
                'name' => 'Museos',
                'description' => 'Espacios culturales dedicados a la conservación, estudio y exposición de objetos de valor histórico, artístico o científico.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Parques',
                'description' => 'Espacios verdes y recreativos para el disfrute de la naturaleza y actividades al aire libre.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Monumentos',
                'description' => 'Obras arquitectónicas de relevancia histórica, artística o conmemorativa.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Zonas Arqueológicas',
                'description' => 'Sitios donde se encuentran restos de civilizaciones antiguas.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Gastronomía',
                'description' => 'Lugares emblemáticos para disfrutar de la comida tradicional mexicana.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        DB::table('categories')->insert($categories);

        // Lugares turísticos
        $places = [
            [
                'name' => 'Museo Nacional de Antropología',
                'description' => 'El museo más importante de México, alberga la colección más grande de arte prehispánico del país.',
                'address' => 'Av. Paseo de la Reforma & Calzada Gandhi, Chapultepec Polanco',
                'district' => 'Miguel Hidalgo',
                'city' => 'Ciudad de México',
                'state' => 'CDMX',
                'latitude' => 19.4260,
                'longitude' => -99.1865,
                'image_url' => 'https://www.inah.gob.mx/images/boletines/2021_286/demo/images/imagen2.jpg',
                'category_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Bosque de Chapultepec',
                'description' => 'El pulmón verde más importante de la ciudad y uno de los parques urbanos más grandes del mundo.',
                'address' => 'Paseo de la Reforma',
                'district' => 'Miguel Hidalgo',
                'city' => 'Ciudad de México',
                'state' => 'CDMX',
                'latitude' => 19.4210,
                'longitude' => -99.1821,
                'image_url' => 'https://mxcity.mx/wp-content/uploads/2016/01/chapultepec.jpg',
                'category_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Ángel de la Independencia',
                'description' => 'Monumento emblemático de la Ciudad de México construido para conmemorar el centenario de la Independencia de México.',
                'address' => 'Paseo de la Reforma y Florencia',
                'district' => 'Cuauhtémoc',
                'city' => 'Ciudad de México',
                'state' => 'CDMX',
                'latitude' => 19.4270,
                'longitude' => -99.1676,
                'image_url' => 'https://www.mexicodesconocido.com.mx/wp-content/uploads/2019/09/angel-independencia-cdmx.jpg',
                'category_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Templo Mayor',
                'description' => 'Zona arqueológica ubicada en el Centro Histórico que muestra los restos del principal templo de la antigua Tenochtitlán.',
                'address' => 'Seminario 8, Centro Histórico',
                'district' => 'Cuauhtémoc',
                'city' => 'Ciudad de México',
                'state' => 'CDMX',
                'latitude' => 19.4346,
                'longitude' => -99.1318,
                'image_url' => 'https://www.mexicodesconocido.com.mx/wp-content/uploads/2019/09/templo-mayor-tenochtitlan.jpg',
                'category_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Mercado de San Juan',
                'description' => 'Famoso mercado gastronómico donde se pueden encontrar ingredientes exóticos y típicos de la cocina mexicana y mundial.',
                'address' => 'Ernesto Pugibet 21, Colonia Centro',
                'district' => 'Cuauhtémoc',
                'city' => 'Ciudad de México',
                'state' => 'CDMX',
                'latitude' => 19.4315,
                'longitude' => -99.1410,
                'image_url' => 'https://cdn.foodandwineespanol.com/2019/06/mercado-san-juan-5.jpg',
                'category_id' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Palacio de Bellas Artes',
                'description' => 'Recinto cultural que alberga importantes eventos artísticos y exposiciones, reconocido por su arquitectura Art Nouveau y Art Decó.',
                'address' => 'Av. Juárez S/N, Centro Histórico',
                'district' => 'Cuauhtémoc',
                'city' => 'Ciudad de México',
                'state' => 'CDMX',
                'latitude' => 19.4352,
                'longitude' => -99.1404,
                'image_url' => 'https://www.mexicodesconocido.com.mx/wp-content/uploads/2019/11/palacio-de-bellas-artes-.jpg',
                'category_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Xochimilco',
                'description' => 'Patrimonio de la Humanidad, famoso por sus canales y jardines flotantes (chinampas) y coloridas trajineras.',
                'address' => 'Embarcadero Nuevo Nativitas',
                'district' => 'Xochimilco',
                'city' => 'Ciudad de México',
                'state' => 'CDMX',
                'latitude' => 19.2574,
                'longitude' => -99.1068,
                'image_url' => 'https://www.mexicodesconocido.com.mx/wp-content/uploads/2019/09/xochimilco-trajineras.jpg',
                'category_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Monumento a la Revolución',
                'description' => 'Monumento y museo dedicado a la Revolución Mexicana, con una arquitectura imponente y una plaza pública.',
                'address' => 'Plaza de la República S/N, Tabacalera',
                'district' => 'Cuauhtémoc',
                'city' => 'Ciudad de México',
                'state' => 'CDMX',
                'latitude' => 19.4366,
                'longitude' => -99.1549,
                'image_url' => 'https://www.mexicodesconocido.com.mx/wp-content/uploads/2019/12/monumento-revolucion-cdmx.jpg',
                'category_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Cuicuilco',
                'description' => 'Antiguo centro ceremonial prehispánico con una gran pirámide circular, uno de los sitios arqueológicos más antiguos de la cuenca de México.',
                'address' => 'Insurgentes Sur 146, Tlalpan',
                'district' => 'Tlalpan',
                'city' => 'Ciudad de México',
                'state' => 'CDMX',
                'latitude' => 19.3010,
                'longitude' => -99.1809,
                'image_url' => 'https://www.mexicodesconocido.com.mx/wp-content/uploads/2010/06/cuicuilco_zona_arqueologica_cdmx_2.jpg',
                'category_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Pujol',
                'description' => 'Restaurante de alta cocina mexicana del chef Enrique Olvera, reconocido entre los mejores del mundo.',
                'address' => 'Tennyson 133, Polanco',
                'district' => 'Miguel Hidalgo',
                'city' => 'Ciudad de México',
                'state' => 'CDMX',
                'latitude' => 19.4320,
                'longitude' => -99.1967,
                'image_url' => 'https://s3.amazonaws.com/thelocalist.com/uploads/production/image/file/12903/pujol_mexico_restaurante.jpg',
                'category_id' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        DB::table('places')->insert($places);
*/
    }
}
