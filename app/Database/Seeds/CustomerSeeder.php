<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        // $data = [
        //     [
        //         'nama' => 'doe',
        //         'alamat'    => 'Jln Cde No. 123',
        //     ],
        //     [
        //         'nama' => 'lorem',
        //         'alamat'    => 'Jln Fgh No. 123',
        //     ],
          
        // ];


        // Simple Queries
        // $this->db->query('INSERT INTO customers (nama, alamat) VALUES(:nama:, :alamat:)', $data);

        // Using Query Builder
        // $this->db->table('customers')->insert($data);
        
        // Using Query Builder insert many of data
        // $this->db->table('customers')->insertBatch($data);

        // using faker
        $faker = \Faker\Factory::create('id_ID');

        for($i = 0; $i < 100; $i++){     
        $data = [
                'nama' => $faker->name,
                'alamat'    => $faker->address,          
        ];
        $this->db->table('customers')->insert($data);
        }
    } 
}