<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscriber;
use App\Other;
use DB;
use Illuminate\Support\Facades\Auth;

class ManageSubscribersController extends Controller
{
    protected $subscribers = [];
    protected $valid = true;
    protected $errorRows = [];
    protected $validRows = [];

	public function index()
	{
		if(Auth::user()->can('view-subscribers', Other::class)) {
            if(request()->has('status') && request()->status == 'verified') {
                $subscribers = Subscriber::where('active', 1)->get();
            } else {
                $subscribers = Subscriber::all();
            }
			return view('manage.subscribers.index', compact('subscribers'));
		} else {
			return view('errors.403');
		}
	}

	public function deleteSubscribers(Request $request)
	{
		if(Auth::user()->can('import-delete-subscribers', Other::class)) {
			if(isset($request->delete_single)) {
				$subscriber = Subscriber::findOrFail($request->delete_single);
				$subscriber->delete();
				session()->flash('subscriber_deleted', __("The subscriber has been deleted."));
			} else {
				if(isset($request->delete_all) && !empty($request->checkboxArray)) {
					$subscribers = Subscriber::findOrFail($request->checkboxArray);
					foreach($subscribers as $subscriber) {
						$subscriber->delete();
					}
					session()->flash('subscriber_deleted', __("The selected subscribers have been deleted."));
				} else {
					session()->flash('subscriber_not_deleted', __("Please select subscribers to be deleted."));
				}
			}
			return redirect(route('manage.subscribers'));
		} else {
			return view('errors.403');
		}
	}

    public function importSubscribers(Request $request)
    {
	    if(Auth::user()->can('import-delete-subscribers', Other::class)) {
	        $this->validate($request, [
	            'file' => 'required|mimes:csv,txt'
	        ]);

	        $file = $request->file('file');
	        $csvData = file_get_contents($file);
	        $rows = array_map("str_getcsv", explode("\n", $csvData));
            $rows = self::trimData($rows);

	        $header = array_shift($rows);

            try {
    	        if (!$this->checkImportData($rows, $header)) {
    	            session()->flash('error_rows', $this->getErrorRows());
    	            session()->flash('error', __('Error in data. Correct and re-upload.'));
    	            return redirect()->back();
    	        }
            } catch (\Exception $exception) {
                session()->flash('error', __('CSV data is not in correct format.'));
                return redirect()->back();
            }

	        $this->createSubscribers($header, $rows);

	        session()->flash('success', __("Subscribers imported"));
	        return redirect()->back();
	    } else {
		    return view('errors.403');
	    }
    }

    private static function trimData($data) {
        if($data == null) {
            return null;
        }
        if(is_array($data)) {
            return array_map('self::trimData', $data);
        } else {
            return trim($data);
        }
    }

    public function checkImportData($rows, $header)
    {
        $emails = [];

        foreach ($rows as $key => $row) {
            $row = array_combine($header, $row);
            $row = array_change_key_case($row);

            // Check for correct email
            if (!$this->checkValidEmail($row['email'])) {
                $row['message'] = 'Invalid email.';
                $this->errorRows[$key] = $row;
                $this->valid = false;
            } else {
                $emails[] = $row['email'];
            }
        }

        $exist = $this->checkSubscriberExist($emails);

        if (count($exist) > 0) {
            $this->valid = false;
            $this->addSubscriberExistErrorMessage($exist, $header, $rows);
        }

        return $this->valid;
    }

    public function getErrorRows()
    {
        ksort($this->errorRows);
        return $this->errorRows;
    }

    private function checkValidEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Invalid email format
            return false;
        }
        return true;
    }

    private function checkSubscriberExist($emails)
    {
        return Subscriber::whereIn('email', $emails)->get()->pluck('email')->toArray();
    }

    private function addSubscriberExistErrorMessage($exist, $header, $rows)
    {
        foreach ($rows as $key => $row) {
            $row = array_combine($header, $row);
            $row = array_change_key_case($row);
            if (in_array($row['email'], $exist)) {
                $row['message'] = __('Email already exists.');
                $this->errorRows[$key] = $row;
            }
        }

        return $rows;
    }

    public function createSubscribers($header, $rows)
    {
        try {
            DB::beginTransaction();
            foreach ($rows as $row) {
                $row = array_combine($header, $row);
                $row = array_change_key_case($row);
                Subscriber::create([
                    'email' => $row['email'],
                    'active' => array_key_exists('status', $row) ? $row['status'] == "Confirmed" : 1
                ]);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }
}
