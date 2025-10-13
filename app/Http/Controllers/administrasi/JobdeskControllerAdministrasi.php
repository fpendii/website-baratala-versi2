<?php

namespace App\Http\Controllers\administrasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jobdesk;

class JobdeskControllerAdministrasi extends Controller
{
    public function index()
    {
        $jobdesks = Jobdesk::all();
        return view('administrasi.jobdesk.index', compact('jobdesks'));
    }

    public function create()
    {
        return view('administrasi.jobdesk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_jobdesk' => 'required|string|max:255',
            'deskripsi'     => 'required|string',
            'divisi'        => 'required|string|max:255',
        ]);
        Jobdesk::create($request->all());

        return redirect()->to('/administrasi/jobdesk')
                         ->with('success', 'Jobdesk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jobdesk = Jobdesk::findOrFail($id);
        return view('administrasi.jobdesk.edit', compact('jobdesk'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_jobdesk' => 'required|string|max:255',
            'deskripsi'     => 'required|string',
            'divisi'        => 'required|string|max:255',
        ]);

        $jobdesk = Jobdesk::findOrFail($id);
        $jobdesk->update($request->all());

        return redirect()->to('administrasi/jobdesk')
                         ->with('success', 'Jobdesk berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jobdesk = Jobdesk::findOrFail($id);
        $jobdesk->delete();

        return redirect()->to('administrasi/jobdesk')
                         ->with('success', 'Jobdesk berhasil dihapus');
    }
}
