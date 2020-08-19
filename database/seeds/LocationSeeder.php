<?php

use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$today = date('Y-m-d H:i:s');
		$iterator = $country = 1;

		$locations = [];
		$locations[] = [
			'id' => $iterator,
			'code' => 'A00' . $iterator,
			'name' => 'taiwan',
			'display_name' => '臺灣',
			'location_id' => null,
			'created_at' => $today,
			'updated_at' => $today
		];

		$data = collect(json_decode(Storage::get('taiwan-road.json'), true))->groupBy('area');

		foreach ($data as $cityName => $city) {
			$iterator++;
			$cityId = $iterator;
			$districtIterator = 1;

			$locations[] = [
				'id' => $cityId,
				'code' => 'A' . str_pad($iterator, 3, '0', STR_PAD_LEFT),
				'name' => $cityName,
				'display_name' => $cityName,
				'location_id' => $country,
				'created_at' => $today,
				'updated_at' => $today
			];


			foreach ($city->groupBy('site') as $siteName => $roads) {
				$iterator++;
				$districtId = $iterator;

				$locations[] = [
					'id' => $districtId,
					'code' => 'B' . str_pad($districtIterator, 3, '0', STR_PAD_LEFT),
					'name' => str_replace($cityName, '', $siteName),
					'display_name' => str_replace($cityName, '', $siteName),
					'location_id' => $cityId,
					'created_at' => $today,
					'updated_at' => $today
				];

				$districtIterator++;

				foreach ($roads as $road) {
					$iterator++;
					$locations[] = [
						'id' => $iterator,
						'code' => null,
						'name' => $road['road'],
						'display_name' => $road['road'],
						'location_id' => $districtId,
						'created_at' => $today,
						'updated_at' => $today
					];
				}
			}
		}

		$chunksData = array_chunk($locations, 1000);
		$total = count($chunksData);
		foreach ($chunksData as $index => $t) {
			$itertion = $index + 1;
			DB::table('locations')->insert($t);
			$this->command->info("Chunks data 1000 row still {$itertion}/{$total}");
		}
	}
}
