<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $this->insertarPerros($faker, 50);
        $this->insertarInteraccions($faker, 250);
    }

    private function insertarPerros($faker, $cantidad)
    {
        foreach (range(1,$cantidad) as $index) {
            DB::table('perros')->insert([
                'nombre' => $faker->firstname(),
                'foto_url' => "https://placeholder.com/dog/{$index}",
                'descripcion' => $faker->sentence(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return true;
    }

    private function insertarInteraccions($faker, $cantidad)
    {
        $id_perros = DB::table('perros')->pluck('id')->toArray();
        $interesados_lista = array();
        $candidatos_lista = array();


        foreach (range(1,$cantidad) as $index) {

            $done = true;

            if(random_int(0,1) == 1){
                $prefe = 'R';
            }else{
                $prefe = 'A';
            }
            
            while($done){
                $done = true;
                $interesado = array_rand($id_perros, 1);
                $candidato = array_rand($id_perros, 1);
    
                if($candidato !== $interesado){  /* verifica que el perro candidato y el interesado no sea el mismo */
                    if(count($interesados_lista) == 0){
                        $done = false;
                    }else{
                        for($i = 0; $i < count($interesados_lista); $i++) {
                            if($candidatos_lista[$i] == $interesados_lista[$i]){
                                $done = true;
                                break;
                            }else{
                                $done = false;
                            }
                        }
                    }
                }

                if($done == false){
                    array_push($interesados_lista, $interesado);
                    array_push($candidatos_lista, $candidato);
                }
            }
           
            DB::table('interaccions')->insert([
                'perro_interesado_id' => $interesado,
                'perro_candidato_id' =>  $candidato,
                'preferencia' =>  $prefe,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return true;
        
    }
}
