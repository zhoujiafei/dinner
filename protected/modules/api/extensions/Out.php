<?php
class Out
{
	/*****************************json输出*****************************/
	public static function jsonOutput($data = array(),$callback = '')
	{
        header('content-type:text/html;charset=utf-8');  
        if(empty($callback))
        {
            echo json_encode($data);
        }
        else
        {
            echo $callback.'('.json_encode($data).');';
        }
        exit;
    }
    /*****************************json输出*****************************/
    
    /*****************************xml输出******************************/
    public static function xmlOutput($data = array(),$xmlroot = 'Root')
    {
    	header('content-type:text/xml;charset=utf-8');  
        echo self::_xmlEncode($data,$xmlroot);
    }
    
    private static function _xmlEncode($data = array(),$xmlroot = 'Root',$encoding='utf-8')
    {
    	$xml = "<?xml version=\"1.0\" encoding=\"" . $encoding . "\"?>\n";  
        $xml.= "<" . $xmlroot . ">\n";  
        $xml.= self::_dataToXml($data);  
        $xml.= "</" . $xmlroot . ">";  
        return $xml;
    }
    
    private static function _dataToXml($data = array())
    {
        $xml = '';
        foreach ($data as $key => $val) 
        {
            is_numeric($key) && $key = "item id=\"$key\"";  
            $xml.="<$key>";  
            $xml.= (is_array($val)) ? self::_dataToXml($val) : self::_isAddCDATA($val);  
            list($key, ) = explode(' ', $key);  
            $xml.="</$key>\n";  
        }
        return $xml; 
    }
    
    //判断是否需要加上<![CDATA[]]>标记
    private static function _isAddCDATA($val)
    {
        if(!empty($val) && !preg_match('/^[A-Za-z0-9+$]/',$val))
        {  
            $val = '<![CDATA['.$val.']]>';  
        }  
        return $val;  
    }
    /*****************************xml输出******************************/
    
    /*****************************array输出****************************/
    public static function arrayOutput($data = array())
    {
    	header('content-type:text/html;charset=utf-8');  
        echo '<pre>';  
        print_r($data);  
        echo '</pre>';
    }
    /*****************************array输出****************************/
}