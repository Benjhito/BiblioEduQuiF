<?php

namespace Database\Seeders;

use App\Models\IvaRate;
use App\Models\IvaType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LookupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ivaTypes = [
            ['code' => '01', 'descrip' => 'IVA Responsable Inscripto'],
            ['code' => '02', 'descrip' => 'IVA Responsable no Inscripto'],
            ['code' => '03', 'descrip' => 'IVA no Responsable'],
            ['code' => '04', 'descrip' => 'IVA Sujeto Exento'],
            ['code' => '05', 'descrip' => 'Consumidor Final'],
            ['code' => '06', 'descrip' => 'Responsable Monotributo'],
            ['code' => '07', 'descrip' => 'Sujeto no Categorizado'],
            ['code' => '08', 'descrip' => 'Proveedor del Exterior'],
            ['code' => '09', 'descrip' => 'Cliente del Exterior'],
            ['code' => '10', 'descrip' => 'IVA Liberado - Ley No 19.640'],
            ['code' => '11', 'descrip' => 'IVA Resp.Insc.-Agente Percep.'],
            ['code' => '12', 'descrip' => 'Pequeno Contribuyente Eventual'],
            ['code' => '13', 'descrip' => 'Monotributista Social'],
            ['code' => '14', 'descrip' => 'Pequeno Contrib.Event.Social'],
        ];

        foreach ($ivaTypes as $ivaType) {
            IvaType::create([
                'code' => $ivaType['code'],
                'descrip' => $ivaType['descrip'],
            ]);
        }

        $ivaRates = [
            ['value' => 0.00, 'descrip' => ' 0,0%'],
            ['value' => 2.50, 'descrip' => ' 2,5%'],
            ['value' => 5.00, 'descrip' => ' 5,0%'],
            ['value' => 10.50, 'descrip' => '10,5%'],
            ['value' => 21.00, 'descrip' => '21,0%'],
        ];

        foreach ($ivaRates as $ivaRate) {
            IvaRate::create([
                 'value' => $ivaRate['value'],
                 'descrip' => $ivaRate['descrip'],
            ]);
        }
    }
}
