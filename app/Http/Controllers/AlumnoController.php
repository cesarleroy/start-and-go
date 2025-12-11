<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Illuminate\Support\Facades\Storage;

class AlumnoController extends Controller
{

    public function index()
    {
        $alumnos = Alumno::all();
        return view('alumnos.index', compact('alumnos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rfc'          => 'required|string|max:13|unique:alumnos,rfc',
            'nombre'       => 'required|string|max:255',
            'apellido_p'   => 'required|string|max:255',
            'apellido_m'   => 'nullable|string|max:255',
            'fecha_nac'    => 'required|date',
            'calle'        => 'required|string|max:255',
            'numero'       => 'required|string|max:50',
            'colonia'      => 'required|string|max:255',
            'alcaldia'     => 'required|string|max:255',
            'permiso'      => 'required|in:SI,NO',
            'correo'       => 'required|email|max:255',
            'observaciones'=> 'nullable|string|max:1000',
        ]);

        Alumno::create([
            'rfc'          => $request->rfc,
            'nombre'       => $request->nombre,
            'apellido_p'   => $request->apellido_p,
            'apellido_m'   => $request->apellido_m,
            'fecha_nac'    => $request->fecha_nac,
            'calle'        => $request->calle,
            'numero'       => $request->numero,
            'colonia'      => $request->colonia,
            'alcaldia'     => $request->alcaldia,
            'permiso'      => $request->permiso,
            'observaciones'=> $request->observaciones,
            'correo'       => $request->correo,
        ]);

        return redirect()->route('alumnos.index')->with('success', 'Alumno agregado correctamente.');
    }


    public function update(Request $request, $rfc)
    {
        $alumno = Alumno::where('rfc', $rfc)->firstOrFail();

        $request->validate([
            'nombre'       => 'required|string|max:255',
            'apellido_p'   => 'required|string|max:255',
            'apellido_m'   => 'nullable|string|max:255',
            'fecha_nac'    => 'required|date',
            'calle'        => 'required|string|max:255',
            'numero'       => 'required|string|max:50',
            'colonia'      => 'required|string|max:255',
            'alcaldia'     => 'required|string|max:255',
            'permiso'      => 'required|in:SI,NO',
            'correo'       => 'required|email|max:255',
            'observaciones'=> 'nullable|string|max:1000',
        ]);

        $alumno->update([
            'nombre'       => $request->nombre,
            'apellido_p'   => $request->apellido_p,
            'apellido_m'   => $request->apellido_m,
            'fecha_nac'    => $request->fecha_nac,
            'calle'        => $request->calle,
            'numero'       => $request->numero,
            'colonia'      => $request->colonia,
            'alcaldia'     => $request->alcaldia,
            'permiso'      => $request->permiso,
            'correo'       => $request->correo,
            'observaciones'=> $request->observaciones,
        ]);

        return redirect()->route('alumnos.index')->with('success', 'Alumno actualizado correctamente.');
    }


    public function destroy($rfc)
    {
        $alumno = Alumno::where('rfc', $rfc)->firstOrFail();
        $alumno->delete();

        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado correctamente.');
    }

    public function generarCredencial(Request $request)
  {
      // 1. Validar
      $request->validate([
          'rfc' => 'required|exists:alumnos,rfc',
          'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Máx 2MB
      ]);

      try {
          $alumno = Alumno::findOrFail($request->rfc);

          // 2. Manejo de la Foto
          $nombreFoto = $alumno->rfc . '.jpg'; // Guardamos como RFC.jpg para sobreescribir si ya existe
          $rutaGuardado = 'fotos_alumnos';     // Carpeta en storage/app/public/

          if ($request->hasFile('foto')) {
              // Guardar/Sobreescribir la foto nueva
              $request->file('foto')->storeAs($rutaGuardado, $nombreFoto, 'public');
          }

          // 3. Determinar qué foto mostrar en el PDF
          // Verificamos si existe una foto personalizada en el storage
          if (Storage::disk('public')->exists("$rutaGuardado/$nombreFoto")) {
              $rutaFotoReal = storage_path("app/public/$rutaGuardado/$nombreFoto");
          } else {
              // Si no, usamos la imagen default
              $rutaFotoReal = public_path('img/icono.png');
          }

          // 4. Generar el HTML desde una vista (crearemos este archivo en el paso 4)
          $html = view('alumnos.pdf_credencial', compact('alumno', 'rutaFotoReal'))->render();

          // 5. Generar PDF (Tamaño tarjeta 88x56 mm)
          $html2pdf = new Html2Pdf('L', [88, 56], 'es', true, 'UTF-8', [0, 0, 0, 0]);
          $html2pdf->pdf->SetDisplayMode('fullpage');
          $html2pdf->writeHTML($html);
          $html2pdf->output("Credencial_{$alumno->rfc}.pdf");

      } catch (Html2PdfException $e) {
          return redirect()->back()->with('error', 'Error PDF: ' . $e->getMessage());
      }
  }
  public function generarMatricula($alumno) {
    // 1. Obtener iniciales (Estilo RFC)
    // Primera letra del Apellido Paterno
    $l1 = substr($alumno->apellido_p, 0, 1);
    
    // Primera vocal interna del Apellido Paterno
    // (Buscamos la primera vocal que no sea la primera letra)
    $ap_paterno = strtoupper($alumno->apellido_p);
    preg_match('/[AEIOU]/', substr($ap_paterno, 1), $matches);
    $l2 = $matches[0] ?? 'X'; // Si no encuentra, usa X

    // Primera letra del Apellido Materno (o X si no tiene)
    $l3 = $alumno->apellido_m ? substr($alumno->apellido_m, 0, 1) : 'X';

    // Primera letra del Nombre
    $l4 = substr($alumno->nombre, 0, 1);

    $iniciales = strtoupper($l1 . $l2 . $l3 . $l4);

    // 2. Obtener fecha (YYMMDD)
    // Asumiendo que fecha_nac es un objeto Carbon o string fecha
    $fecha = \Carbon\Carbon::parse($alumno->fecha_nac)->format('ymd');

    // 3. Generar 5 dígitos aleatorios
    $random = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);

    return $iniciales . $fecha . $random;
  }
}
