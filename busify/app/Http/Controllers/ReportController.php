<?php

namespace App\Http\Controllers;

//require '/opt/lampp/htdocs/Busify/busify/vendor/autoload.php';
require base_path('vendor/autoload.php');


use PHPJasper\PHPJasper;    

class ReportController extends Controller
{
    public function showClientsReport(){

        $filename = 'debtors_report';

        $pdfPath = $this->__create_pdf($filename);       

        return view('report', compact('pdfPath'));
    }

    public function showUnitsReport(){

        $filename = 'units_report';

        $pdfPath = $this->__create_pdf($filename);       

        return view('report', compact('pdfPath'));
    }

    public function showIncomesReport(){

        $filename = 'incomes_report';

        $pdfPath = $this->__create_pdf($filename);       

        return view('report', compact('pdfPath'));
    }

    private function __create_pdf(String $fileName){        

        $time = time();
        $imgPath = public_path().'/report/images/school_bus_header.png';
        $input = public_path().'/report/'.$fileName.'.jrxml';   
        $output = public_path().'/report/cache/'.$time.'_'.$fileName;   
             
        $options = [
            'format' => ['pdf'],
            'locale' => 'es_ES',
            'params' => ['filePath' => $imgPath],
            'db_connection' => [            
                'driver' => env('DB_CONNECTION'),
                'username' => env('DB_USERNAME'),
                'password' => env('DB_PASSWORD'), // NO deja poner 'password' en blanco.
                'host' => env('DB_HOST'),
                'database' => env('DB_DATABASE'),
                'port' => env('DB_PORT')
            ]
        ];

        $report = new PHPJasper;

        $report->process(
                $input,
                $output,
                $options
        )->execute();

        return '/report/cache/'.$time.'_'.$fileName.'.pdf';
    }
}
