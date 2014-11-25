<?php 
// http://laravel.com/docs/4.2/pagination#custom-presenters
class ZurbPresenter extends Illuminate\Pagination\Presenter {

	public function render() {
		// The hard-coded thirteen represents the minimum number of pages we need to
		// be able to create a sliding page window. If we have less than that, we
		// will just render a simple range of page links insteadof the sliding.
		/*------------------------------------------------
		| >>beststrelok<<
		------------------------------------------------*/
		// https://gist.github.com/beststrelok/17a6328d75da5492860d/revisions
		// http://laravel.com/docs/4.2/pagination#custom-presenters
		/*----------------------------------------------*/
		if ($this->lastPage < 7)
		{
			$content = $this->getPageRange(1, $this->lastPage);
		}
		else
		{
			$content = $this->getPageSlider();
		}

		return $content;
	}

	public function getPageRange($start, $end) {
		$pages = array();

		for ($page = $start; $page <= $end; $page++)
		{
			// If the current page is equal to the page we're iterating on, we will create a
			// disabled link for that page. Otherwise, we can create a typical active one
			// for the link. We will use this implementing class's methods to get HTML.
			if ($this->currentPage == $page)
			{
				$pages[] = $this->getActivePageWrapper($page);
			}
			else
			{
				$pages[] = $this->getLink($page);
			}
		}

		return implode('', $pages);
	}

	protected function getPageSlider() {
		$window = 2;

		// If the current page is very close to the beginning of the page range, we will
		// just render the beginning of the page range, followed by the last 2 of the
		// links in this list, since we will not have room to create a full slider.
		if ($this->currentPage <= $window)
		{
			$ending = $this->getFinish();

			return $this->getPageRange(1, $window+1).$ending;
		}

		// If the current page is close to the ending of the page range we will just get
		// this first couple pages, followed by a larger window of these ending pages
		// since we're too close to the end of the list to create a full on slider.
		elseif ($this->currentPage > $this->lastPage - $window)
		{
			$start = $this->lastPage - 2;

			$content = $this->getPageRange($start, $this->lastPage);

			return $this->getStart().$content;
		}

		// If we have enough room on both sides of the current page to build a slider we
		// will surround it with both the beginning and ending caps, with this window
		// of pages in the middle providing a Google style sliding paginator setup.
		else
		{
			$content = $this->getAdjacentRange();

			return $this->getStart().$content.$this->getFinish();
		}
	}

	public function getAdjacentRange() {
		return $this->getPageRange($this->currentPage - 1, $this->currentPage + 1);
	}

	public function getStart() {
		return $this->getPageRange(1, 1).$this->getDots();
	}

// http://laravel.com/docs/4.2/pagination#custom-presenters
	public function getActivePageWrapper($text) {
        return '<li class="current"><a href="">'.$text.'</a></li>';
    }

    public function getDisabledTextWrapper($text) {
        return '<li class="unavailable"><a href="">'.$text.'</a></li>';
    }

    public function getPageLinkWrapper($url, $page, $rel = null) {
        return '<li><a href="'.$url.'">'.$page.'</a></li>';
    }
}