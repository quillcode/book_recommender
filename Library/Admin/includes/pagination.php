<?php
 
class Pagination {

	public $current_page;
	public $per_page;
	public $total_count; // total records

	public function __construct($page=1, $per_page=6, $total_count=0) {
		$this->current_page = (int) $page;
		$this->per_page = (int) $per_page;
		$this->total_count = (int) $total_count;
	}

	public function offset() { // from which array index it should START. current pg = 1 then 1-1=0 will start to show books or users from the 0 index. if i set offset = 9 then it will not show the books from 0 until 8. it will only start to pick up records from db started from number 9.
		return ($this->current_page - 1) * $this->per_page;
	}

	public function total_pages() { // how many pages we will have dependent on total number of books or students and the number of books or std that we wanna show it per page.
		return ceil($this->total_count/$this->per_page); // 120 / 6 = 20  , ceil = round up
	}
 
	public function previous_page() { // go to prev page.
		return $this->current_page - 1;
	}

	public function next_page() {   // go to next page.
		return $this->current_page + 1;
	}

	public function has_previous_page() {  // check does current page has prev page.
		return $this->previous_page() >= 1 ? true : false;
	}

	public function has_next_page() {  // check does current page has next page.
		return $this->next_page() <= $this->total_pages() ? true : false; 
	}
}

?>