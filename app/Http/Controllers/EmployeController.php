<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;
use App\Exports\EmployeExport;
use App\Imports\EmployeImport;
use App\Http\Controllers\Controller;
use App\Models\Religion;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class EmployeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $data = Employe::where('nama', 'LIKE', '%' . $request->search . '%')->paginate(5);
            Session::put('halaman_url', request()->fullUrl());
        } else {
            $data = Employe::paginate(5);
            Session::put('halaman_url', request()->fullUrl());
        }

        return view('employee.datapegawai', compact('data'));
    }

    public function tambahpegawai()
    {
        $dataagama = Religion::all();
        return view('employee.tambahdata', compact('dataagama'));
    }

    public function insertdata(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|min:2|max:20',
            'notelpon' => 'required|min:11|max:12',
        ]);

        $data = Employe::create($request->all());
        if ($request->hasFile('foto')) {
            $request->file('foto')->move('fotopegawai/', $request->file('foto')->getClientOriginalName());
            $data->foto = $request->file('foto')->getClientOriginalName();
            $data->save();
        }
        return redirect()->route('pegawai')->with('success', 'Data Berhasil Di Tambahkan');
    }

    public function tampilkandata($id)
    {
        $data = Employe::find($id);
        //dd($data);

        return view('employee.tampildata', compact('data'));
    }

    public function updatedata(Request $request, $id)
    {
        $data = Employe::find($id);
        $data->update($request->all());
        if (session('halaman_url')) {
            return Redirect(session('halaman_url'))->with('success', 'Data Berhasil Di Update');
        }
        return redirect()->route('pegawai')->with('success', 'Data Berhasil Di Update');

        if ($request->hasFile('foto')) {
            $request->file('foto')->move('fotopegawai/', $request->file('foto')->getClientOriginalName());
            $data->foto = $request->file('foto')->getClientOriginalName();
            $data->save();
        }
    }

    public function delete($id)
    {
        $data = Employe::find($id);
        $file = public_path('fotopegawai/') . $data->foto;

        if (file_exists($file)) {
            @unlink($file);
        }
        $data->delete();
        return redirect()->route('pegawai')->with('success', 'Data Berhasil Di Hapus');
    }

    public function exportpdf()
    {
        $data = Employe::get();
        return view('employee.datapegawai-pdf', compact('data'));
    }

    public function exportexcel()
    {
        return Excel::download(new EmployeExport, 'datapegawai.xlsx');
    }

    public function importexcel(Request $request)
    {
        $data = $request->file('file');
        $namafile = $data->getClientOriginalName();
        $data->move('EmployeData', $namafile);

        Excel::import(new EmployeImport, \public_path('/EmployeData/' . $namafile));
        return \redirect()->back();
    }
}
