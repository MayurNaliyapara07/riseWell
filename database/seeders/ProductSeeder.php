<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product')->delete();
        $product = array(
            array('product_name' => 'Generic Cialis®(Tadalafil)', 'sku' => 'test1', 'price' => 30, 'category_id' => 3, 'product_type' => 'ED', 'type' => 'Subscription', 'membership_subscription' => 99),
            array('product_name' => 'Generic Viagra® (Sildenafil)', 'sku' => 'test2', 'price' => 30, 'category_id' => 3, 'product_type' => 'ED', 'type' => 'Subscription', 'membership_subscription' => 99),
            array('product_name' => 'Clomid', 'sku' => 'test3', 'price' => 47, 'category_id' => 2, 'product_type' => 'ED', 'type' => 'Subscription', 'membership_subscription' => 99),
            array('product_name' => 'Metformin (Glucophage)', 'sku' => 'test4', 'price' => 25, 'category_id' => 2, 'product_type' => 'TRT', 'type' => 'OneTime', 'membership_subscription' => 99),
            array('product_name' => 'Glutathione Injection', 'sku' => 'test5', 'price' => 90, 'category_id' => 2, 'product_type' => 'ED', 'type' => 'Subscription', 'membership_subscription' => 99),
            array('product_name' => 'Testosterone Lipoderm Cream', 'sku' => 'test6', 'price' => 48, 'category_id' => 4, 'product_type' => 'ED', 'type' => 'Subscription', 'membership_subscription' => 99),
            array('product_name' => 'Testosterone Cypionate Injections', 'sku' => 'test7', 'price' => 28, 'category_id' => 4, 'product_type' => 'ED', 'type' => 'Subscription', 'membership_subscription' => 99),
            array('product_name' => 'Thyroid Medication', 'sku' => 'test8', 'price' => 45, 'category_id' => 4, 'product_type' => 'ED', 'type' => 'Subscription', 'membership_subscription' => 99),
        );
        DB::table('product')->insert($product);
    }
}
