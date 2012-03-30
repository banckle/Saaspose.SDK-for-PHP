<?
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename=output.pdf');
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					echo $DownloadStream;
					//header('Content-Length: ' . filesize($file));
					//ob_clean();
					//flush();
					//readfile($file);
					exit;

?>