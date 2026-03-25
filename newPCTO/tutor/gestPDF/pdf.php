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
    //tabella classi
    $pdf->SetFont('Times','',18);
    $pdf->Cell(0, 15, 'Classi',0,1,'C');
    $pdf->AddCol('anno',30,'','L');
    $pdf->AddCol('sezione',40,'','L');
    $pdf->AddCol('nomeIndirizzo',60,'Nome Indirizzo','L');
    $prop = array('HeaderColor'=>array(240,248,255),
                'color1'=>array(100,149,237),
                'color2'=>array(175,238,238),
                'padding'=>2);
    $pdf->Table($link,'SELECT anno,sezione,nomeIndirizzo FROM tabClassi INNER JOIN tabIndirizzi ON tabClassi.idIndirizzo=tabIndirizzi.idIndirizzo',$prop);
    
    //tabella studenti
    $pdf->SetFont('Times','',18);
    $pdf->Cell(0, 15, 'Studenti',0,1,'C');
    $pdf->AddCol('cognome',25,'','L');
    $pdf->AddCol('nome',25,'','L');
    $pdf->AddCol('dataNascita',30,'data di N.','L');
    $pdf->AddCol('luogoNascita',40,'luogo di nascita','L');
    $pdf->AddCol('anno',20,'Anno','L');
    $pdf->AddCol('sezione',20,'SEZ.','L');
    $pdf->AddCol('nomeIndirizzo',40,'Indirizzo','L');
    $prop = array('HeaderColor'=>array(240,248,255),
                'color1'=>array(100,149,237),
                'color2'=>array(175,238,238),
                'padding'=>2);
    $pdf->Table($link,'SELECT cognome,nome,dataNascita,luogoNascita,anno,sezione,nomeIndirizzo FROM tabStudenti INNER JOIN tabClassi ON tabStudenti.idClasse=tabClassi.idClasse INNER JOIN tabIndirizzi ON tabClassi.idIndirizzo=tabIndirizzi.idIndirizzo order by cognome',$prop);
    
    // tabella utenti
    $pdf->SetFont('Times','',18);
    $pdf->Cell(0, 16, 'Utenti',0,1,'C');
    $pdf->AddCol('cognome',30,'','L');
    $pdf->AddCol('nome',40,'','L');
    $pdf->AddCol('email',60,'','L');
    $pdf->AddCol('ruolo',40,'','L');
    $prop = array('HeaderColor'=>array(240,248,255),
                'color1'=>array(100,149,237),
                'color2'=>array(175,238,238),
                'padding'=>2);
    $pdf->Table($link,'select cognome,nome,email,ruolo from tabUtenti order by cognome',$prop);
    
    $pdf->AddPage();
    // tabella programmazione
    $pdf->SetFont('Times','',18);
    $pdf->Cell(0, 16, 'Attivita Programmate',0,1,'C');
    $pdf->AddCol('attivitaPrevista',70," Attivita':",'L');
    $pdf->AddCol('ore',15,'','L');
    $pdf->AddCol('stato',30,'','L');
    $pdf->AddCol('nomeDisciplina',40,'Disciplina','L');
    $prop = array('HeaderColor'=>array(240,248,255),
                'color1'=>array(100,149,237),
                'color2'=>array(175,238,238),
                'padding'=>2);
    $pdf->Table($link,'select attivitaPrevista,ore,stato,nomeDisciplina from tabAttivitaProgrammate INNER JOIN tabDiscipline ON tabAttivitaProgrammate.idDisciplina=tabDiscipline.idDisciplina',$prop);
    
    
    // tabella valutazioni
    $pdf->SetFont('Times','',18);
    $pdf->Cell(0, 16, 'Valutazioni',0,1,'C');
    $pdf->AddCol('voto',30," Valutazione",'C');
    $pdf->AddCol('descrizione',50,'','L');
    $pdf->AddCol('cognome',30,'Cognome','L');
    $pdf->AddCol('nome',40,'Nome','L');
    $prop = array('HeaderColor'=>array(240,248,255),
                'color1'=>array(100,149,237),
                'color2'=>array(175,238,238),
                'padding'=>2);
    $pdf->Table($link,'select voto,descrizione,cognome,nome from tabValutazioni INNER JOIN tabStudenti ON tabValutazioni.idStudente=tabStudenti.idStudente',$prop);
    
    //tabella discipline
    $pdf->SetFont('Times','',18);
    $pdf->Cell(0, 16, 'Discipline',0,1,'C');
    $pdf->AddCol('nomeDisciplina',60," Disciplina",'L');
    $pdf->AddCol('cognome',40,'Cognome','L');
    $pdf->AddCol('nome',40,'Nome','L');
    $prop = array('HeaderColor'=>array(240,248,255),
                'color1'=>array(100,149,237),
                'color2'=>array(175,238,238),
                'padding'=>2);
    $pdf->Table($link,"select nomeDisciplina,cognome,nome from tabDiscipline INNER JOIN tabUtenti ON tabDiscipline.idUtente=tabUtenti.idUtente WHERE ruolo='docente'",$prop);
    
    //tabella indirizzi
    $pdf->SetFont('Times','',18);
    $pdf->Cell(0, 16, 'Indirizzi scolastici',0,1,'C');
    $pdf->AddCol('nomeIndirizzo',60," Tipo Indirizzo",'L');
    $prop = array('HeaderColor'=>array(240,248,255),
                'color1'=>array(100,149,237),
                'color2'=>array(175,238,238),
                'padding'=>2);
    $pdf->Table($link,"select nomeIndirizzo from tabIndirizzi",$prop);
    
    
    $pdf->Output();
?>
