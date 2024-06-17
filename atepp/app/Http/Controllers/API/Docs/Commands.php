<?php

namespace App\Http\Controllers\Api\Docs;

use App\Http\Controllers\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Dompdf\Canvas\Factory as CanvasFactory;
use Dompdf\Options as DompdfOptions;
use Dompdf\Adapter\CPDF;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\FileUpload\InputFile;

use App\Services\FirebaseService;
use App\Models\BotModel;
use App\Models\ProjectModel;
use App\Models\EndpointModel;

use App\Helpers\Generator;

class Commands extends Controller
{
    public function generate_endpoint_run(Request $request) 
    {
        try {
            $user_id = $request->user()->id;
            $bots = BotModel::get_user_bots($user_id);
    
            $time = time();
            $datetime = date("Y-m-d_H:i:s");
    
            $options = new DompdfOptions();
            $options->set('defaultFont', 'Courier');
            $dompdf = new Dompdf($options);

            $content = $request->content;
            $beautifiedResponse = json_encode($content['endpoint_response_body'], JSON_PRETTY_PRINT);
    
            $html = "
            <html>
                <head>
                    <style>
                        body { font-family: Courier; }
                        .box { border: 1px solid black; padding: 6px 10px; }
                        p, pre { font-size: 11px; }
                    </style>
                </head>
                <body>
                    <h2>[project_title]</h2>
                    <h3>API Tempalte</h3>
                    <h4>About Project</h4>
                    <p>[project_desc]</p><br>
                    <h4>Endpoint</h4>
                    <p>The url API requests is:</p>
                    <p>".$content['endpoint_method']." | ".$content['endpoint_url']."</p><br>
                    <h4>Notes : </h4>
                    <p>[docs_notes]</p><br>

                    <h3>Example</h3>
                    <h4>Status : <b>".$content['endpoint_status_code']."</b></h4>
                    <div class='box'>
                        <h4>Response : </h4>
                        <pre>$beautifiedResponse</pre>    
                    </div>     
                    
                    <h3>Test</h3>
                    <h4>Time Taken : ".$content['time_taken']."</h4>
                </body>
            </html>";
    
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
    
            $pdfContent = $dompdf->output();
            $pdfFilePath = public_path('endpoint_run.pdf');
            file_put_contents($pdfFilePath, $pdfContent);
            $inputFile = InputFile::create($pdfFilePath, $pdfFilePath);

            if($bots){
                foreach($bots as $dt){
                    $response = Telegram::sendDocument([
                        'chat_id' => $dt->bot_id,
                        'document' => $inputFile,
                        'caption' => "Hello $dt->username, An endpoint has been tested and the document is generated!",
                        'parse_mode' => 'HTML'
                    ]);
                }
            }

            $firebaseService = new FirebaseService();
            $firebaseUrl = $firebaseService->uploadFile($pdfFilePath, "endpoint/docs/".$user_id, "endpoint_run_$datetime.pdf");
    
            unlink($pdfFilePath);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Document generated',
                'url' => $firebaseUrl,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
