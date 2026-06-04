<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
public function run(): void
{
// vymaž cache práv
app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

// permissions
$viewArticles = Permission::firstOrCreate(['name' => 'view articles']);
$takeTests    = Permission::firstOrCreate(['name' => 'take tests']);
$editTests    = Permission::firstOrCreate(['name' => 'edit tests']);
$editArticles = Permission::firstOrCreate(['name' => 'edit articles']);

// roles
$user = Role::firstOrCreate(['name' => 'user']);
$user->syncPermissions([$viewArticles, $takeTests]);

$moderator = Role::firstOrCreate(['name' => 'moderator']);
$moderator->syncPermissions([$viewArticles, $takeTests, $editTests]);

$admin = Role::firstOrCreate(['name' => 'administrator']);
$admin->syncPermissions([$viewArticles, $takeTests, $editTests, $editArticles]);
}
}
