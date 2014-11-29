<?php

class Article extends Eloquent {
	protected $guarded = [];

	public static function giveArticles() {
		$articles = new Article;
		$articles = $articles->orderBy('priority', 'ASC');
		$articles = $articles->get();
		return $articles;
	}

	public static function giveArticleById($id) {
		$article = new Article;
		$article = $article->find($id);
		return $article;
	}
}