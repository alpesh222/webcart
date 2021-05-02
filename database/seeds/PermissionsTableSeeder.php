<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [

            ['name'=>'Create', 'for'=>'users'],
            ['name'=>'Read', 'for'=>'users'],
            ['name'=>'Update', 'for'=>'users'],

            ['name'=>'Create', 'for'=>'roles'],
            ['name'=>'Read', 'for'=>'roles'],
            ['name'=>'Update', 'for'=>'roles'],
            ['name'=>'Delete', 'for'=>'roles'],

            ['name'=>'Create', 'for'=>'products'],
            ['name'=>'Read', 'for'=>'products'],
            ['name'=>'Update', 'for'=>'products'],
            ['name'=>'Delete', 'for'=>'products'],

            ['name'=>'Create', 'for'=>'categories'],
            ['name'=>'Read', 'for'=>'categories'],
            ['name'=>'Update', 'for'=>'categories'],
            ['name'=>'Delete', 'for'=>'categories'],

            ['name'=>'Create', 'for'=>'brands'],
            ['name'=>'Read', 'for'=>'brands'],
            ['name'=>'Update', 'for'=>'brands'],
            ['name'=>'Delete', 'for'=>'brands'],

            ['name'=>'Create', 'for'=>'orders'],
            ['name'=>'Read', 'for'=>'orders'],
            ['name'=>'Update', 'for'=>'orders'],
            ['name'=>'Delete', 'for'=>'orders'],

            ['name'=>'View-Dashboard', 'for'=>'other'],
            ['name'=>'Update-Settings', 'for'=>'other'],
            ['name'=>'View-Customers', 'for'=>'other'],
            ['name'=>'View-Sales', 'for'=>'other'],

            ['name'=>'Create', 'for'=>'locations'],
            ['name'=>'Read', 'for'=>'locations'],
            ['name'=>'Update', 'for'=>'locations'],
            ['name'=>'Delete', 'for'=>'locations'],

            ['name'=>'Create', 'for'=>'discounts'],
            ['name'=>'Read', 'for'=>'discounts'],
            ['name'=>'Update', 'for'=>'discounts'],
            ['name'=>'Delete', 'for'=>'discounts'],

            ['name'=>'Create', 'for'=>'banners'],
            ['name'=>'Read', 'for'=>'banners'],
            ['name'=>'Update', 'for'=>'banners'],
            ['name'=>'Delete', 'for'=>'banners'],

            ['name'=>'Approve/Disapprove', 'for'=>'reviews'],
            ['name'=>'Delete', 'for'=>'reviews'],

            ['name'=>'Update-Payment-Settings', 'for'=>'other'],
            ['name'=>'Update-Business-Settings', 'for'=>'other'],
            ['name'=>'Update-Email-Settings', 'for'=>'other'],
            ['name'=>'Update-Customers', 'for'=>'other'],

            ['name'=>'Create', 'for'=>'coupons'],
            ['name'=>'Read', 'for'=>'coupons'],
            ['name'=>'Update', 'for'=>'coupons'],
            ['name'=>'Delete', 'for'=>'coupons'],

            ['name'=>'Create', 'for'=>'deals'],
            ['name'=>'Read', 'for'=>'deals'],
            ['name'=>'Update', 'for'=>'deals'],
            ['name'=>'Delete', 'for'=>'deals'],

            ['name'=>'Create', 'for'=>'pages'],
            ['name'=>'Read', 'for'=>'pages'],
            ['name'=>'Update', 'for'=>'pages'],
            ['name'=>'Delete', 'for'=>'pages'],

            ['name'=>'View-Reports', 'for'=>'other'],
            ['name'=>'View-Subscribers', 'for'=>'other'],
            ['name'=>'Update-Subscribers-Settings', 'for'=>'other'],
            ['name'=>'Update-CSS', 'for'=>'other'],
            ['name'=>'Import-Delete-Subscribers', 'for'=>'other'],

            ['name'=>'Create', 'for'=>'sections'],
            ['name'=>'Read', 'for'=>'sections'],
            ['name'=>'Update', 'for'=>'sections'],
            ['name'=>'Delete', 'for'=>'sections'],

            ['name'=>'Update-SMS-Settings', 'for'=>'other'],

            ['name'=>'Create', 'for'=>'shipments'],
            ['name'=>'Read', 'for'=>'shipments'],
            ['name'=>'Update', 'for'=>'shipments'],
            ['name'=>'Delete', 'for'=>'shipments'],

            ['name'=>'Manage-Shipment-Orders', 'for'=>'other'],

            ['name'=>'Create', 'for'=>'testimonials'],
            ['name'=>'Read', 'for'=>'testimonials'],
            ['name'=>'Update', 'for'=>'testimonials'],
            ['name'=>'Delete', 'for'=>'testimonials'],

            ['name'=>'Create', 'for'=>'vendors'],
            ['name'=>'Read', 'for'=>'vendors'],
            ['name'=>'Update', 'for'=>'vendors'],
            ['name'=>'Delete', 'for'=>'vendors'],

            ['name'=>'Read',    'for'=>'deliveryLocation'],
            ['name'=>'Create',  'for'=>'deliveryLocation'],
            ['name'=>'Update',  'for'=>'deliveryLocation'],
            ['name'=>'Delete',  'for'=>'deliveryLocation'],

            ['name'=>'Update-Delivery-Settings', 'for'=>'other'],
            ['name'=>'Update-Template-Settings', 'for'=>'other'],

            ['name'=>'Read',    'for'=>'comparisionGroup'],
            ['name'=>'Create',  'for'=>'comparisionGroup'],
            ['name'=>'Update',  'for'=>'comparisionGroup'],
            ['name'=>'Delete',  'for'=>'comparisionGroup'],
        ];

        foreach($permissions as $permission){
            Permission::firstOrCreate($permission);
        }
    }
}
