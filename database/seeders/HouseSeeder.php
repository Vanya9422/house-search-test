<?php

namespace Database\Seeders;

use App\Repositories\House\HouseRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HouseSeeder extends Seeder
{
    /**
     * @param HouseRepository $houseRepository
     */
    public function __construct(private HouseRepository $houseRepository) { }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = public_path('property-data.csv');
        $chunkSize = 100; // Размер чанка

        // Открываем файл для чтения
        $file = fopen($filePath, 'r');

        // Считываем заголовки
        $header = fgetcsv($file);

        // Создаем массив для хранения данных о домах
        $houses = [];

        try {
            DB::beginTransaction();

            while ($row = fgetcsv($file)) {
                $house = array_combine($header, $row);

                $houses[] = [
                    'name' => $house['Name'],
                    'bedrooms' => $house['Bedrooms'],
                    'bathrooms' => $house['Bathrooms'],
                    'storeys' => $house['Storeys'],
                    'garages' => $house['Garages'],
                    'price' => $house['Price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Если достигнут размер чанка, вставляем данные и очищаем массив
                if (count($houses) >= $chunkSize) {
                    $this->houseRepository->insertHouses($houses);
                    $houses = [];
                }
            }

            // Вставляем оставшиеся данные
            if (!empty($houses)) {
                $this->houseRepository->insertHouses($houses);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e; // Перебрасываем исключение для логирования
        } finally {
            // Закрываем файл
            fclose($file);
        }
    }
}
