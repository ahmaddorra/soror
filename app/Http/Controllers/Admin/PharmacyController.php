<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class PharmacyController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $limit = (int)$request->input('length');
            $start = (int)$request->input('start');
            $order = $request->input('columns.' . $request->input('order.0.column') . '.data');
            $dir = $request->input('order.0.dir');
            $s = $request->input('search.value');


            $query = Pharmacy::query()->orderBy($order, $dir)->skip($start)->take($limit);
            if ($s != "") {
                $query = $query->where('name', 'like', "%$s%")
                    ->orWhere('phone', 'like', "%$s%");
            }
            return response()->datatable($request->input('draw'), $query->count(), Pharmacy::query()->count(), $query->get());
        }

        return view("admin.pharmacy.index");
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'phone' => 'required',
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'logo' => 'required',
        ]);
        try {
            $pharmacy = new Pharmacy();
            $pharmacy->name = $request->name;
            $pharmacy->location = [$request->longitude, $request->latitude];
            $pharmacy->phone = $request->phone;
            $logo = "";
            if ($request->file('logo') != "") {
                $name = 'logos' . '_' . time() . Str::random(2);
                $folder_to_upload_into = '/uploads/logos/';
                $folder_path_to_save_db = '/storage/' . $folder_to_upload_into;
                $current_file = asset($folder_path_to_save_db . $name . '.' . $request->file('logo')->getClientOriginalExtension());
                $logo .= $current_file;
                $this->uploadOne($request->file('logo'), $folder_to_upload_into, 'public', $name);
            }
            $pharmacy->logo = $logo;
            $kfile = $request->file('images');
            if (!is_array($kfile))
                $kfile = [$kfile];
            $images = "";
            foreach ($kfile as $file) {
                $name = 'images' . '_' . time() . Str::random(2);
                $folder_to_upload_into = '/uploads/images/';
                $folder_path_to_save_db = '/storage/' . $folder_to_upload_into;
                $current_file = asset($folder_path_to_save_db . $name . '.' . $file->getClientOriginalExtension());
                $images .= $current_file;
                if (sizeof($kfile) > 1)
                    $images = $images . ';';
                $this->uploadOne($file, $folder_to_upload_into, 'public', $name);
            }
            $pharmacy->images = $images;
            $pharmacy->address = $request->address;
            $pharmacy->delivery = $request->has('delivery');
            $pharmacy->save();
            return response()->json(["success" => true]);
        } catch (\Exception $e) {
            return response()->json(["success" => false, 'message' => $e->getMessage()], 500);

        }
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'phone' => 'required',
            'images' => 'sometimes',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
            $pharmacy = Pharmacy::query()->findOrFail($id);
            $pharmacy->name = $request->name;
            $pharmacy->location = [$request->longitude, $request->latitude];
            $pharmacy->phone = $request->phone;
            $logo = "";
            if ($request->file('logo') != "") {
                $name = 'logos' . '_' . time() . Str::random(2);
                $folder_to_upload_into = '/uploads/logos/';
                $folder_path_to_save_db = '/storage/' . $folder_to_upload_into;
                $current_file = asset($folder_path_to_save_db . $name . '.' . $request->file('logo')->getClientOriginalExtension());
                $logo .= $current_file;
                $this->uploadOne($request->file('logo'), $folder_to_upload_into, 'public', $name);
                $pharmacy->logo = $logo;
            }
            if($request->hasFile('images')) {
                $kfile = $request->file('images');
                if (!is_array($kfile))
                    $kfile = [$kfile];
                $images = "";
                foreach ($kfile as $file) {
                    $name = 'images' . '_' . time() . Str::random(2);
                    $folder_to_upload_into = '/uploads/images/';
                    $folder_path_to_save_db = '/storage/' . $folder_to_upload_into;
                    $current_file = asset($folder_path_to_save_db . $name . '.' . $file->getClientOriginalExtension());
                    $images .= $current_file;
                    if (sizeof($kfile) > 1)
                        $images = $images . ';';
                    $this->uploadOne($file, $folder_to_upload_into, 'public', $name);
                }
            }
            $pharmacy->images = !isset($images) ? $pharmacy->images : $images;
            $pharmacy->address = $request->address;
            $pharmacy->delivery = $request->has('delivery');
            $pharmacy->save();
            return response()->json(["success" => true]);
        } catch (\Exception $e) {
            return response()->json(["success" => false, 'message' => $e->getMessage()], 500);

        }
    }

    public function destroy($id)
    {
        Pharmacy::query()->where('id', $id)->delete();
        return response()->json(["success" => true]);
    }

    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);

        $file = $uploadedFile->storeAs($folder, $name . '.' . $uploadedFile->getClientOriginalExtension(), $disk);

        return $file;
    }
}
