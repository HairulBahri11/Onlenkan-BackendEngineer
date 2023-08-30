<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class rolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'lihat-kategori']);
        Permission::create(['name' => 'tambah-kategori']);
        Permission::create(['name' => 'edit-kategori']);
        Permission::create(['name' => 'hapus-kategori']);
        Permission::create(['name' => 'tambah-admin']);

        Permission::create(['name' => 'lihat-produk']);
        Permission::create(['name' => 'tambah-produk']);
        Permission::create(['name' => 'edit-produk']);
        Permission::create(['name' => 'hapus-produk']);

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'penjual']);

        $role_admin = Role::findByName('admin');
        $role_admin->givePermissionTo([
            'lihat-kategori',
            'tambah-kategori',
            'edit-kategori',
            'hapus-kategori',
            'lihat-produk',
            'tambah-admin',
        ]);

        $role_penjual = Role::findByName('penjual');
        $role_penjual->givePermissionTo([
            'lihat-kategori',
            'lihat-produk',
            'tambah-produk',
            'edit-produk',
            'hapus-produk',
        ]);
    }
}
