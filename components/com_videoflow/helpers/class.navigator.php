<?
##########################################################################################
# >> Simple class to browse directories <<
#
# Author: Boutekedjiret Zoheir Ramzi [http://www.zkara.net, zoheir_at_programmer.net]
# Special thanks to:
#            Dennis Vervest [http://www.nnsolutions.nl dennis_at_nnsolutions.nl]
#
#
# Changelog:
# -Start version at December, 17 2003 [v 1.1.dev]
# -January, 13 2004 adding sort function ( helpping by "Dennis Vervest" <dennis@nnsolutions.nl>) [v 1.2]
# -January, 17 2004 changing class using: NextDir() and NextFile (Denni's idea )
#
# Current version : 1.3
#
# This script has been created and released under the GNU GPL and is free to use and
# redistribute only if this copyright statement is not removed
#
#
#  how to use ?
# ииииииииииии
# $browser = new Navigator("/home/my_dir");
# Now you have a list of files on $FilesList, and the directories on $DirsList.
#    list's structure :
#               Name  : file's name
#               DateM : Last modification
#               Size  : In Byte
#               Perms : file's permessions
#               Owner : file's owner
#               Group : the owner's group
#
# note : set $GetDirSz=true if you want to show dir size
#
# Methods:
#  $browser->Pwd() : retrun current directory
#  $browser->ChgPerms($file,$perms='111100100') :chmod  111100100 == rwxr--r--
#  $browser->GetDirSize($dir) : retrun directory size
#  $browser->Rename("file_to_rename","new_name")
#  $browser->Create(f | d,"name") f: file, d: dir
#  $browser->Remove("file_to_delet")
#  $browser->RemoveDir("dir_to_delete")
#  $browser->ConvertSize(size) : convert size (byte)  to KB,MB ,GB
#  $browser->SortListF(N | D | S, ASC | DESC ) : sort files list
#  $browser->SortListD(N | D | S, ASC | DESC ) : sort dirs list
#                      N:By name, D:by date, S: by size
#  $browser->Count([char what]) : what f->file's number d->Dir's number, NULL-> both
#
#
#
# NB:You find  majority of those functions on Philex project (PHILes EXplorer)
#                    <http://philex.sourceforge.net>
##########################################################################################

defined( '_JEXEC' ) or die( 'Restricted access' );

class Navigator
{

 /******
 Vars
 ******/

 # user's setting:

 var $GetDirSz=false ;  // If you want to show the dir's size
 var $DateFormat = "d-m-Y H:i:s" ; // Date format for last update field
 ##############################################

 var $Curdir   ;
 var $DirsList  =  array("Name" =>array(),"DateM"=>array(),"Size" =>array(),
                         "Perms"=>array(),"Owner"=>array(),"Group"=>array() );
 var $FilesList =  array("Name" =>array(),"DateM"=>array(),"Size" =>array(),
                         "Perms"=>array(),"Owner"=>array(),"Group"=>array() );
 var $Handle;
 var $ErrMess;
 var $Path;
 var $OrderArrD =array();
 var $OrderArrF =array();
 var $PointerPosD;
 var $PointerPosF;


 var $FieldName;
 var $FieldDate;
 var $FieldSize;
 var $FieldPerms;
 var $FieldOwner;
 var $FieldGroup;



 /******
 Methods
 ******/

 /*
 * Constructor
 */
 function Navigator($parm,$sort_filed="N",$dir="ASC")
  {
  if(!isset($parm)) $parm = "." ;
  if(is_dir($parm)) $this->CurDir = $parm ;
  else $this->Err("Not valid directory");

  chdir($this->CurDir);
  $this->Handle=opendir(".");
  $this->LoadList()  ;
  $this->SortListF($sort_filed,$dir);
  $this->SortListD($sort_filed,$dir);
  $this->PointerPosF=0;
  $this->PointerPosD=0;
  closedir($this->Handle);
  }


 /*
 * load directories list and files list
 */
 function LoadList()
  {
  $tmp=0;
  while($file = readdir($this->Handle))
    {
      if(is_dir($file) && $file!="." && $file!=".." && $file!="index.html" && $file!="php_errorlog")
       {
         $this->DirsList["Name"][]  = $file;
         $this->DirsList["DateM"][] = $this->LastUpdate($file);
         $this->DirsList["Size"][]  = ($this->GetDirSz) ? $this->GetDirSize($file) : '' ;
         $this->DirsList["Perms"][] = $this->GetPerms($file);
         $this->DirsList["Owner"][] = fileowner($file);
         $this->DirsList["Group"][] = filegroup($file);
       }
      elseif(is_file($file) && $file!="." && $file!=".." && $file!="index.html" && $file!="php_errorlog")
       {
         $this->FilesList["Name"][]  = $file;
         $this->FilesList["DateM"][] = $this->LastUpdate($file);
         $this->FilesList["Size"][]  = filesize($file);
         $this->FilesList["Perms"][] = $this->GetPerms($file);
         $this->FilesList["Owner"][] = fileowner($file);
         $this->FilesList["Group"][] = filegroup($file);
       }
       $tmp++;
    }
  }


 /*
 * convert permession to string like -rwxr-xr--
 */
 function GetPerms($file)
  {
    switch (filetype ($file)){
        case "dir"   ;$ret2="d"; break;
        case "fifo"  ;$ret2="f"; break;
        case "char"  ;$ret2="c"; break;
        case "block" ;$ret2="b"; break;
        case "link"  ;$ret2="l"; break;
        case "file"  ;$ret2="-"; break;
        default      :$ret2="-"; break;
    }
    $ret=sprintf("%b", (fileperms($file)) & 0777);
         ( $ret[0]) ? ($ret2.="r") : ($ret2.="-");
         ( $ret[1]) ? ($ret2.="w") : ($ret2.="-");
         ( $ret[2]) ? ($ret2.="x") : ($ret2.="-");
         ( $ret[3]) ? ($ret2.="r") : ($ret2.="-");
         ( $ret[4]) ? ($ret2.="w") : ($ret2.="-");
         ( $ret[5]) ? ($ret2.="x") : ($ret2.="-");
         ( $ret[6]) ? ($ret2.="r") : ($ret2.="-");
         ( $ret[7]) ? ($ret2.="w") : ($ret2.="-");
         ( $ret[8]) ? ($ret2.="x") : ($ret2.="-");
    return $ret2;
  }


  function LastUpdate($file)
  {
   return date($this->DateFormat,filemtime($file));
  }

  function NextFile()
  {
  if(isset($this->OrderArrF))
  {
  
  $keyz= array_keys($this->OrderArrF) ;

  if(@isset($this->OrderArrF[$keyz[$this->PointerPosF]]))
   {
   //echo "z";
   $this->FieldName  =$this->FilesList["Name"][$this->OrderArrF[$keyz[$this->PointerPosF]]] ;
   $this->FieldDate  =$this->FilesList["DateM"][$this->OrderArrF[$keyz[$this->PointerPosF]]];
   $this->FieldSize  =$this->ConvertSize($this->FilesList["Size"][$this->OrderArrF[$keyz[$this->PointerPosF]]]);
   $this->FieldPerms =$this->FilesList["Perms"][$this->OrderArrF[$keyz[$this->PointerPosF]]];
   $this->FieldOwner =$this->FilesList["Owner"][$this->OrderArrF[$keyz[$this->PointerPosF]]];
   $this->FieldGroup =$this->FilesList["Group"][$this->OrderArrF[$keyz[$this->PointerPosF]]];
   $this->PointerPosF++;
   return true;
   }else return false;
   }
   else { return false; }
  }

  function NextDir()
  {

  if( isset($this->OrderArrD))
  {
  $keyz= array_keys($this->OrderArrD) ;

  if(@isset($this->OrderArrD[$keyz[$this->PointerPosD]]))
   {
   $this->FieldName  =$this->DirsList["Name"][$this->OrderArrD[$keyz[$this->PointerPosD]]] ;
   $this->FieldDate  =$this->DirsList["DateM"][$this->OrderArrD[$keyz[$this->PointerPosD]]];
   $this->FieldSize  = ($this->GetDirSz) ? $this->ConvertSize($this->DirsList["Size"][$this->OrderArrD[$keyz[$this->PointerPosD]]]) : '';
   $this->FieldPerms =$this->DirsList["Perms"][$this->OrderArrD[$keyz[$this->PointerPosD]]];
   $this->FieldOwner =$this->DirsList["Owner"][$this->OrderArrD[$keyz[$this->PointerPosD]]];
   $this->FieldGroup =$this->DirsList["Group"][$this->OrderArrD[$keyz[$this->PointerPosD]]];
   $this->PointerPosD++;
   return true;
   }else return false;
   }
   else { return false; }
  }

 /*
 * sort the files list
 */
  function SortListF($what,$direction="ASC")
  {
//  $OrderArr=array();
//  reset($this->OrderArrF);
  unset($this->OrderArrF);

  switch($what)
   {
   case "D" ; //Date
   $i = 0;
   reset($this->FilesList["DateM"]);
   while($i<count($this->FilesList["DateM"])){
        $tmp=explode(' ',$this->FilesList["DateM"][$i]);
        $key1= split('-', $tmp[0]);
        $key2= split(':', $tmp[1]);

        $key=mktime ($key2[0],$key2[1],$key2[2],$key1[1],$key1[0],$key1[2]) ;
        $this->OrderArrF[$key.'.'.$i] = $i;
        $i++;
   }

   if($direction=="ASC" and isset($this->OrderArrF) )ksort($this->OrderArrF) ;
   elseif( isset($this->OrderArrF)) krsort($this->OrderArrF) ;

   //----------------------------------
   break;

   case "S"; //Size
   $i = 0;
   reset($this->FilesList["Size"]);
   while($i<count($this->FilesList["Size"])){
        $this->OrderArrF[$this->FilesList["Size"][$i].'.'.$i] = $i;
        $i++;
   }

   if($direction=="ASC"  and isset($this->OrderArrF))ksort($this->OrderArrF) ;
   elseif(  isset($this->OrderArrF)) krsort($this->OrderArrF) ;

   //----------------------------------
   break;

   default:

   $i = 0;
   reset($this->FilesList["Name"]);
   while($i<count($this->FilesList["Name"])){
        $this->OrderArrF[strtolower($this->FilesList["Name"][$i])] = $i;   // lower case to sort a b c...A B C
                                                                    // i don't have to add $i for unicity becoz the filenames are already unique
        $i++;
   }

   if($direction=="ASC"  and isset($this->OrderArrF))ksort($this->OrderArrF) ;
   elseif(  isset($this->OrderArrF)) krsort($this->OrderArrF) ;

   //----------------------------------
   break;

   }
  }

 /*
 * sort the dirs list
 */
  function SortListD($what,$direction="ASC")
  {

  unset($this->OrderArrD);

  switch($what)
   {
   case "D" ; //Date
   $i = 0;
   reset($this->DirsList["DateM"]);
   while (list($key, $val) = each($this->DirsList["DateM"])) {
        $tmp=explode(' ',$this->DirsList["DateM"][$i]);
        $key1= split( '-', $tmp[0]);
        $key2= split( ':', $tmp[1]);

        $key=mktime ($key2[0],$key2[1],$key2[2],$key1[1],$key1[0],$key1[2]) ;
        $this->OrderArrD[$key.'.'.$i] = $i;
        $i++;
   }

   if($direction=="ASC"  and isset($this->OrderArrD))ksort($this->OrderArrD) ;
   elseif( isset($this->OrderArrD)) krsort($this->OrderArrD) ;

   //----------------------------------
   break;

   case "S"; //Size
   $i = 0;
   reset($this->DirsList["Size"]);
   while($i<count($this->DirsList["Size"])){
        $this->OrderArrD[$this->DirsList["Size"][$i].'.'.$i] = $i;
        $i++;
   }

   if($direction=="ASC"  and isset($this->OrderArrD))ksort($this->OrderArrD) ;
   elseif( isset($this->OrderArrD)) krsort($this->OrderArrD) ;

   //----------------------------------
   break;

   default:

   $i = 0;
   reset($this->DirsList["Name"]);
   while($i<count($this->DirsList["Name"])){
        $this->OrderArrD[strtolower($this->DirsList["Name"][$i])] = $i;
        $i++;
   }

   if($direction=="ASC"  and isset($this->OrderArrD))ksort($this->OrderArrD) ;
   elseif( isset($this->OrderArrD)) krsort($this->OrderArrD) ;

   //----------------------------------
   break;
   }

  }

 /*
 * return element's number  what: d total dirs, f: total files
 */
 function Count($what="")
  {
  switch($what)
  {case "d": return count($this->DirsList["Name"]);break;
   case "f": return count($this->FilesList["Name"]);break;
   default: return  count($this->DirsList["Name"])+count($this->FilesList["Name"]);break;
  }
  }

 /*
 * current directory
 */
 function Pwd()
  {
  return realpath(".");
  }

 /*
 * chmod
 */
 function ChgPerms($file,$perms='111100100') //rwxrwxrwx
  {
  $dec =bindec ($perms);
  $oct =decoct ($dec);
  if(!chmod( $file, '0'.octdec($oct) )) $this->Err("Oups , error whene setting perms");
  }


 /*
 * get all directory size
 */
 function GetDirSize($dir)
  {
  $dossier=opendir($dir);
  $total=0;
  while ($fichier = readdir($dossier))
   {
   $l = array('.', '..');
   if (!in_array( $fichier, $l))
    {
     if (is_dir($dir."/".$fichier))
     {
     $total += $this->GetDirSize($dir."/".$fichier);
     }
     else
     {
     $total+=filesize($dir."/".$fichier);
     }
    }
   }
  return $total;
  }

 /*
 * renaming
 */
 function Rename($old,$new)
  {
   if (file_exists($old))
   {
    if(!file_exists($new)) rename($old,$new);
    else $this->Err("$new already exists !");
   }
   else $this->Err("$old doesn't exist !");
  }


 /*
 * Create file/dir
 */
 function Create($what,$name)
  {
  switch($what)
   {
   case "f";
    if (!file_exists($name))
     {if(!$fp=fopen($name,"w")) $this->Err("Cannot create this file : $name") ;
      else fclose($fp);
     }else  $this->Err("$name already exists !");
   break;
   case "d";
    if (!file_exists($name))
    {if(!mkdir ($name, 0700)){ $this->Err("Cannot create this directory : $name");}
    }else  {$this->Err("$new already exists !"); }
   break;
   }
  }

 /*
 * remove a file
 */
 function Remove($file)
  {
  if(!@unlink($file)) $this->Err("Cannot delete file : $file");
  }


 /*
 * remove directory (recursive)
 */
 function RemoveDir($dir)
  {
    if($handle=@opendir($dir))
     {
     while ($file=readdir($handle))
           {
           if (is_dir($dir."/".$file) && $file !=".." && $file!="." )
              {
              $this->RemoveDir($dir."/".$file);
              if (file_exists($dir."/".$file))
                 {
                 rmdir($dir."/".$file);
                 }
              }
              else
               {
               if (is_file($dir."/".$file) && file_exists($dir."/".$file))
                {
                unlink($dir."/".$file);
                }
               }
           }
     closedir($handle);
     rmdir($dir);
     }
     else $this->Err("Cannot delete directory : $dir") ;
  }



 /*
 * convert size to KB, MB, GB
 */
 function ConvertSize($sz)
  {
  if ($sz >= 1073741824)  {$sz = round($sz / 1073741824 * 100) / 100 . " GB";}
  elseif ($sz >= 1048576) {$sz = round($sz / 1048576 * 100)    / 100 . " MB";}
  elseif ($sz >= 1024)    {$sz = round($sz / 1024 * 100)       / 100 . " KB";}
  else                    {$sz = $sz . " Bytes";}

  return $sz;
  }


 /*
 * Stop execution with error message
 */
 function Err($mess)
  {
  $this->ErrMess = $mess;
  echo "<font color=red>$mess</font><br>";
  exit;
  }

}
?>
