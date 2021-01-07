<?php

defined('BASEPATH') or exit('Buraya erişiminiz yasak.');

class restapi_formatter
{
    public $format;
    public $default = "json"; // Set Default Format to be Converted

    /* Select Format Func. */
    public function set_format($format)
    {
        /* Avaible Formats */
        $formats = array(
            'xml',
            'json',
        );

        
        if (in_array($format, $formats)) {
            /* Selected Format is If avaible */
            $this->format = $format;
        } else {
            /* Selected Format is If does not avaible */
            $this->format = $this->format->default;
        }
    }

    /* Formatter Func. */
    public function convert_to_format($result)
    {
        $format = $this->format; // Get Format from this Class

        /* Check if Format is Selected */
        if ($this->format == null)
            $format = $this->default;
            
        /* Check Selected Format */
        if ($format == "xml") {                           // Check if Selected Format is XML
            header('Content-Type: text/xml');             // Set Header 'Content-Type' to XML
            $response = $this->convert_to_xml($result);   // Convert to XML Format a Data
        } elseif ($format == "json") {                    // Check if Selected Format is JSON
            header('Content-Type: application/json');     // Set Header 'Content-Type' to JSON
            $response = $this->convert_to_json($result);  // Convert to JSON Format a Data
        }
        return $response;                                 // Return Response
    }

    /* XML Convert Func. */
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

    /* JSON Convert Func. */
    private function convert_to_json($result)
    {
        return json_encode($result);
    }
}
