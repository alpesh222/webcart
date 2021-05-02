<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Auth;
use App\Sale;
use App\Other;
use Carbon\Carbon;
use DateTime;

class ManageReportsController extends Controller
{
	public function product_sales(Request $request)
	{
		if(Auth::user()->can('view-reports', Other::class)) {
			$location_id = Auth::user()->location_id;
            $vendor = Auth::user()->isApprovedVendor();
            if ($vendor){
                $products = Product::where('location_id', $location_id)->where('vendor_id', $vendor->id)->pluck('name', 'id')->toArray();
            }else{
                $products = Product::where('location_id', $location_id)->pluck('name', 'id')->toArray();
            }
			$period = $request->period;
			$group = $request->group;

			if($request->product) {
				$product_name = Product::select('name')->findOrFail($request->product)->name;

				// Product Specific Data
			    $sales = Sale::where('product_id', $request->product);

			} else {
				$product_name = __('All Products');
				// All Products Data
				$sales = Sale::select('sales', 'date', 'product_id');
			}

		    // Period
			switch ($period) {
				case 'Last Year':
					$sales = $sales->whereYear("date", "=", Carbon::now()->subYear()->format('Y'));
					break;

				case 'Last 6 Months':
					$dateStart = Carbon::now()->startOfMonth()->subMonths(6);
					$dateEnd = Carbon::now()->startOfMonth();
					$sales = $sales->whereBetween('date', [$dateStart, $dateEnd]);
					break;

				case 'Last Month':
					$dateStart = Carbon::now()->startOfMonth()->subMonth(1);
					$dateEnd = Carbon::now()->startOfMonth();
					$sales = $sales->whereBetween('date', [$dateStart, $dateEnd]);
					break;

				case 'Current Year':
					$sales = $sales->whereYear("date", "=", Carbon::now()->format('Y'));
					break;

				case 'Current Month':
					$dateStart = Carbon::now()->startOfMonth();
					$dateEnd = Carbon::now()->endOfMonth();
					$sales = $sales->whereBetween('date', [$dateStart, $dateEnd]);
					break;

				case 'Last 15 Days':
					$dateStart = Carbon::now()->startOfDay()->subDays(15);
					$dateEnd = Carbon::now()->startOfDay();
					$sales = $sales->whereBetween('date', [$dateStart, $dateEnd]);
					break;

				case 'Last 7 Days':
					$dateStart = Carbon::now()->startOfDay()->subDays(7);
					$dateEnd = Carbon::now()->startOfDay();
					$sales = $sales->whereBetween('date', [$dateStart, $dateEnd]);
					break;

				case 'Yesterday':
					$yesterday = date("Y-m-d", strtotime('-1 days'));
					$sales = $sales->whereDate('date', $yesterday);
					break;

				case 'Today':
					$sales = $sales->where("date", ">=", Carbon::today());
					break;

				default:
					$period = 'Current Month';
					$dateStart = Carbon::now()->startOfMonth();
					$dateEnd = Carbon::now()->endOfMonth();
					$sales = $sales->whereBetween('date', [$dateStart, $dateEnd]);
					break;
			}

			// Location Specific Sales
			$sales = $sales->get();
			$sales = $sales->filter(function($sale) use ($location_id) {
    					return $sale->product->location_id == $location_id;
					});

			// Group
			switch ($group) {
				case 'Year':
					$sales = $sales->groupBy(function($sale) {
		            	return Carbon::parse($sale->date)->format('Y');
		        	});
					break;

				case 'Month':
					$sales = $sales->groupBy(function($sale) {
		            	return Carbon::parse($sale->date)->format('F Y');
		        	});
					break;

				case 'Day':
					$sales = $sales->groupBy(function($sale) {
		            	return Carbon::parse($sale->date)->format('M d, Y');
		        	});
					break;

				default:
					$sales = $sales->groupBy(function($sale) {
		            	return Carbon::parse($sale->date)->format('M d, Y');
		        	});
					break;
			}

			if(isset($sales)) {
				// Labels
				$labels = $sales->keys()->toArray();

				// Data
				$sales_data = $sales->map(function ($sale, $key) {
					return $sale->sum('sales');
				})->toArray();
				$data = array_values($sales_data);

				// Chart
				$chartjs_sales = app()->chartjs
				->name('sales')
				->type('line')
				->size(['width' => 400, 'height' => 200])
				->labels($labels)
				->datasets([
					[
						"label" => "Sales",
						'backgroundColor' => "rgba(11, 185, 154, 0.31)",
						'borderColor' => "rgba(38, 185, 154, 0.7)",
						"pointBorderColor" => "rgba(38, 185, 154, 0.7)",
						"pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
						"pointHoverBackgroundColor" => "#fff",
						"pointHoverBorderColor" => "rgba(220,220,220,1)",
						'data' => $data,
					]
				])
				->options([]);
			}

    		return view('manage.reports.product_sales', compact('products', 'product_name', 'chartjs_sales', 'period'));
        } else {
            return view('errors.403');
        }
	}
}