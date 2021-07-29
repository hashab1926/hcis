<?php

namespace App\Libraries;

class Library
{

    public function activeIf($url, $string = 'active')
    {
        $currentUrl = current_url();
        if ($currentUrl == base_url($url))
            return $string;
    }
    public function activeIfRoutes($controllerMethod, $string = 'active')
    {
        $router = service('router');
        $splitController  = preg_split('/\\\|\//', $router->controllerName());
        $controller = $splitController[count($splitController) - 1];
        $method = $router->methodName();
        $access = "{$controller}/{$method}";
        if (strtolower($access) == strtolower($controllerMethod))
            return $string;
    }

    function addFile($fullPath, $type, $fileName)
    {
        return curl_file_create($fullPath, $type, $fileName);
    }

    function mimeTypeBase64Code($fotoBase64)
    {
        $finfo = new \finfo(FILEINFO_MIME);
        $fileInfo = $finfo->buffer(base64_decode($fotoBase64));
        $mimeType = explode('; ', $fileInfo)[0] ?? false;

        return $mimeType;
    }
    function validationFile($files)
    {
        $error = $files['error'];
        if ($error == 1 || $error == 2) :
            throw new \Exception("File melebihi kapasitas, silahkan coba lagi" . $error);
        elseif ($error == 3) :
            throw new \Exception("File yang anda upload hanya sebagian, mungkin rusak. silahkan coba lagi");
        elseif ($error == 4) :
            throw new \Exception("Anda belum upload file, silahkan upload file");
        elseif ($error != 0) :
            throw new \Exception("file tidak diketahui, silahkan coba lagi");

        endif;
        return true;
    }


    function cariKeywordTemplate($template, $keywordDicari)
    {
        foreach ($template as $list) :
            if (strtolower($list->keyword) == strtolower($keywordDicari))
                return true;
        endforeach;

        return false;
    }

    function displayKeywordTemplate($template, $keywordDicari)
    {
        foreach ($template as $list) :
            if (strtolower($list->keyword) == strtolower($keywordDicari))
                return base64_decode($list->display);
        endforeach;

        return false;
    }

    function timeToText($Time)
    {

        $Explode = explode(' ', $Time);
        $ExplodeDate = explode('-', $Explode[0]);
        $ExplodeTime = explode(':', $Explode[1]);

        $Year = $ExplodeDate[0];
        $Month = $ExplodeDate[1];
        $Date = $ExplodeDate[2];

        $Now = date('Y-m-d');
        $DateTime = "{$Year}-{$Month}-{$Date}";

        $JamNow = date('H');
        $MenitNow = date('i');

        $Jam = $ExplodeTime[0];
        $Menit = $ExplodeTime[1];
        $Detik = $ExplodeTime[2];

        // kalau sekarang
        if ($DateTime == $Now) {
            $MenitReal =  abs($this->timeDiff("{$Jam}:{$Menit}", "{$JamNow}:{$MenitNow}")) / 60;
            $Tanggal = intval($MenitReal) . " Menit lalu";
            if ($MenitReal > 60) {
                $MenitReal =  abs($this->timeDiff("{$Jam}:{$Menit}", "{$JamNow}:{$MenitNow}")) / 60 / 60;
                $Tanggal = intval($MenitReal) . ' Jam lalu';
            } elseif ($MenitReal <= 0)
                $Tanggal = 'Baru saja';
        }
        // kalau taun ini
        elseif (date('Y') == $Year) {
            $Tanggal = $Date . " " . $this->bulanToText($Month);
            $date1 = "2007-03-24";
            $date2 = "2009-06-26";

            $diff = abs(strtotime($DateTime) - strtotime($Now));
            $years = floor($diff / (365 * 60 * 60 * 24));
            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
            $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
            // 1 - 7
            if ($days <= 30)
                $Tanggal = $days . " Hari lalu";
            // if(intval(date('d'))   )
        } elseif (date('Y') != $Year)
            $Tanggal = $Date . " " . $this->bulanToText($Month) . $Year;
        return $Tanggal;
    }

    public function dateDiff($tglAwal, $tglAkhir)
    {
        $timeTglAwal = strtotime($tglAwal); // or your date as well
        $timeTglAkhir = strtotime($tglAkhir);
        $dateDiff =  $timeTglAkhir - $timeTglAwal;
        return round($dateDiff / (60 * 60 * 24));;
    }

    function tanggalToText($Tgl, $Time = true)
    {

        $Explode = explode(' ', $Tgl);
        $ExplodeDate = explode('-', $Explode[0]);
        if ($Time == true) {
            $ExplodeTime = explode(':', $Explode[1]);
            $Jam = $ExplodeTime[0];
            $Menit = $ExplodeTime[1];
        }

        $Year = $ExplodeDate[0];
        $Month = $ExplodeDate[1];
        $Date = $ExplodeDate[2];


        $Month = $this->bulanToText($Month);
        if ($Time == false)
            return "{$Date} {$Month} {$Year}";

        return "{$Date} {$Month} {$Year} jam {$Jam}:{$Menit}";
    }

    function ucFirst($string)
    {
        return ucfirst(strtolower($string));
    }
    function timeDiff($firstTime, $lastTime)
    {
        $firstTime = strtotime($firstTime);
        $lastTime = strtotime($lastTime);
        $timeDiff = $lastTime - $firstTime;
        return $timeDiff;
    }
    function bulanToText($number)
    {
        $tampung = '';
        switch ($number) {
            case 1:
                $tampung = 'Januari';
                break;
            case 2:
                $tampung = 'Februari';
                break;
            case 3:
                $tampung = 'Maret';
                break;
            case 4:
                $tampung = 'April';
                break;
            case 5:
                $tampung = 'Mei';
                break;
            case 6:
                $tampung = 'Juni';
                break;
            case 7:
                $tampung = 'Juli';
                break;
            case 8:
                $tampung = 'Agustus';
                break;
            case 9:
                $tampung = 'September';
                break;
            case 10:
                $tampung = 'Oktober';
                break;
            case 11:
                $tampung = 'November';
                break;
            case 12:
                $tampung = 'Desember   ';
                break;
        }

        return $tampung;
    }

    public function levelUser($level)
    {
        $text =  '';
        switch ($level) {
            case '1':
                $text = 'Karyawan Biasa';
                break;
            case '2':
                $text = 'Admin Divisi';
                break;

            case '3':
                $text = 'Kepala Divisi';
                break;
            case '4':
                $text = 'Admin IT';
                break;
            case 'DIR':
                $text = 'Direktur';
                break;
        }

        return $text;
    }

    public function mimeToExt($mime)
    {
        $mime_map = [
            'video/3gpp2'                                                               => '3g2',
            'video/3gp'                                                                 => '3gp',
            'video/3gpp'                                                                => '3gp',
            'application/x-compressed'                                                  => '7zip',
            'audio/x-acc'                                                               => 'aac',
            'audio/ac3'                                                                 => 'ac3',
            'application/postscript'                                                    => 'ai',
            'audio/x-aiff'                                                              => 'aif',
            'audio/aiff'                                                                => 'aif',
            'audio/x-au'                                                                => 'au',
            'video/x-msvideo'                                                           => 'avi',
            'video/msvideo'                                                             => 'avi',
            'video/avi'                                                                 => 'avi',
            'application/x-troff-msvideo'                                               => 'avi',
            'application/macbinary'                                                     => 'bin',
            'application/mac-binary'                                                    => 'bin',
            'application/x-binary'                                                      => 'bin',
            'application/x-macbinary'                                                   => 'bin',
            'image/bmp'                                                                 => 'bmp',
            'image/x-bmp'                                                               => 'bmp',
            'image/x-bitmap'                                                            => 'bmp',
            'image/x-xbitmap'                                                           => 'bmp',
            'image/x-win-bitmap'                                                        => 'bmp',
            'image/x-windows-bmp'                                                       => 'bmp',
            'image/ms-bmp'                                                              => 'bmp',
            'image/x-ms-bmp'                                                            => 'bmp',
            'application/bmp'                                                           => 'bmp',
            'application/x-bmp'                                                         => 'bmp',
            'application/x-win-bitmap'                                                  => 'bmp',
            'application/cdr'                                                           => 'cdr',
            'application/coreldraw'                                                     => 'cdr',
            'application/x-cdr'                                                         => 'cdr',
            'application/x-coreldraw'                                                   => 'cdr',
            'image/cdr'                                                                 => 'cdr',
            'image/x-cdr'                                                               => 'cdr',
            'zz-application/zz-winassoc-cdr'                                            => 'cdr',
            'application/mac-compactpro'                                                => 'cpt',
            'application/pkix-crl'                                                      => 'crl',
            'application/pkcs-crl'                                                      => 'crl',
            'application/x-x509-ca-cert'                                                => 'crt',
            'application/pkix-cert'                                                     => 'crt',
            'text/css'                                                                  => 'css',
            'text/x-comma-separated-values'                                             => 'csv',
            'text/comma-separated-values'                                               => 'csv',
            'application/vnd.msexcel'                                                   => 'csv',
            'application/x-director'                                                    => 'dcr',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'docx',
            'application/x-dvi'                                                         => 'dvi',
            'message/rfc822'                                                            => 'eml',
            'application/x-msdownload'                                                  => 'exe',
            'video/x-f4v'                                                               => 'f4v',
            'audio/x-flac'                                                              => 'flac',
            'video/x-flv'                                                               => 'flv',
            'image/gif'                                                                 => 'gif',
            'application/gpg-keys'                                                      => 'gpg',
            'application/x-gtar'                                                        => 'gtar',
            'application/x-gzip'                                                        => 'gzip',
            'application/mac-binhex40'                                                  => 'hqx',
            'application/mac-binhex'                                                    => 'hqx',
            'application/x-binhex40'                                                    => 'hqx',
            'application/x-mac-binhex40'                                                => 'hqx',
            'text/html'                                                                 => 'html',
            'image/x-icon'                                                              => 'ico',
            'image/x-ico'                                                               => 'ico',
            'image/vnd.microsoft.icon'                                                  => 'ico',
            'text/calendar'                                                             => 'ics',
            'application/java-archive'                                                  => 'jar',
            'application/x-java-application'                                            => 'jar',
            'application/x-jar'                                                         => 'jar',
            'image/jp2'                                                                 => 'jp2',
            'video/mj2'                                                                 => 'jp2',
            'image/jpx'                                                                 => 'jp2',
            'image/jpm'                                                                 => 'jp2',
            'image/jpeg'                                                                => 'jpeg',
            'image/pjpeg'                                                               => 'jpeg',
            'application/x-javascript'                                                  => 'js',
            'application/json'                                                          => 'json',
            'text/json'                                                                 => 'json',
            'application/vnd.google-earth.kml+xml'                                      => 'kml',
            'application/vnd.google-earth.kmz'                                          => 'kmz',
            'text/x-log'                                                                => 'log',
            'audio/x-m4a'                                                               => 'm4a',
            'application/vnd.mpegurl'                                                   => 'm4u',
            'audio/midi'                                                                => 'mid',
            'application/vnd.mif'                                                       => 'mif',
            'video/quicktime'                                                           => 'mov',
            'video/x-sgi-movie'                                                         => 'movie',
            'audio/mpeg'                                                                => 'mp3',
            'audio/mpg'                                                                 => 'mp3',
            'audio/mpeg3'                                                               => 'mp3',
            'audio/mp3'                                                                 => 'mp3',
            'video/mp4'                                                                 => 'mp4',
            'video/mpeg'                                                                => 'mpeg',
            'application/oda'                                                           => 'oda',
            'audio/ogg'                                                                 => 'ogg',
            'video/ogg'                                                                 => 'ogg',
            'application/ogg'                                                           => 'ogg',
            'application/x-pkcs10'                                                      => 'p10',
            'application/pkcs10'                                                        => 'p10',
            'application/x-pkcs12'                                                      => 'p12',
            'application/x-pkcs7-signature'                                             => 'p7a',
            'application/pkcs7-mime'                                                    => 'p7c',
            'application/x-pkcs7-mime'                                                  => 'p7c',
            'application/x-pkcs7-certreqresp'                                           => 'p7r',
            'application/pkcs7-signature'                                               => 'p7s',
            'application/pdf'                                                           => 'pdf',
            'application/octet-stream'                                                  => 'pdf',
            'application/x-x509-user-cert'                                              => 'pem',
            'application/x-pem-file'                                                    => 'pem',
            'application/pgp'                                                           => 'pgp',
            'application/x-httpd-php'                                                   => 'php',
            'application/php'                                                           => 'php',
            'application/x-php'                                                         => 'php',
            'text/php'                                                                  => 'php',
            'text/x-php'                                                                => 'php',
            'application/x-httpd-php-source'                                            => 'php',
            'image/png'                                                                 => 'png',
            'image/x-png'                                                               => 'png',
            'application/powerpoint'                                                    => 'ppt',
            'application/vnd.ms-powerpoint'                                             => 'ppt',
            'application/vnd.ms-office'                                                 => 'ppt',
            'application/msword'                                                        => 'doc',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'application/x-photoshop'                                                   => 'psd',
            'image/vnd.adobe.photoshop'                                                 => 'psd',
            'audio/x-realaudio'                                                         => 'ra',
            'audio/x-pn-realaudio'                                                      => 'ram',
            'application/x-rar'                                                         => 'rar',
            'application/rar'                                                           => 'rar',
            'application/x-rar-compressed'                                              => 'rar',
            'audio/x-pn-realaudio-plugin'                                               => 'rpm',
            'application/x-pkcs7'                                                       => 'rsa',
            'text/rtf'                                                                  => 'rtf',
            'text/richtext'                                                             => 'rtx',
            'video/vnd.rn-realvideo'                                                    => 'rv',
            'application/x-stuffit'                                                     => 'sit',
            'application/smil'                                                          => 'smil',
            'text/srt'                                                                  => 'srt',
            'image/svg+xml'                                                             => 'svg',
            'application/x-shockwave-flash'                                             => 'swf',
            'application/x-tar'                                                         => 'tar',
            'application/x-gzip-compressed'                                             => 'tgz',
            'image/tiff'                                                                => 'tiff',
            'text/plain'                                                                => 'txt',
            'text/x-vcard'                                                              => 'vcf',
            'application/videolan'                                                      => 'vlc',
            'text/vtt'                                                                  => 'vtt',
            'audio/x-wav'                                                               => 'wav',
            'audio/wave'                                                                => 'wav',
            'audio/wav'                                                                 => 'wav',
            'application/wbxml'                                                         => 'wbxml',
            'video/webm'                                                                => 'webm',
            'audio/x-ms-wma'                                                            => 'wma',
            'application/wmlc'                                                          => 'wmlc',
            'video/x-ms-wmv'                                                            => 'wmv',
            'video/x-ms-asf'                                                            => 'wmv',
            'application/xhtml+xml'                                                     => 'xhtml',
            'application/excel'                                                         => 'xl',
            'application/msexcel'                                                       => 'xls',
            'application/x-msexcel'                                                     => 'xls',
            'application/x-ms-excel'                                                    => 'xls',
            'application/x-excel'                                                       => 'xls',
            'application/x-dos_ms_excel'                                                => 'xls',
            'application/xls'                                                           => 'xls',
            'application/x-xls'                                                         => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => 'xlsx',
            'application/vnd.ms-excel'                                                  => 'xlsx',
            'application/xml'                                                           => 'xml',
            'text/xml'                                                                  => 'xml',
            'text/xsl'                                                                  => 'xsl',
            'application/xspf+xml'                                                      => 'xspf',
            'application/x-compress'                                                    => 'z',
            'application/x-zip'                                                         => 'zip',
            'application/zip'                                                           => 'zip',
            'application/x-zip-compressed'                                              => 'zip',
            'application/s-compressed'                                                  => 'zip',
            'multipart/x-zip'                                                           => 'zip',
            'text/x-scriptzsh'                                                          => 'zsh',
            'Tidak Diketahui'                                                           => 'tidak diketahui'
        ];

        return isset($mime_map[$mime]) === true ? $mime_map[$mime] : false;
    }
}
