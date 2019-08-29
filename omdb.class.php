<?php

require 'tinyHttp.class.php';

class omdb_request
{
	private $url;
	private $apikey = '2a08448';
	private $h;

	public function
	__construct()
	{
		$this -> url = new tinyUrl();
		$this -> url -> setQuery([
			'apikey' => $this -> apikey,
			'r' => 'json'
		]);
		$this -> url -> setScheme('http');
		$this -> url -> setHost('www.omdbapi.com');
	}

	public function
	setParm (string $name, string $value): void
	{
		$this -> url -> addQuery ($name, $value);
	}

	public function
	fetch(): array
	{
		$this -> h = new tinyHttp ($this -> url);
		try
		{
			$r = $this -> h -> send();
			$code = $r -> getStatus();
			if ($code != 200)
				throw new Exception('http code: ' . $code);
			$body = $r -> getBody(); // string, can be empty
			$json = json_decode ($body, true);
			if ($json['Response'] == 'False')
				throw new Exception ('OMDB error: ' . $json['Error']);
			return $json;
		} catch (tinyHttp_Exception $e) {
			throw new Exception ('omdb class error: ' . $e -> getMessage());
		}

	}

	public function
	getUrl(): tinyUrl
	{
		return $this -> url;
	}
}

class omdb
{
	private $rq;

	public function
	__construct()
	{
		$this -> rq = new omdb_request();
	}

	public function
	queryById (string $imdb_id): array
	{
		$this -> rq -> setParm ('i', $imdb_id);
		$result = $this -> rq -> fetch();
		return $result;
	}

	public function
	getUrl(): tinyUrl
	{
		return $this -> rq -> getUrl();
	}

	public static function
	getVersion(): string
	{
		return '1.0';
	}
	
}

?>
