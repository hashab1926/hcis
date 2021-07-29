<?php

namespace App\Libraries;

use Dompdf\Dompdf;
use Dompdf\Options as Options;

class Pdf extends Dompdf
{
    public $FileName;
    public $title;
    public $author;
    public $keywords;
    public $ContentType;

    public function __construct()
    {
        parent::__construct(array('enable_remote' => true));
    }
    public function setFileName($file)
    {
        $this->FileName = $file;
        return $this;
    }

    public function viewPrint($view, $data = array())
    {
        try {
            $html = "<html><head>{$this->title}{$this->author}{$this->keywords}{$this->ContentType}</head>";
            $html .= $view . "</html>";
            $this->load_html($html);
            // Render the PDF
            $this->render();
            // Output the generated PDF to Browser
            $this->stream($this->FileName, array("Attachment" => false));
        } catch (Throwable $error) {
            throw new Exception($error->getMessage() . $error->getFile() . ' Line : ' . $error->getLine());
        }
    }

    public function setTitle($title)
    {
        $this->title = "<title>{$title}</title>";
        return $this;
    }

    public function setAuthor($author)
    {
        $this->author = "<meta name='author' content='{$author}'>";
        return $this;
    }

    public function setKeyword($keywords)
    {
        $this->keywords = "<meta name='keywords' content='{$keywords}'>";
        return $this;
    }

    public function setContentType($text)
    {
        $this->ContentType = "<meta http-equiv='Content-Type' content='{$text}' />";
        return $this;
    }
    public function htmlToPdf($options)
    {
        $opt = new Options();
        $opt->setIsHtml5ParserEnabled(true);
        $opt->setIsRemoteEnabled(true);
        $opt->setDebugPng(true);
        $opt->setIsPhpEnabled(true);

        $this->setPaper($options['paper'], $options['layout'] ?? 'portait');
        $this->setFileName("print.pdf")
            ->setTitle($options['title'])
            ->setAuthor($options['author'])
            ->setContentType("text/html; charset=UTF-8")
            ->viewPrint($options['html']);
    }
}
