<?php
    define('FPDF_FONTPATH','../font');
    require('fpdf.php');
    
    class PDF_MySQL_Table extends FPDF{
        protected $ProcessingTable=false;
        protected $aCols=array();
        protected $TableX;
        protected $HeaderColor;
        protected $RowColors;
        protected $ColorIndex;

        function Header()
        {
            // Print the table header if necessary
            if($this->ProcessingTable)
                $this->TableHeader();
        }

        function TableHeader()
        {
            $this->SetFont('Arial','B',12);
            $this->SetX($this->TableX);
            $fill=!empty($this->HeaderColor);
            if($fill)
                $this->SetFillColor($this->HeaderColor[0],$this->HeaderColor[1],$this->HeaderColor[2]);
            foreach($this->aCols as $col)
                $this->Cell($col['w'],6,$col['c'],1,0,'C',$fill);
            $this->Ln();
        }

        function Row($data)
        {
            $this->SetX($this->TableX);
            $ci=$this->ColorIndex;
            $fill=!empty($this->RowColors[$ci]);
            if($fill)
                $this->SetFillColor($this->RowColors[$ci][0],$this->RowColors[$ci][1],$this->RowColors[$ci][2]);
            foreach($this->aCols as $col)
                $this->Cell($col['w'],5,$data[$col['f']],1,0,$col['a'],$fill);
            $this->Ln();
            $this->ColorIndex=1-$ci;
        }

        function CalcWidths($width, $align)
        {
            // Compute the widths of the columns
            $TableWidth=0;
            foreach($this->aCols as $i=>$col)
            {
                $w=$col['w'];
                if($w==-1)
                    $w=$width/count($this->aCols);
                elseif(substr($w,-1)=='%')
                    $w=$w/100*$width;
                $this->aCols[$i]['w']=$w;
                $TableWidth+=$w;
            }
            // Compute the abscissa of the table
            if($align=='C')
                $this->TableX=max(($this->w-$TableWidth)/2,0);
            elseif($align=='R')
                $this->TableX=max($this->w-$this->rMargin-$TableWidth,0);
            else
                $this->TableX=$this->lMargin;
        }

        function AddCol($field=-1, $width=-1, $caption='', $align='L')
        {
            // Add a column to the table
            if($field==-1)
                $field=count($this->aCols);
            $this->aCols[]=array('f'=>$field,'c'=>$caption,'w'=>$width,'a'=>$align);
        }

        function Table($link, $query, $prop=array())
        {
            // Execute query
            $res=mysqli_query($link,$query) or die('Error: '.mysqli_error($link)."<br>Query: $query");
            // Add all columns if none was specified
            if(count($this->aCols)==0)
            {
                $nb=mysqli_num_fields($res);
                for($i=0;$i<$nb;$i++)
                    $this->AddCol();
            }
            // Retrieve column names when not specified
            foreach($this->aCols as $i=>$col)
            {
                if($col['c']=='')
                {
                    if(is_string($col['f']))
                        $this->aCols[$i]['c']=ucfirst($col['f']);
                    else
                        $this->aCols[$i]['c']=ucfirst(mysqli_fetch_field_direct($res,$col['f'])->name);
                }
            }
            // Handle properties
            if(!isset($prop['width']))
                $prop['width']=0;
            if($prop['width']==0)
                $prop['width']=$this->w-$this->lMargin-$this->rMargin;
            if(!isset($prop['align']))
                $prop['align']='C';
            if(!isset($prop['padding']))
                $prop['padding']=$this->cMargin;
            $cMargin=$this->cMargin;
            $this->cMargin=$prop['padding'];
            if(!isset($prop['HeaderColor']))
                $prop['HeaderColor']=array();
            $this->HeaderColor=$prop['HeaderColor'];
            if(!isset($prop['color1']))
                $prop['color1']=array();
            if(!isset($prop['color2']))
                $prop['color2']=array();
            $this->RowColors=array($prop['color1'],$prop['color2']);
            // Compute column widths
            $this->CalcWidths($prop['width'],$prop['align']);
            // Print header
            $this->TableHeader();
            // Print rows
            $this->SetFont('Arial','',11);
            $this->ColorIndex=0;
            $this->ProcessingTable=true;
            while($row=mysqli_fetch_array($res))
                $this->Row($row);
            $this->ProcessingTable=false;
            $this->cMargin=$cMargin;
            $this->aCols=array();
}
}

 if (isset($_GET["messaggio"])) {
    $messaggio = $_GET["messaggio"];
    $messaggio = iconv('UTF-8', 'windows-1252', $messaggio);
  }
  
class PDF extends PDF_MySQL_Table{
function Header()
{
    // Title
    $this->SetFont('Times','',25);
    $this->Cell(0,6,'Resoconto PCTO',0,1,'C');
    $this->Ln(10);
    // Ensure table header is printed
    parent::Header();
}
}

    // Connect to database
    $link = mysqli_connect('localhost','root','','my_antoniochieppa');
    
    $pdf = new PDF();
    $pdf->AddPage();
    
    $pdf->SetFont('Arial','',12);
    $pdf->MultiCell(0, 5, "$messaggio", 0, 'center');
    
    //tabella registro
    $pdf->SetFont('Times','',18);
    $pdf->Cell(0, 15, "Registro Attivita'",0,1,'C');
    $pdf->AddCol('attivitaPrevista',65,'Attivita','L');
    $pdf->AddCol('nomeDisciplina',30,'Disciplina','L');
    $pdf->AddCol('cognome',20,'Docente','L');
    $pdf->AddCol('dataAttivita',25,'Data','L');
    $pdf->AddCol('numOre',15,'Ore','C');
    $pdf->AddCol('materialiDistribuiti',30,'Materiali','L');
    $pdf->AddCol('anno',10,'An.','L');
    $pdf->AddCol('sezione',10,'Sez.','L');
    $prop = array('HeaderColor'=>array(240,248,255),
                'color1'=>array(100,149,237),
                'color2'=>array(175,238,238),
                'padding'=>2);
    $pdf->Table($link,"SELECT attivitaPrevista,nomeDisciplina,cognome,dataAttivita,numOre,materialiDistribuiti,anno,sezione FROM tabRegistroAttivita INNER JOIN tabAttivitaProgrammate ON tabRegistroAttivita.idAtt=tabAttivitaProgrammate.IdAtt INNER JOIN tabDiscipline ON tabRegistroAttivita.idDisciplina=tabDiscipline.idDisciplina INNER JOIN tabClassi ON tabRegistroAttivita.idClasse=tabClassi.idClasse INNER JOIN tabUtenti ON tabRegistroAttivita.idUtente=tabUtenti.idUtente WHERE ruolo='docente' ",$prop);
    
   
    //tabella assenze
    $pdf->SetFont('Times','',18);
    $pdf->Cell(0, 16, 'Assenze',0,1,'C');
    $pdf->AddCol('cognome',35," Cognome",'L');
    $pdf->AddCol('nome',35,'Nome','L');
    $pdf->AddCol('attivitaPrevista',65,'Attivita','L');
    $pdf->AddCol('numOreAssenza',40,'Ore di Assenza','C');
    $prop = array('HeaderColor'=>array(240,248,255),
                'color1'=>array(100,149,237),
                'color2'=>array(175,238,238),
                'padding'=>2);
    $pdf->Table($link,"select cognome,nome,attivitaPrevista,numOreAssenza from tabAssenze INNER JOIN tabRegistroAttivita ON tabAssenze.idRegistro=tabRegistroAttivita.idRegistro INNER JOIN tabAttivitaProgrammate ON tabRegistroAttivita.idAtt=tabAttivitaProgrammate.IdAtt INNER JOIN tabStudenti ON tabAssenze.idStudente=tabStudenti.idStudente",$prop);
      
    $pdf->Output();
?>
