<?php

use App\Models\Banner;
use App\Models\Category;
use App\Models\CmsPage;
use App\Models\Faq;
use App\Models\HomepageSection;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Review;
use App\Models\SiteSetting;
use App\Models\Tag;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (Category::count() > 0) {
            return;
        }

        Artisan::call('db:seed', ['--class' => 'IppeoDataSeeder', '--force' => true]);
    }

    public function down(): void
    {
    }
};
