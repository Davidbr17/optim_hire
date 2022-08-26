<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FederalEntity;
use App\Models\Municipality;
use App\Models\Settlement;
use App\Models\ZipCode;
use App\Models\SettlementType;

class AllZipCodesData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Get data from xml file for add to database
        ini_set('memory_limit', '-1');
        $xmlString = file_get_contents(public_path('CPdescarga.xml'));
        $xmlObject = @simplexml_load_string($xmlString);
                   
        $json = json_encode($xmlObject);
        $phpArray = json_decode($json, true); 
   
        $zip_codes = $phpArray['table'];        
        
        foreach ($zip_codes as $key => $zip_code) {
            $n_zip_code = New ZipCode;
            error_log($zip_code['d_codigo']);
            $n_zip_code->zip_code = $zip_code['d_codigo'];
            $n_zip_code->locality = isset($zip_code['d_ciudad']) ? $zip_code['d_ciudad'] : '';
    
            //Find if federal entity exists to add if not exist create
            $federal_entity = FederalEntity::where('key',$zip_code['c_estado'])->first();
            if(is_null($federal_entity)){
               $n_federal_entity = new FederalEntity;
               $n_federal_entity->key = $zip_code['c_estado'];
               $n_federal_entity->name = $zip_code['d_estado'];
               $n_federal_entity->save();
               $federal_entity = $n_federal_entity;
            }
    
            $n_zip_code->federal_entity_id = $federal_entity->id;
    
            //Find if municipality exists to add if not exist create
            $municipality = Municipality::where('key',$zip_code['c_mnpio'])->first();
            if(is_null($municipality)){
               $n_municipality = new Municipality;
               $n_municipality->key = $zip_code['c_mnpio'];
               $n_municipality->name = $zip_code['D_mnpio'];
               $n_municipality->save();
               $municipality = $n_municipality;
            }
    
            $n_zip_code->municipality_id = $municipality->id;
    
            //Find if settlement type exists to add if not exist create
            $settlement_type = SettlementType::where('name',$zip_code['d_tipo_asenta'])->first();
            if(is_null($settlement_type)){
               $n_settlement_type = new SettlementType;
               $n_settlement_type->name = $zip_code['d_tipo_asenta'];
               $n_settlement_type->save();
               $settlement_type = $n_settlement_type;
            }
    
            //Find if settlement exists to add if not exist create
            $settlement = Settlement::where('key',$zip_code['id_asenta_cpcons'])->first();
            if(is_null($settlement)){
               $n_settlement = new Settlement;
               $n_settlement->key = $zip_code['id_asenta_cpcons'];
               $n_settlement->name = $zip_code['d_asenta'];
               $n_settlement->zone_type = $zip_code['d_zona'];
               $n_settlement->settlement_type_id = $settlement_type->id;
               $n_settlement->save();
               $settlement = $n_settlement;
            }
    
            $n_zip_code->save();
            
            $n_zip_code->settlements()->attach($settlement->id);
        }
    }
}
