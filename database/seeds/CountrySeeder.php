<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //


            $endpoint = "https://restcountries.eu/rest/v2/all";
            $client = new \GuzzleHttp\Client();


            $response = $client->request('GET', $endpoint);

            $statusCode = $response->getStatusCode();
            if ($statusCode===200){
                $countries =  $response->getBody();
                $countries=json_decode($countries,true);
                $end=[];
                foreach ($countries as $index=>$country){
                    if (!$country['callingCodes'][0]==""){
                        $callingCodes = $country['callingCodes'][0];
                        $currencies_code = $country['currencies'][0]['code'];
                        $currencies_name = $country['currencies'][0]['name'];
                        $currencies_symbol = $country['currencies'][0]['symbol'];
                        $country_name_en = $country['name'];
                        $country_name_ar = $country['translations']['fa'];
                        $country_flag = $country['flag'];
                        $country_alpha2Code = $country['alpha2Code'];
                        $end[]=['calling_code' => $callingCodes,
                            'currency_name' =>$currencies_name ?: '',
                            'currency_code' =>$currencies_code ?: '',
                            'currency_symbol' => $currencies_symbol ?: '$',
                            'country_name_ar' =>$country_name_ar,
                            'country_name_en' =>$country_name_en ,
                            'flag'=>$country_flag,
                            'alpha2Code'=>$country_alpha2Code,
                        ];
                    }else{
                        continue;
                    }
                }

                foreach ($end as $index2=>$country_insert){
                    DB::table('countries')->insert([
                        'calling_code' =>$country_insert['calling_code'] ,
                        'currency_name' =>$country_insert['currency_name'],
                        'currency_code' =>$country_insert['currency_code'],
                        'currency_symbol' =>$country_insert['currency_symbol'] ,
                        'country_name_ar' =>$country_insert['country_name_ar'],
                        'country_name_en' =>$country_insert['country_name_en'] ,
                        'flag'=>$country_insert['flag'],
                        'alpha2Code'=>$country_insert['alpha2Code'],
                    ]);
                }
            }


    }
}
