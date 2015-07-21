<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title></title>
	<meta name="generator" content="LibreOffice 4.4.2.2 (Linux)"/>
	<meta name="created" content="2015-07-14T07:50:34.578763660"/>
	<meta name="changed" content="2015-07-14T07:56:43.571630648"/>
	
	<style type="text/css">
		body,div,table,thead,tbody,tfoot,tr,th,td,p { font-family:"Liberation Sans"; font-size:x-small }
	</style>
	
</head>

<body>
    <table cellspacing="0" border="0">
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left"><b>AUTHOR</b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left"><b>SOURCE</b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left"><b>COUNT</b></td>
        </tr>        
        <?php
        $fila = 1;
        if (($archivo = fopen(dirname(__FILE__)."/logs/gitblame.txt", "r")) !== FALSE) {
            while (($fila = fgetcsv($archivo, 1000, "\t")) !== FALSE) {
                preg_match("/^\s/i", $fila[0], $check);
                if(count($check) == 1) {
                    preg_match_all("/[0-9]+/i", $fila[0], $number);
                    if(isset($number[0][0]))
                    {
                        preg_match_all("/[a-z]+/i", $fila[0], $letter);

                ?>
                    <tr>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left"></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left"><b><?php echo implode(".", $letter[0]); ?></b></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left"><b><?php echo $number[0][0]; ?></b></td>
                    </tr>
                <?php
                    }
                }
                else
                {
                    if((strpos($fila[0], "AUTHOR") === false) && (strpos($fila[0], "-") === false) && (strpos($fila[0], "PHPCBF") === false) && (strpos($fila[0], "PHP") === false))
                    {
                            preg_match_all("/[a-z]+/i", $fila[0], $letter);
                        ?>
                            <tr>
                                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left" colspan="3"><?php echo implode(".", $letter[0]); ?></td>
                            </tr>
                        <?php                         
                    }
                }
            }
            fclose($archivo);
        }
        ?>
    </table>
</body>
</html>
