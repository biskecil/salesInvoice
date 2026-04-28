<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    public function test_insert()
    {
        // $response = $this->get('/login');
        $this->withoutExceptionHandling();
        
        for ($i = 0; $i < 100; $i++) {
            $response = $this->postJson('/sales/storeApi', [
                'transDate'     => '2026-03-13',
                'customer'      => 'Customer ',
                'pembeli'       => 'Pembeli ',
                'grosir'        => '1246',
                'event'         => 'Pameran',
                'tempat'        => 'Ciputra',
                "category_desc" => [
                    "Gelang",
                    "Kalung",
                    "Kalung"
                ],
                "category" => [
                    "PGL",
                    "PKL",
                    "PKL"
                ],
                "cadar" => [
                    "16K",
                    "16K",
                    "16K"
                ],
                "wbruto" => [
                    "2.00",
                    "3.00",
                    "1.00"
                ],
                "price" => [
                    "0.735",
                    "0.735",
                    "0.735"
                ],
                "wnet" => [
                    "1.470",
                    "2.205",
                    "0.735"
                ],
                "pricecust" => [
                    "0.000",
                    "0.000",
                    "0.000"
                ],
                "wnetocust" => [
                    "0.000",
                    "0.000",
                    "0.000"
                ]
            ]);

            dump("Request ke-{$i}: ", $response->json());
            $response->assertStatus(200);
        }

        // for ($i = 0; $i < 2; $i++) {
        //     $response = $this->postJson('/invoice/storeApi', [
        //         'transDate'     => '2026-03-13',
        //         'customer'      => 'Customer ' . $i,
        //         'pembeli'       => 'Pembeli ' . $i,
        //         'grosir'        => '1246',
        //         'event'         => 'Pameran',
        //         'tempat'        => 'Ciputra',
        //     ]);

        //     // Tampilkan hasil tiap request
        //     dump("Request ke-{$i}: ", $response->json());

        //     $response->assertStatus(201);
        // }

        // // Cek duplikat SW
        // $duplicates = DB::table('invoice')
        //     ->whereDate('TransDate', '2026-03-13')
        //     ->select('SW', DB::raw('COUNT(*) as total'))
        //     ->groupBy('SW')
        //     ->having('total', '>', 1)
        //     ->get();

        // $this->assertCount(0, $duplicates, 'Ada duplikat SW: ' . $duplicates->toJson());
    }
}
