<?php namespace Core; //Uso de namespace Core
defined("BASEPATH") or die("Access denied"); //Verificación de constante para la protección del proyecto.
class Files 
{
    public $file;
    public $path_final;
    private $source_upload;
    private $path_for_date;
    public $response = [];
    private $aviable_file = ['webp', 'jpg', 'jpeg', 'png', 'gif','pdf','txt','html','docx','doc'];
    private $ContentFileIndex = "<h1>404</h1>\n<p>Error Forbiden</p>";
    private $FileSizeMaximun = 5242880;

    public function __construct($path_end)
    {
        $this->source_upload = $path_end;
        $this->path_for_date = $this->source_upload.date('d-M-Y').'/';
        $fileIndex           = "{$this->path_for_date}index.html";

        if( !is_dir( $this->path_for_date ) ){
            mkdir( $this->path_for_date, 0777, true );
            chmod( $this->path_for_date, 0777 );
        }

        if ( !is_file($fileIndex) ) {

            if ($arch = fopen($fileIndex, 'a')  ) {
                if( !fwrite($arch, $this->ContentFileIndex) ) {
                    $response = 5;
                }
                fclose($arch);
            }

        }
    }

    public function verify($file)
    {
        $this->file = $file;
        
        $ext = pathinfo($this->file['name'], PATHINFO_EXTENSION);

        if ($this->file['size'] > $this->FileSizeMaximun) {

            $this->response = 1;

        } else if( !in_array($ext, $this->aviable_file)  ) {

            $this->response = 2;

        } else {

            $this->response = $file;

        }


        return $this->response; 
    }

    public function send($response)
    {
        if( $response == 1 ){

            $this->response = $response;

        } elseif( $response == 2 ){

            $this->response = $response;

        } else {

            $this->path_final = $this->path_for_date . uniqid('') . date('dmY-His') .basename( $response['name'] );

            move_uploaded_file($response["tmp_name"], $this->path_final);

            if ( is_file( $this->path_final ) ){

                $this->response = $this->path_final;

            } else {

                $this->response = 3;

            }
        }

        return $this->response;
        
    }
}