<?php

namespace DbBackup;

class Backup 
{
    public static function make($host,$user,$pass,$name,$tables = '*', $zipit = true)
    {
 
      $link = mysql_connect($host,$user,$pass);
      mysql_set_charset('utf8',$link);
      mysql_select_db($name,$link);
      
      //get all of the tables
      if($tables == '*')
      {
          $tables = array();
          $result = mysql_query('SHOW TABLES');
          while($row = mysql_fetch_row($result))
          {
              $tables[] = $row[0];
          }
      }
      else
      {
          $tables = is_array($tables) ? $tables : explode(',',$tables);
      }

      $return = '';

      foreach($tables as $table)
      {
          $return .= 'DROP TABLE IF EXISTS'.$table.';';
          $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
          $return .= "\n\n".$row2[1].";\n\n";

          $result = mysql_query('SELECT * FROM '.$table);
          $num_fields = mysql_num_fields($result);
                    
          for ($i = 0; $i < $num_fields; $i++) 
          {
              while($row = mysql_fetch_row($result))
              {
                  $return.= 'INSERT INTO '.$table.' VALUES(';
                  for($j=0; $j<$num_fields; $j++) 
                  {
                      $row[$j] = addslashes($row[$j]);
                      $row[$j] = preg_replace("/\n/","\\n",$row[$j]);
                      if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                      if ($j<($num_fields-1)) { $return.= ','; }
                  }
                  $return.= ");\n";
              }
          }
          $return.="\n\n\n";
      }
        
      if($zipit)
      {
          $fname = './storage/db-backup-'.$name.'-'.date("YmdHis").'.sql.gz';
          $gzdata = gzencode($return, 9);
          $handle = fopen($fname,'w+');
          fwrite($handle, $gzdata);
          fclose($handle);
      }
      else
      {
          $fname = './storage/db-backup-'.$name.'-'.date("YmdHis").'.sql';
          $handle = fopen($fname,'w+');
          fwrite($handle,$return);
          fclose($handle);  
      }      
      
      return $fname;
    }
}