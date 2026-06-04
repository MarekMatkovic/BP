<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void {
Schema::table('articles', function (Blueprint $table) {
$table->string('image_url')->nullable()->after('content');
$table->string('image_position', 16)->default('none')->after('image_url'); // none|right|below
});
}
public function down(): void {
Schema::table('articles', function (Blueprint $table) {
$table->dropColumn(['image_url','image_position']);
});
}
};
