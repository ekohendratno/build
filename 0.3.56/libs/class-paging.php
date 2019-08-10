<?php 
/**
 * @fileName: class-paging.php
 * @dir: ilibs/
 */
if(!defined('_iEXEC')) exit;

class paging_admin{
	private $page;
	private $totalPages;
	private $separator;
	private $maxPages;
	public function __construct(){
		$this->separator="&amp;";
		$this->maxPages	=10;
	}
	public function setSeparator($char){
		$this->separator=$char;
	}
	public function setMaxPages($maxPages){
		$this->maxPages=$maxPages;
	}
	public function query($sql, $rowsPerPage){
		global $db;
		$page		=(int)isset($_GET['pg']) ? $_GET['pg'] : 1;
		$result		=$db->query($sql);
		$totalRows	=$db->num($result);
		
		$this->totalPages=intval($totalRows/$rowsPerPage) + ($totalRows%$rowsPerPage==0 ? 0 : 1);
		if($this->totalPages<1){
			$this->totalPages=1;
		}
		
		$this->page=intval($page);
		if($this->page<1){
			$this->page=1;
		}
		if($this->page>$this->totalPages){
			$this->page=$this->totalPages;
		}
		
		$this->page-=1;
		if($this->page<0){
			$this->page=0;
		}
		
		$result		=$db->query($sql." LIMIT ".$this->page*$rowsPerPage.", ".$rowsPerPage);
		$this->page+=1;
		
		return $result;
	}
	public function pg($link){
		$start=((($this->page%$this->maxPages==0) ? ($this->page/$this->maxPages) : intval($this->page/$this->maxPages)+1)-1)*$this->maxPages+1;
		$end=((($start+$this->maxPages-1)<=$this->totalPages) ? ($start+$this->maxPages-1) : $this->totalPages);
		
		$paging='<ul class="paging">';
		if($this->page>1){
			$paging.='<li><a href="'.$link.$this->separator.'pg=1" title="Halaman Pertama">&laquo;&laquo;</a></li>';
			$paging.='<li><a href="'.$link.$this->separator.'pg='.($this->page-1).'" title="Halaman Sebelumnya">&laquo; Sebelumnya</a></li>';
		}
		
		if($start>$this->maxPages){
			$paging.='<li><a href="'.$link.$this->separator.'pg='.($start-1).'" title="Halaman '.($start-1).'">...</a></li>';
		}
		
		for($i=$start;$i<=$end;$i++){
			if($this->page==$i){
				$paging.='<li class="current">'.$i.'</li>';
			}
			else{
				$paging.='<li><a href="'.$link.$this->separator.'pg='.$i.'" title="Halaman '.$i.'">'.$i.'</a></li>';
			}
		}
		
		if($end<$this->totalPages){
			$paging.='<li><a href="'.$link.$this->separator.'pg='.($end+1).'" title="Halaman '.($end+1).'">...</a></li>';
		}
		
		if($this->page<$this->totalPages){
			$paging.='<li><a href="'.$link.$this->separator.'pg='.($this->page+1).'" title="Halaman Berikutnya">Berikutnya &raquo;</a></li>';
			$paging.='<li><a href="'.$link.$this->separator.'pg='.$this->totalPages.'" title="Halaman Terakhir">&raquo;&raquo;</a></li>';
		}
		$paging.='<ul>';
		
		return $paging;
	}
}

class paging{
	private $page;
	private $totalPages;
	private $separator;
	private $maxPages;
	public function __construct(){
		$this->separator = "&amp;";
		$this->maxPages	 = 10;
	}
	public function setSeparator($char){
		$this->separator=$char;
	}
	public function setMaxPages($maxPages){
		$this->maxPages=$maxPages;
	}
	public function query($sql, $rowsPerPage){
		global $db;
		$page		=(int)isset($_GET['pg']) ? $_GET['pg'] : 1;
		$result		=$db->query($sql);
		$totalRows	=$db->num($result);
		
		$this->totalPages=intval($totalRows/$rowsPerPage) + ($totalRows%$rowsPerPage==0 ? 0 : 1);
		if($this->totalPages<1){
			$this->totalPages=1;
		}
		
		$this->page=intval($page);
		if($this->page<1){
			$this->page=1;
		}
		if($this->page>$this->totalPages){
			$this->page=$this->totalPages;
		}
		
		$this->page-=1;
		if($this->page<0){
			$this->page=0;
		}
		
		$result		=$db->query($sql." LIMIT ".$this->page*$rowsPerPage.", ".$rowsPerPage);
		$this->page+=1;
		
		return $result;
	}
	public function links($param,$pg = null,$data = null){
		if( !empty($data) &&  !empty($pg) )
		return do_links( $param, $data + $pg);
		else return do_links( $param, $pg);
	}
	public function pg( $param = null, $data = null ){
			
		$start=((($this->page%$this->maxPages==0) ? ($this->page/$this->maxPages) : intval($this->page/$this->maxPages)+1)-1)*$this->maxPages+1;
		$end=((($start+$this->maxPages-1)<=$this->totalPages) ? ($start+$this->maxPages-1) : $this->totalPages);
		
		$paging='<ul class="paging">';
		
		if($this->page>1){
			$paging.='<li><a href="'.$this->links( $param, array( 'pg'=> 1),$data ).'" title="Halaman Pertama">&laquo;&laquo;</a></li>';
			$paging.='<li><a href="'.$this->links( $param, array( 'pg'=> ($this->page-1) ),$data).'" title="Halaman Sebelumnya">&laquo; Sebelumnya</a></li>';
		}
		
		if($start>$this->maxPages){
			$paging.='<li><a href="'.$this->links( $param, array( 'pg'=> ($start-1) ),$data ).'" title="Halaman '.($start-1).'">...</a></li>';
		}
		
		for($i=$start;$i<=$end;$i++){
			if($this->page==$i){
				$paging.='<li class="current">'.$i.'</li>';
			}
			else{
				$paging.='<li><a href="'.$this->links( $param, array( 'pg'=> $i ),$data ).'" title="Halaman '.$i.'">'.$i.'</a></li>';
			}
		}
		
		if($end<$this->totalPages){
			$paging.='<li><a href="'.$this->links( $param, array( 'pg'=> ($end+1) ),$data ).'" title="Halaman '.($end+1).'">...</a></li>';
		}
		
		if($this->page<$this->totalPages){
			$paging.='<li><a href="'.$this->links( $param, array( 'pg'=>($this->page+1) ),$data ).'" title="Halaman Berikutnya">Berikutnya &raquo;</a></li>';
			$paging.='<li><a href="'.$this->links( $param, array( 'pg'=>$this->totalPages ),$data ).'" title="Halaman Terakhir">&raquo;&raquo;</a></li>';
		}
		
		$paging.='</ul>';
		
		return $paging;
	}
}
