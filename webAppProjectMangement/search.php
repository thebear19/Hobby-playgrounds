<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search</title>
<?
	include("connect.php");
	include("button.php");
	$sql = "SELECT * FROM project WHERE Project_Status != 'deleted'";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) != 0){
	
	header('Content-Type:text/html;charset=UTF-8');
	define('SWATH', dirname(__FILE__).'\swath');

	function swath($input_text)
    {
        $input_filename= tempnam("\tmp", "swath_");
        $output_filename= tempnam("\tmp", "swath_");
        $input_text = iconv('UTF-8','TIS-620',trim($input_text));
		
        file_put_contents($input_filename, $input_text);
        system(SWATH . '\swath.exe -b "&nbsp;" -d ' . SWATH . '\swath -m max <'.$input_filename.'>'.$output_filename);
 
        $raw = file_get_contents($output_filename);
        $raw = iconv('TIS-620','UTF-8',rtrim($raw));
       
        unlink($input_filename);
        unlink($output_filename);
		
        return $raw;
    }
	include('Zend/Search/Lucene.php');
	
	$analyzer = new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive();
	Zend_Search_Lucene_Analysis_Analyzer::setDefault($analyzer);
	
	$storage = dirname(__FILE__) . '/data/search';
	//-------------------
	$index = Zend_Search_Lucene::create($storage);
 
	for($i=0;$row = mysql_fetch_array($result);$i++)
	{
		$documents[$i] = array(
      	'Project_ID' => $row['Project_ID'],
      	'Project_Name' => $row['Project_Name'],
      	//'Principles' => $row['Project_Principles_Rationale'],
      	'Manager' => $row['Project_Manager'],
      	'Location' => $row['Project_Location'],
      	'Target' => $row['Project_Target'],
		'Status' => $row['Project_Status']
		);
	}
	
	$doc = new Zend_Search_Lucene_Document();
	
	foreach ($documents as $document)
	{
        $doc->addField(Zend_Search_Lucene_Field::Keyword('Project_ID',$document['Project_ID']));
        $doc->addField(Zend_Search_Lucene_Field::UnIndexed('Project_Name',$document['Project_Name'], 'utf-8'));
		$doc->addField(Zend_Search_Lucene_Field::UnIndexed('Manager',$document['Manager'], 'utf-8'));
		$doc->addField(Zend_Search_Lucene_Field::UnIndexed('Target',$document['Target'], 'utf-8'));
		$doc->addField(Zend_Search_Lucene_Field::UnIndexed('Status',$document['Status'], 'utf-8'));
 
        //$doc->addField(Zend_Search_Lucene_Field::UnStored('Principles_Index',swath($document['Principles']),'utf-8'));
		$doc->addField(Zend_Search_Lucene_Field::UnStored('Manager_Index',swath($document['Manager']),'utf-8'));
		$doc->addField(Zend_Search_Lucene_Field::UnStored('Location_Index',swath($document['Location']),'utf-8'));
		$doc->addField(Zend_Search_Lucene_Field::UnStored('Target_Index',swath($document['Target']),'utf-8'));
		
        $index->addDocument($doc);
	}
	$index->commit();
	$index->optimize();}
?>
</head>

<body>
<form method="post" action="" name="form">
	<center>
    	<h1>ค้นหา</h1>
		<input type="text" name="keyword" placeholder="ระบุคำค้นหา" value="<? if(isset($_POST['sub']) && $_POST['keyword'] != ""){echo $_POST['keyword'];}?>" />
		<input type="submit" name="sub" value="ค้นหา"  />
    </center>
</form>

<?
	if(isset($_POST['sub']) && $_POST['keyword'] != "")
	{
		$keyword = $_POST['keyword'];
 
		Zend_Search_Lucene::setResultSetLimit(1000);
 
		$index = Zend_Search_Lucene::open($storage);
	
		$query = Zend_Search_Lucene_Search_QueryParser::parse($keyword, 'UTF-8');
 
		$hits = $index->find($query);
		
		echo "<hr />";
		echo "<div id='results'>";
		echo "<p>ผลการค้นหา : <strong>" . count($hits) . "</strong> รายการ</p>";
		echo "<hr />";
		foreach ($hits as $hit)
		{
    		echo "<h3><a href='projectview.php?prj_id=". $hit->Project_ID ."'>" . $hit->Project_Name ."</a></h3>";
    		echo "<em>" .$hit->Target ."</em>";
			if($hit->Status == "อยู่ระหว่างดำเนินการ")
			{$status = "<font color='#FF0000'>".$hit->Status."</font>";}
			else{$status = "<font color='#00FF00'>".$hit->Status."</font>";}
    		echo "<p>". $hit->Manager ."&emsp;".$status."</p>";
		}
		echo "</div>";
	}
?>
</body>
</html>