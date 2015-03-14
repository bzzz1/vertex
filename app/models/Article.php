<?php

class Article extends Eloquent {
	protected $guarded = ['id'];
	public $timestamps = false;

	// treat time column as Carbon instance
	protected $dates = ['time'];

	public function setTimeAttribute($date) {
		$this->attributes['time'] = Carbon::createFromFormat('Y-m-d', $date);
		// $this->attributes['time'] = Carbon::parse($date);
	}

	public function getTimeAttribute($date) {
		return new Carbon($date);
	}
/*------------------------------------------------
| READ
------------------------------------------------*/
	public static function readArticles() {
		$articles = new Article;
		$articles = $articles->orderBy('time', 'DESC');
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