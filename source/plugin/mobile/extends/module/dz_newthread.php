<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: dz_newthread.php 31281 2012-08-03 02:29:27Z zhangjie $
 */
class dz_newthread extends extends_data {
	function __construct() {
		parent::__construct();
	}

	function common() {
		global $_G;
		$this->page = intval($_GET['page']) ? intval($_GET['page']) : 1;
		loadcache('forum_guide');
		$dateline = 0;
		$maxnum = 50000;
		if($_G['setting']['guide']['newdt']) {
			$dateline = time() - intval($_G['setting']['guide']['newdt']);
		}
		$maxtid = C::t('forum_thread')->fetch_max_tid();
		$limittid = max(0,($maxtid - $maxnum));
		$tids = array_slice($_G['cache']['forum_guide']['new']['data'], ($this->page - 1)*$this->perpage ,$this->perpage);
		$query = C::t('forum_thread')->fetch_all_for_guide('new', $limittid, $tids, $_G['setting']['heatthread']['guidelimit'], $dateline);
		$threadlist = array();
		rsort($query);

		foreach($query as $thread) {
			$this->field('author', '0', $thread['author']);
			$this->field('dateline', '0', $thread['dateline']);
			$this->field('replies', '1', $thread['replies']);
			$this->field('views', '2', $thread['views']);
			$this->id = $thread['tid'];
			$this->title = $thread['subject'];
			$this->image = '';
			$this->icon = '1';
			$this->poptype = '0';
			$this->popvalue = '';
			$this->clicktype = 'tid';
			$this->clickvalue = $thread['tid'];

			$this->insertrow();

		}
	}

}
?>