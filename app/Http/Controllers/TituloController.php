<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Titulo;
use App\User;
use App\Log;
use App\Carrera;

class TituloController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
/*
    $table->increments('id');
    $table->string('nombreYApellido');
    $table->string('dni');
    
    $table->boolean('ciclo');
    $table->string('tituloPrevio')->nullable();

    $table->string('fechaUltimaMateria');
    $table->string('fechaExpedicionDiploma');

    $table->integer('numeroDeTitulo')->default("-1");


    $table->enum('estado', ['cargaDeDatos', 'paraImpresion', 'impreso'])->default('cargaDeDatos');
    
    $table->integer('carrera_id');

    $table->timestamps();
*/
    public function create(){       
        $titulo = new Titulo([
            'nombreYApellido'    => request('nombre'),
            'dni'       => request('dni'),
            'ciclo' => false,
            'fechaUltimaMateria' => request('fechaUltimaMateria'),
            'fechaExpedicionDiploma' => request('fechaExpedicionDiploma'),
        ]);

        if(request('ciclo')){
            $titulo->ciclo = true;
            $titulo->tituloPrevio = request('tituloPrevio');
        }
        
        $c = Carrera::get()->find(request('carrera'));
        
        $c->titulo()->save($titulo);

        $this->logAction("Nuevo Titulo", implode(",",array("id:".$titulo->id,request('nombre'),request('apellido'),request('dni'),$c->nombre)));
        
        return redirect()->home()->with('success', 'Titulo creado exitosamente!');
    }

    public function edit($id){
        $c = Carrera::get()->find(request('carrera'));
        $titulo = Titulo::get()->find($id);
        $titulo->carrera()->associate($c);
        if(request('ciclo')){
            $titulo->ciclo = true;
            $titulo->tituloPrevio = request('tituloPrevio');
        }else{
            $titulo->ciclo = false;
            $titulo->tituloPrevio = "";
        }
        $titulo->update([
                        'nombreYApellido'    => request('nombre'),
                        'dni'                => request('dni'),
                        'fechaUltimaMateria' => request('fechaUltimaMateria'),
                        'fechaExpedicionDiploma' => request('fechaExpedicionDiploma'),
                        ]);
        
        $titulo->save();
        $aux = implode(",",array("id:".$titulo->id,request('nombre'),request('apellido'),request('dni'),$titulo->carrera->nombre));
        $this->logAction("Edita Titulo", $aux);
        return back()->with('success', 'Los cambios ya han sido registrados en el sistema');
    }

    public function print($id){
        $titulo = Titulo::get()->find($id);
        
                
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new \Mpdf\Mpdf([
            'fontdata' => $fontData + [
                'Zapf-humanist-601' => [
                    'R' => 'zapf-humanist-601-roman-bt.ttf',
                    'B' => 'zapf-humanist-601-bold-bt.ttf',
                ]
            ],
            'default_font' => 'Zapf-humanist-601',
            'orientation'=>'L',
            'format'=>'A3',
            "margin_left"=> 0
            ,"margin_right"=> 0
            ,"margin_top"=> 0
            ,"margin_bottom"=> 0
        ]);

        $html = $this->generarHTMLParaImprimir($titulo);

        if($titulo->estado == 'cargaDeDatos'){       
            $mpdf->SetWatermarkText('BORRADOR');
            $mpdf->showWatermarkText = true;
        }

        
        $mpdf->WriteHTML($html);

        $mpdf->Output('titulo.pdf',\Mpdf\Output\Destination::INLINE);
        
             
        $this->logAction("Imprime", implode(",",array("id:".$titulo->id,$titulo->nombre,$titulo->apellido,$titulo->dni,$titulo->carrera->nombre)));
        return back();
    }

    private function generarHTMLParaImprimir($titulo){
        
        //tituloPrevio
        if(!$titulo->ciclo)
            $content ="con DNI 31.268.753, el día ".$titulo->fechaUltimaMateria." ha dado cumplimiento a todos los
            requisitos del respectivo Plan de Estudios correspondiente a la carrera de ".$titulo->carrera->nombre."
            , y de acuerdo con lo que establecen las disposiciones vigentes, se le otorga el título de:";
        else
            $content = "con DNI 21.422.868, ingresó a la carrera con el título de ".$titulo->tituloPrevio.", 
            y ha dado cumplimiento a todos los requisitos del Plan de Estudios correspondiente a la 
            carrera de <b>".$titulo->carrera->nombre." - Ciclo de Licenciatura</b> el día ".$titulo->fechaUltimaMateria.", y de acuerdo con lo
            establecido por las disposiciones vigentes, se le otorga el título de:";

        
        $html= '
        <html>
        <head>
            <style>
                .texto{
                    position:absolute;
                    left:6cm;
                    right:6cm;
                    top:10cm;
                }
                .firma-s-a, .firma-r{
                    position: absolute;
                    bottom:4.8cm;
                    font-size: 7pt;
                }
                .firma-s-a {
                    left: 7.5cm
                }
                .firma-r {
                    left:30.4cm;
                }

            </style>
        </head>
        <body>
            <div class="texto">
                <h1 style="text-align:center;font-size:18pt;"><span >'.$titulo->carrera->escuela.'</span></h1>

                <p style="text-align:center;font-size:22pt;"><span >Por Cuanto</span></p>

                <p style="text-align:center;font-size:28pt;"><span ><b>'.$titulo->nombreYApellido.'</b></span></p>

                <p style="text-align:justify;font-size:22pt;"><span >'.$content.'</span></p>

                <p style="text-align:center;font-size:26pt;"><span ><b>'.$titulo->carrera->tituloAcademico.'</b></span></p>

                <p style="text-align:center;font-size:22pt;"><span ><b>(R.M. N&deg; '.$titulo->carrera->resolucion.')</b></span></p>

                <p style="text-align:justify;font-size:14pt;">&nbsp;Chilecito, '.$titulo->fechaExpedicionDiploma.'</p>
            </div>
                <div class="firma-s-a" >
                    Ing. Fernanda Beatriz Carmona
                </div>
            
                <div class="firma-r" >
                    Ing. Norberto Raul Caminoa
                </div>
            </div>
        </body>
        </html>
        ';
        return $html;
    }


    public function close($id){
        $titulo = Titulo::get()->find($id);
        $titulo->estado = 'paraImpresion';
        $titulo->save();
 
        $this->logAction("Cierra Titulo", implode(",",array("id:".$titulo->id,$titulo->nombre,$titulo->apellido,$titulo->dni,$titulo->carrera->nombre)));
        return back();
    }
    
    public function finalize($id){
        $titulo = Titulo::get()->find($id);
        $titulo->numeroDeTitulo = request('numeroDeTitulo');
        $titulo->estado = "impreso";
        $titulo->save();
        $this->logAction("Finaliza Titulo", implode(",",array("id:".$titulo->id,$titulo->nombre,$titulo->apellido,$titulo->dni,$titulo->carrera->nombre)));
        return back();
    }


    public function delete($id){
        $t = Titulo::find($id);
        $this->logAction("Elimina titulo", Auth::user()->email." Elimina el titulo de ".$t->nombreYApellido);
        $t->delete();
        return back()->with('warning', 'Titulo borrado! No se podra editar hasta restaurarlo');
    }

    public function restore($id){
        if(Auth::user()->admin){
            $t = Titulo::withTrashed()->find($id);
            $this->logAction("Restaura titulo", Auth::user()->email." Restaura el titulo de ".$t->nombreYApellido);
            $t->restore();
            $t->carrera()->withTrashed()->getResults()->restore();
        }
        return back()->with('success', 'Titulo restaurado! Ya puede editarlo nuevamente');
    }

    private function logAction($operacion, $descripcion){
        $l = new \App\Log;
        $l->operation = $operacion;
        $l->description = $descripcion;
        Auth::user()->log()->save($l);
    }
}
