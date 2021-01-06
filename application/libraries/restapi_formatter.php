<?php

defined('BASEPATH') or exit('Buraya erişiminiz yasak.');

class restapi_formatter
{
    public $format;
    public $default = "json";
    /* 
        Consturactor
    */
    public function __construct()
    {
    }

    public function set_format($format)
    {
        $formats = array(
            'xml',
            'json',
        );

        if (in_array($format, $formats)) {
            $this->format = $format;
        } else {
            $this->format = $this->format->default;
        }
    }

    public function convert_to_format($result)
    {
        $format = $this->format;
        if ($this->format != null)
            $format = $this->format;
        else
            $format = $this->default;
            
        if ($format == "xml") {
            header('Content-Type: text/xml');
            $response = $this->convert_to_xml($result);
        } elseif ($format == "json") {
            header('Content-Type: application/json');
            $response = $this->convert_to_json($result);
        }
        return $response;
    }

    private function convert_to_xml($result)
    {
        $first_key = array_key_first($result);
        $xml = "";
        if (is_array($result[$first_key])) {
            $xml .= "<products>";
            foreach ($result as $item) {
                $xml .= "<product>";
                foreach ($item as $key => $value) {
                    $xml .= "<" . $key . ">" . $value . "</" . $key . ">";
                }
                $xml .= "</product>";
            }
            $xml .= "</products>";
        } else {
            if (array_key_exists(0, $result))
                $parent_element = "result";
            else
                $parent_element = "product";

            $xml .= "<" . $parent_element . ">";
            foreach ($result as $key => $value) {
                if (is_numeric($key)) {
                    $xml .= "<value>" . $value . "</value>";
                } else {
                    $xml .= "<" . $key . ">" . $value . "</" . $key . ">";
                }
            }
            $xml .= "</" . $parent_element . ">";
        }
        return $xml;
    }
    private function convert_to_json($result)
    {
        return json_encode($result);
    }
}
