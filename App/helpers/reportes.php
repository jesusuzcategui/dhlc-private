<?php namespace App\Helpers;

defined("BASEPATH") or die("ACCESS DENIED");

use \Dompdf\Dompdf;

class reportes
{
  const HEADER_REPORT = '
                        <div class="reporte_heading">
                          
                        </div>';
  const VIEWS_REPORT_PATH = "../App/views/reports/";

  public static $content;

  private static $pdf;

  public function __construct()
  {
    self::$content = '';
    self::$pdf     = new Dompdf;
  }

  /**
  * @method render
  * This method set visible the document type pdf has using the library Dompdf.
  */
  public static function render($template="", $filename="")
  {
    $file = include( self::VIEWS_REPORT_PATH . $template );
    self::$content .= '<!doctype html>
                       <html lang="es">
                          <head>
                            <meta charset="utf-8">
                            <style type="text/css">
                              body {
                                font-family: sans-serif;

                              }
                              h1 {
                                display: block;
                                margin: 0px auto 30px;
                                width: 100%;
                                text-align: center;
                                font-weight: normal
                              }
                              table {
                                width: 100%;
                                border: solid 1px #000;
                                border-collapse: collapse;
                                font-family: sans-serif;
                                display: table;
                                margin: 30px auto 0;
                              }
                              table tr td, table tr th {
                                font-size: 12pt;
                                border: solid 1px #000;
                                word-break: break-all;
                                overflow-wrap: break-word;
                                word-wrap: break-word;
                              }
                            </style>
                          </head>';
    self::$content .= '   <body>';
    self::$content .= $file;
    self::$content .= '
                          </body>
                          </html>';
    self::$content .= htmlspecialchars_decode(self::$content);
    self::$pdf->set_paper('letter');
    self::$pdf->set_option('isRemoteEnabled', true);
    self::$pdf->load_html(self::$content, 'UTF-8');
    self::$pdf->render();
    self::$pdf->stream(
      ($filename == "") ? "Report_".date('d-m-Y').".pdf" : $filename,
      array("Attachment" => false)
    );
  }
  
  public static function output($template="", $filename="")
  {
    $file = include( self::VIEWS_REPORT_PATH . $template );
    self::$content .= '<style>
                        body {
                          font-family: sans-serif;

                        }
                        h1 {
                          display: block;
                          margin: 0px auto 30px;
                          width: 100%;
                          text-align: center;
                        }
                        table {
                          width: 100%;
                          border: solid 1px #000;
                          border-collapse: collapse;
                          font-family: sans-serif;
                          display: table;
                          margin: 30px auto 0;
                        }
                        table tr td, table tr th {
                          max-width: 20% !important;
                          font-size: 10pt;
                          border: solid 1px #000;
                          word-break: break-all;
                          overflow-wrap: break-word;
                          word-wrap: break-word;
                        }

                       </style>';
    self::$content .= '<div class="page_report">';
    self::$content .= '<img src="./images/banner1.png" style="width: 100%; object-fit: cover; display: block;" />
                      <div>';
    self::$content .= $file;
    self::$content .= '</div></div>';
    self::$pdf->set_paper('letter');
    self::$pdf->load_html( utf8_decode(self::$content) );
    self::$pdf->render();
    //self::$pdf->stream('racarga.pdf');
    self::$pdf->output();
   // file_put_contents( self::$pdf->output(), 'pdf2.pdf');
  }
}
