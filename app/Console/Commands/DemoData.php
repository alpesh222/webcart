<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Filesystem\Filesystem;

class DemoData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:template {template}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Demo Template to the Webcart Website';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $template       = $this->argument('template');
        $current_theme  = config('themeswitcher.current_theme');
        $sql            = base_path('demo_data' . DIRECTORY_SEPARATOR . 'webcart_user_mv_multi-vendor-'.$current_theme.'.sql');
        $this->comment('Importing ' . $sql . ' ...' );
        /* Drop all tables */
        DB::statement("SET foreign_key_checks=0");
        $databaseName = DB::getDatabaseName();
        $tables = DB::select("SELECT * FROM information_schema.tables WHERE table_schema = '$databaseName'");
        $dropping_tables = array('banners', 'brands', 'categories', 'category_specification_type', 'comparision_groups', 'deals',
            'deal_product', 'pages', 'photos', 'products', 'product_specification_type', 'related_products', 'reviews', 'sales',
            'sections', 'specification_types', 'testimonials', 'vendor_amounts', 'vouchers');
        foreach ($tables as $table) {
            if (!in_array($table->TABLE_NAME, $dropping_tables)){
                continue;
            }
            $name = $table->TABLE_NAME;
            if($template == 'default'){
                DB::table($name)->truncate();
            }else{
                Schema::dropIfExists($name);
            }
        }
        DB::statement("SET foreign_key_checks=1");

        /* Import all tables from sql */
        if ($template != 'default') {
            DB::unprepared(file_get_contents($sql));
        }
        $file = new Filesystem;
        $file->cleanDirectory(public_path('img'));
        if ($template == 'default'){
            \File::copyDirectory( base_path() . DIRECTORY_SEPARATOR . 'demo_data' . DIRECTORY_SEPARATOR . 'default_img', public_path('img') );
        }else{
            \File::copyDirectory( base_path() . DIRECTORY_SEPARATOR . 'demo_data' . DIRECTORY_SEPARATOR . 'img-'.$current_theme, public_path('img') );
        }
        $this->comment('Successfully imported: ' . $sql );

    }
}
