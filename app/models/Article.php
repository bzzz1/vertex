<?php

class Article extends Eloquent {
	protected $guarded = ['id'];
	public $timestamps = false;
/*------------------------------------------------
| READ
------------------------------------------------*/
	public static function readArticles() {
		$articles = new Article;
		$articles = $articles->orderBy('priority', 'ASC');
		$articles = $articles->get();
		return $articles;
	}

	public static function readArticleById($id) {
		$article = new Article;
		$article = $article->find($id);
		return $article;
	}
/*------------------------------------------------
| CREATE UPDATE
------------------------------------------------*/
	public static function updateOrCreateArticleById($id, $fields) {
		$id ? $article = Article::find($id) : $article = new Article;
		$article->fill($fields);
		$article->save();
	}
/*------------------------------------------------
| DELETE
------------------------------------------------*/
	public static function deleteArticleById($id) {
		Article::where('id', $id)->delete();
	}

}