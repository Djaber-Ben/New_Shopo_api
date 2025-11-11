<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Wilaya;

class WilayaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wilayas = [
            ['DZ-01', '01', 'Adrar', 'أدرار'],
            ['DZ-02', '02', 'Chlef', 'الشلف'],
            ['DZ-03', '03', 'Laghouat', 'الأغواط'],
            ['DZ-04', '04', 'Oum El Bouaghi', 'أم البواقي'],
            ['DZ-05', '05', 'Batna', 'باتنة'],
            ['DZ-06', '06', 'Béjaïa', 'بجاية'],
            ['DZ-07', '07', 'Biskra', 'بسكرة'],
            ['DZ-08', '08', 'Bechar', 'بشار'],
            ['DZ-09', '09', 'Blida', 'البليدة'],
            ['DZ-10', '10', 'Bouira', 'البويرة'],
            ['DZ-11', '11', 'Tamanrasset', 'تمنراست'],
            ['DZ-12', '12', 'Tébessa', 'تبسة'],
            ['DZ-13', '13', 'Tlemcen', 'تلمسان'],
            ['DZ-14', '14', 'Tiaret', 'تيارت'],
            ['DZ-15', '15', 'Tizi Ouzou', 'تيزي وزو'],
            ['DZ-16', '16', 'Alger', 'الجزائر'],
            ['DZ-17', '17', 'Djelfa', 'الجلفة'],
            ['DZ-18', '18', 'Jijel', 'جيجل'],
            ['DZ-19', '19', 'Sétif', 'سطيف'],
            ['DZ-20', '20', 'Saïda', 'سعيدة'],
            ['DZ-21', '21', 'Skikda', 'سكيكدة'],
            ['DZ-22', '22', 'Sidi Bel Abbès', 'سيدي بلعباس'],
            ['DZ-23', '23', 'Annaba', 'عنابة'],
            ['DZ-24', '24', 'Guelma', 'قالمة'],
            ['DZ-25', '25', 'Constantine', 'قسنطينة'],
            ['DZ-26', '26', 'Médéa', 'المدية'],
            ['DZ-27', '27', 'Mostaganem', 'مستغانم'],
            ['DZ-28', '28', 'M’Sila', 'مسيلة'],
            ['DZ-29', '29', 'Mascara', 'معسكر'],
            ['DZ-30', '30', 'Ouargla', 'ورقلة'],
            ['DZ-31', '31', 'Oran', 'وهران'],
            ['DZ-32', '32', 'El Bayadh', 'البيض'],
            ['DZ-33', '33', 'Illizi', 'إليزي'],
            ['DZ-34', '34', 'Bordj Bou Arreridj', 'برج بوعريريج'],
            ['DZ-35', '35', 'Boumerdès', 'بومرداس'],
            ['DZ-36', '36', 'El Tarf', 'الطارف'],
            ['DZ-37', '37', 'Tindouf', 'تندوف'],
            ['DZ-38', '38', 'Tissemsilt', 'تيسمسيلت'],
            ['DZ-39', '39', 'El Oued', 'الوادي'],
            ['DZ-40', '40', 'Khenchela', 'خنشلة'],
            ['DZ-41', '41', 'Souk Ahras', 'سوق أهراس'],
            ['DZ-42', '42', 'Tipaza', 'تيبازة'],
            ['DZ-43', '43', 'Mila', 'ميلة'],
            ['DZ-44', '44', 'Aïn Defla', 'عين الدفلى'],
            ['DZ-45', '45', 'Naâma', 'النعامة'],
            ['DZ-46', '46', 'Aïn Témouchent', 'عين تموشنت'],
            ['DZ-47', '47', 'Ghardaïa', 'غرداية'],
            ['DZ-48', '48', 'Relizane', 'غليزان'],
            ['DZ-49', '49', 'Timimoun', 'تيميمون'],
            ['DZ-50', '50', 'Bordj Baji Mokhtar', 'برج باجي مختار'],
            ['DZ-51', '51', 'Ouled Djellal', 'أولاد جلال'],
            ['DZ-52', '52', 'Béni Abbès', 'بني عباس'],
            ['DZ-53', '53', 'Aïn Salah', 'عين صالح'],
            ['DZ-54', '54', 'In Guezzam', 'عين قزام'],
            ['DZ-55', '55', 'Touggourt', 'تقرت'],
            ['DZ-56', '56', 'Djanet', 'جانت'],
            ['DZ-57', '57', 'El M’Ghair', 'المغير'],
            ['DZ-58', '58', 'El Menia', 'المنية'],
        ];

        foreach ($wilayas as [$code, $number, $name_en, $name_ar]) {
            Wilaya::updateOrCreate(
                ['code' => $code],
                [
                    'number' => $number,
                    'name_en' => $name_en,
                    'name_ar' => $name_ar,
                ]
            );
        }
    }
}
