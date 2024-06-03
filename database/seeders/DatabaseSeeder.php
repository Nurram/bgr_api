<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Item;
use App\Models\PaymentMethod;
use App\Models\Price;
use App\Models\Stock;
use App\Models\UnitOfMaterial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        DB::table('roles')->insert([
            ['name' => 'Super Admin'],
            ['name' => 'Admin Stock'],
            ['name' => 'Cashier'],
        ]);
        DB::table('privileges')->insert([
            ['name' => 'GOLD Member', 'discount_percent' => 20],
            ['name' => 'Silver Member', 'discount_percent' => 10],
            ['name' => 'Bronze Member', 'discount_percent' => 5],
        ]);
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@bli.com',
            'password' => 'admin101',
            'role_id' => 1
        ]);
        UnitOfMaterial::create([
            'name' => 'kg'
        ]);
        Item::create([
            'name' => 'Bawang Putih',
            'sku' => 123432,
            'stock' => 99999,
            'uom_id' => 1,
            'price' => 10000
        ]);
        DB::table('payment_methods')->insert([
            ['method' => 'Cash'],
            ['method' => 'Debit'],
            ['method' => 'Kartu Kredit'],
        ]);
        DB::table('permissions')->insert([
            ['name' => 'Cari Produk'],
            ['name' => 'Riwayat Transaksi'],
            ['name' => 'List Unit Of Material'],
            ['name' => 'List Item'],
            ['name' => 'List Privilege'],
            ['name' => 'List Pembayaran'],
            ['name' => 'List Role'],
            ['name' => 'List Permission'],
            ['name' => 'List User'],
        ]);
        DB::table('role_permissions')->insert([
            ['role_id' => 1, 'permission_id' => 1, 'is_active' => true],
            ['role_id' => 1, 'permission_id' => 2, 'is_active' => true],
            ['role_id' => 1, 'permission_id' => 3, 'is_active' => true],
            ['role_id' => 1, 'permission_id' => 4, 'is_active' => true],
            ['role_id' => 1, 'permission_id' => 5, 'is_active' => true],
            ['role_id' => 1, 'permission_id' => 6, 'is_active' => true],
            ['role_id' => 1, 'permission_id' => 7, 'is_active' => true],
            ['role_id' => 1, 'permission_id' => 8, 'is_active' => true],
            ['role_id' => 1, 'permission_id' => 9, 'is_active' => true],
            ['role_id' => 2, 'permission_id' => 1, 'is_active' => false],
            ['role_id' => 2, 'permission_id' => 2, 'is_active' => false],
            ['role_id' => 2, 'permission_id' => 3, 'is_active' => false],
            ['role_id' => 2, 'permission_id' => 4, 'is_active' => false],
            ['role_id' => 2, 'permission_id' => 5, 'is_active' => false],
            ['role_id' => 2, 'permission_id' => 6, 'is_active' => false],
            ['role_id' => 2, 'permission_id' => 7, 'is_active' => false],
            ['role_id' => 2, 'permission_id' => 8, 'is_active' => false],
            ['role_id' => 2, 'permission_id' => 9, 'is_active' => false],
            ['role_id' => 3, 'permission_id' => 1, 'is_active' => false],
            ['role_id' => 3, 'permission_id' => 2, 'is_active' => false],
            ['role_id' => 3, 'permission_id' => 3, 'is_active' => false],
            ['role_id' => 3, 'permission_id' => 4, 'is_active' => false],
            ['role_id' => 3, 'permission_id' => 5, 'is_active' => false],
            ['role_id' => 3, 'permission_id' => 6, 'is_active' => false],
            ['role_id' => 3, 'permission_id' => 7, 'is_active' => false],
            ['role_id' => 3, 'permission_id' => 8, 'is_active' => false],
            ['role_id' => 3, 'permission_id' => 9, 'is_active' => false],
        ]);
    }
}
